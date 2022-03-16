import asyncio
from datetime import timedelta

from django.db import models
from django.db.models.signals import post_save
from django.dispatch import receiver
from django.utils import timezone
from accounts.models import User
from root import settings
from root.settings import WHATSAPP_COST


class School(models.Model):
    name = models.CharField(max_length=50)
    is_verified = models.BooleanField()

    def __str__(self):
        return self.name


class Branch(models.Model):
    name = models.CharField(max_length=50)
    school = models.ForeignKey(School, on_delete=models.CASCADE, related_name='branches')

    def __str__(self):
        return self.name


class Class(models.Model):
    name = models.CharField(max_length=50)
    branch = models.ForeignKey(Branch, on_delete=models.CASCADE, related_name='classes')

    def __str__(self):
        return self.name


class Stream(models.Model):
    name = models.CharField(max_length=50)
    stream_class = models.ForeignKey(Class, on_delete=models.CASCADE, related_name='streams')

    def __str__(self):
        return self.name


class Student(models.Model):
    name = models.CharField(max_length=50)
    student_code = models.CharField(max_length=50)
    branch = models.ForeignKey(Branch, on_delete=models.CASCADE, null=True)
    stream = models.ForeignKey(Stream, on_delete=models.SET_NULL, null=True, related_name='students')

    def __str__(self):
        return self.name

    class Meta:
        unique_together = (
            ('student_code', 'branch')
        )


class Teacher(models.Model):
    user = models.ForeignKey(User, on_delete=models.CASCADE, related_name='teachers')
    name = models.CharField(max_length=50)
    phone = models.CharField(max_length=20)
    branch = models.ForeignKey(Branch, on_delete=models.CASCADE, related_name='teachers')

    def __str__(self):
        return f'{self.name}-{self.branch.name}'

    class Meta:
        unique_together = (
            ('user', 'branch')
        )


class Subject(models.Model):
    name = models.CharField(max_length=50)
    description = models.TextField()
    school = models.ForeignKey(School, on_delete=models.CASCADE, null=True, related_name='subjects')

    def __str__(self):
        return f'{self.name}-{self.school.name}'


class Assignment(models.Model):
    name = models.CharField(max_length=50)
    description = models.TextField()
    teacher = models.ForeignKey(Teacher, on_delete=models.CASCADE, related_name='assignments')
    stream = models.ForeignKey(Stream, on_delete=models.CASCADE, related_name='assignments')
    subject = models.ForeignKey(Subject, on_delete=models.CASCADE, related_name='assignments')
    start_date = models.DateTimeField(default=timezone.now)
    due_date = models.DateTimeField(default=timezone.now)
    date_added = models.DateTimeField(default=timezone.now)

    class Meta:
        ordering = '-id',

    def __str__(self):
        return self.name

    def save(self, *args, **kwargs):
        # create the assignment if not created
        if not self.id:
            self.date_added = timezone.now()
        return super().save(*args, **kwargs)


@receiver(post_save, sender=Assignment)
def dispatch_notifications(sender, instance, **kwargs):
    from schools.utils import send_notifications
    send_notifications(instance)
    # loop = asyncio.new_event_loop()
    # loop.run_in_executor(None, send_notifications, instance)


class GuardianManager(models.Manager):
    def get_from_phone(self, phone, name):
        guardian, is_created = self.get_or_create(
            phone=phone,
            defaults={
                'name': name,
                'phone': phone
            }
        )
        return guardian


class Guardian(models.Model):
    name = models.CharField(max_length=50)
    phone = models.CharField(max_length=20, unique=True)
    last_session = models.DateTimeField(default=timezone.now)
    # this is the amount of money that a session costs
    # this money is covered by a subscription else is not
    session_cost = models.FloatField(default=0)
    last_billed = models.DateTimeField(default=timezone.now)
    objects = GuardianManager()

    def __str__(self):
        return self.name

    @property
    def in_session(self):
        return (timezone.now() - self.last_session) < timedelta(days=1)

    @property
    def has_queue(self):
        return AssignmentQueue.objects.filter(subscription__guardian=self).exists()

    def empty_queue(self):
        return

    def log(self):
        """ Log the last time a guardian used our platform and bill it accordingly """
        time_now = timezone.now()
        self.last_session = time_now
        is_billed = (time_now - self.last_billed) < timedelta(days=1)
        if not is_billed:
            self.session_cost += WHATSAPP_COST
            self.last_billed = time_now
        self.save()


class PricingModel(models.Model):
    name = models.CharField(max_length=50)
    description = models.TextField()
    choices = (
        ('WhatsApp Only', 'WABA_ONLY'),
        ('SMS Only', 'SMS_ONLY'),
        ('WhatsApp and SMS', 'WHATSAPP_SMS')
    )
    code = models.CharField(max_length=20, default=None, choices=choices, unique=True)
    profit_margin = models.FloatField(default=5.0)
    cost = models.FloatField(default=0)

    @property
    def total_price(self):
        return self.cost * ((100 + self.profit_margin) / 100)

    def __str__(self):
        return self.name


class SubscriptionManager(models.Manager):
    def get_from_guardian(self, guardian: Guardian, student: Student):
        subscription, is_created = self.get_or_create(
            guardian=guardian,
            student=student,
            defaults={
                'guardian': guardian,
                'student': student
            }
        )
        return subscription


class Subscription(models.Model):
    guardian = models.ForeignKey(Guardian, on_delete=models.CASCADE, related_name='subscriptions')
    student = models.ForeignKey(Student, on_delete=models.CASCADE, related_name='subscriptions')
    balance = models.FloatField(default=0)
    last_billed = models.DateTimeField(default=timezone.now)
    expiry_date = models.DateTimeField(default=timezone.now)

    objects = SubscriptionManager()

    @property
    def days_left(self):
        time_left = self.expiry_date - timezone.now()
        days_left = time_left.days
        if days_left > 0:
            return time_left.days + 1
        return 0

    @property
    def is_subscribed(self):
        return timezone.now() < self.expiry_date

    @property
    def is_billed(self):
        return (timezone.now() - self.last_billed) < timedelta(days=1)

    def bill_whatsapp(self):
        session_pricing = settings.WHATSAPP_COST
        if not self.is_billed:
            self.balance -= session_pricing
            self.last_billed = timezone.now()
            self.save()

    def bill_sms(self):
        sms_price = settings.SMS_COST
        self.balance -= sms_price
        self.save()

    def __str__(self):
        return str(self.guardian)

    class Meta:
        unique_together = (
            ('guardian', 'student')
        )


class Incentive(models.Model):
    school = models.OneToOneField(School, on_delete=models.CASCADE, related_name='incentive')
    per_school = models.FloatField()
    per_teacher = models.FloatField()

    def __str__(self):
        return str(self.school)


class AssignmentQueue(models.Model):
    assignment = models.ForeignKey(Assignment, on_delete=models.CASCADE)
    subscription = models.ForeignKey(Subscription, on_delete=models.CASCADE)

    class Meta:
        unique_together = (
            ('assignment', 'subscription')
        )
