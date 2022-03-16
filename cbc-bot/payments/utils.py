import sys
import traceback
from django.conf import settings
from payments.models import (
    SubscriptionTransaction,
    Transaction
)
from payments.stk import initiate_stk
from schools.models import Subscription


def pay_via_transaction(transaction: Transaction, callback_url, account_ref):
    try:
        # get phone number and remove the + sign if it
        # comes with it
        phone_number = transaction.phone
        if phone_number.startswith("+"):
            phone_number = phone_number[1:]
        # send the stk push request to safaricom
        response = initiate_stk(
            phone_number=phone_number,
            amount=transaction.amount,
            account_ref=account_ref,
            callback_url=callback_url
        )
        # if response is successful set transaction pending
        if response.get('code') == 'success':
            transaction.set_pending(
                payment_id=response['paymentId'],
                paybill_number=response['paybill'],
                account_number=response['accountNumber']
            )
            return True, transaction
        # set transaction as failed and set the error message
        transaction.set_fail(
            payment_id=None,
            reason_failed=response.get('errorMessage')
        )
        return False, transaction
    except Exception as e:
        print("-" * 60)
        print(e)
        traceback.print_exc(file=sys.stdout)
        print("-" * 60)
        message = str(e.args)
        transaction.set_fail(
            payment_id=None,
            reason_failed=message
        )
        return False, transaction


def pay_for_subscription(subscription: Subscription, amount: float, phone: str,package):
    """ Initiates a payment for a particular Order
    Args:
        order - the order we are going to pay for
    Returns:
        tuple(success_status,transaction) - returns a success message and the transaction
    """
    # create an order transaction from an order
    transaction = SubscriptionTransaction.objects.create(
        amount=amount,
        subscription=subscription,
        phone=phone,
        package=package
    )
    # get callback url stk push is going to use
    callback_url = f'{settings.CALLBACK_BASE_URL}/callback/subscription'
    # pay for the order
    return pay_via_transaction(transaction, callback_url, account_ref="CBC Digital")
