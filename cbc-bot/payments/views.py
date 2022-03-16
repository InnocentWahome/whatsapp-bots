import json
from django.http import HttpResponse
from django.template.loader import render_to_string
from django.views.decorators.csrf import csrf_exempt

from bot.utils import send_whatsapp
from payments.models import SubscriptionTransaction


@csrf_exempt
def order_mpesa_callback(request):
    return HttpResponse("This is lit.")


@csrf_exempt
def subscription_callback(request):
    """ processes the mpesa api callback
    {
        "paymentId": "b1f44f40-1b8a-11ec-acff-19d2dfbec861",
        "externalIdentifier": "TEST",
        "accountNumber": "C1088",
        "resourceIdentifier": "C1088",
        "transactedAmount": 1,
        "transactionCost": 0.009899999999999999,
        "actualAmount": 0.9901,
        "status": "success",
        "receiptNumber": "PIM78S5F4R",
        "transactionDate": 20210922125157,
        "phoneNumber": 254797792447
    }
    """
    data = json.loads(request.body)
    payment_id = data['paymentId']
    transaction = SubscriptionTransaction.objects.get(
        payment_id=payment_id
    )
    if transaction.is_pending:
        is_success = data['status'] == "success"
        if not is_success:
            reason_failed = data["reasonFailed"]
            transaction.set_fail(payment_id, reason_failed)
            message = render_to_string(
                'bot/transaction_failed.txt',
                context={
                    'transaction': transaction
                }
            )
            send_whatsapp({
                "preview_url": False,
                "recipient_type": "individual",
                "to": transaction.phone,
                "type": "text",
                "text": {
                    "body": message
                }
            })
            return HttpResponse()

        mpesa_code = data["receiptNumber"]
        transaction.set_success(payment_id, mpesa_code)
        message = render_to_string('bot/transaction_success.txt', context={'transaction': transaction})
        send_whatsapp({
            "preview_url": False,
            "recipient_type": "individual",
            "to": transaction.phone,
            "type": "text",
            "text": {
                "body": message
            }
        })
    return HttpResponse()
