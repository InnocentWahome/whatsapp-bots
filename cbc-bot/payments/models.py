from datetime import timedelta

from django.core.validators import MinValueValidator, MaxValueValidator
from django.db import models
from schools.models import Subscription
from root.settings import MONTHLY_RATE, TERMLY_RATE, DAILY_RATE


class Transaction(models.Model):
    payment_id = models.CharField(max_length=64, null=True, unique=True)
    mpesa_code = models.CharField(max_length=64, null=True, unique=True)
    phone = models.CharField(max_length=30)
    reason_failed = models.TextField(null=True)
    amount = models.FloatField(validators=[MinValueValidator(0), MaxValueValidator(70000)])
    transaction_cost = models.DecimalField(max_digits=9, decimal_places=2, null=True)
    transaction_date = models.DateTimeField(auto_now=True)
    created_on = models.DateTimeField(auto_now_add=True)
    account_number = models.CharField(max_length=20, null=True)
    paybill_number = models.CharField(max_length=20, null=True)

    TRANSACTION_STATE = (
        ('requested', 'Payment Requested'),
        ('pending', 'Pending'),
        ('failed', 'Failed'),
        ('success', 'Success')
    )
    state = models.CharField(choices=TRANSACTION_STATE, max_length=10, default='requested')

    @property
    def is_requested(self):
        return self.state == 'requested'

    @property
    def is_success(self):
        return self.state == 'success'

    @property
    def is_fail(self):
        return self.state == 'failed'

    @property
    def is_pending(self):
        return self.state == 'pending'

    def set_pending(self, payment_id, paybill_number=None, account_number=None):
        self.payment_id = payment_id
        self.paybill_number = paybill_number
        self.account_number = account_number
        self.state = 'pending'
        self.save()

    def set_fail(self, payment_id, reason_failed):
        self.state = 'failed'
        assert self.payment_id == payment_id
        self.reason_failed = reason_failed
        self.save()

    def set_success(self, **kwargs):
        raise NotImplementedError("Implement set success")

    class Meta:
        abstract = True


class SubscriptionTransactionManager(models.Manager):
    def create(self, amount: float, subscription: Subscription, phone: str, package):
        assert package in ['custom', 'monthly', 'termly']
        if package == 'monthly':
            assert MONTHLY_RATE == amount
        if package == 'termly':
            assert TERMLY_RATE == amount
        return super().create(
            amount=amount,
            subscription=subscription,
            phone=phone,
            package=package,
        )


class SubscriptionTransaction(Transaction):
    subscription = models.ForeignKey(
        Subscription,
        on_delete=models.CASCADE,
        related_name='transactions'
    )
    package = models.CharField(
        max_length=10,
        choices=(
            ('termly', 'Per Term'),
            ('monthly', 'Per Month'),
            ('custom', 'Custom Payment')
        ),
        default='custom'
    )

    objects = SubscriptionTransactionManager()

    def set_success(self, payment_id, mpesa_code):
        self.mpesa_code = mpesa_code
        self.state = 'success'
        assert self.payment_id == payment_id
        self.save()
        # add the amount to the subscription balance
        self.subscription.balance += self.amount
        if self.package == 'monthly':
            self.subscription.expiry_date += timedelta(days=30)
        elif self.package == 'termly':
            self.subscription.expiry_date += timedelta(days=120)
        else:
            self.subscription.expiry_date += timedelta(days=self.amount / DAILY_RATE)
        self.subscription.save()
