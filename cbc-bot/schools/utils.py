import json
from datetime import timedelta

import requests
from django.utils import timezone

from schools.models import Assignment, Guardian, Subscription, AssignmentQueue
from .serializers import (
    NotificationAssignmentSerializer,
    NotificationSubscriptionSerializer, AssignmentQueueSerializer
)
from django.conf import settings


def charge_guardians(subscriptions):
    billed_guardians = []
    for subscription in subscriptions:
        guardian_id, is_billed = subscription.bill()
        if is_billed:
            billed_guardians.append(guardian_id)
    return Guardian.objects.filter(id__in=billed_guardians)


def send_notifications(assignment: Assignment):
    # get all subscriptions of guardians who are not in session
    time_now = timezone.now()
    # 24 hours ago
    day_ago = time_now - timedelta(days=1)
    all_subscriptions = Subscription.objects.filter(
        student__stream=assignment.stream,
    )
    print("ALL SUBCRIPTIONS")
    print(all_subscriptions)
    # all the subscribers who have valid subscriptions
    paid_subscriptions = all_subscriptions.filter(
        expiry_date__gt=time_now
    )
    print("ALL PAID SUBSCRIPTIONS")
    print(paid_subscriptions)
    # unpaid subscriptions but in session
    unpaid_subscriptions = all_subscriptions.filter(
        expiry_date__lt=time_now + timedelta(days=1),
    )
    print("UN PAID SUBSCRIPTIONS")
    print(unpaid_subscriptions)

    # all the guardians who donat have
    non_session_subscriptions = paid_subscriptions.filter(
        guardian__last_session__lt=day_ago,
    )
    #####################################################
    # GET NOTIFICATION DATA FOR SMS
    #####################################################
    print("SUBSCRIPTION NOT SESSION")
    print(non_session_subscriptions)
    # put all non session subscriptions in a queue
    AssignmentQueue.objects.bulk_create(
        list(
            map(
                lambda subscription: AssignmentQueue(
                    assignment=assignment,
                    subscription=subscription
                ),
                non_session_subscriptions
            )
        )
    )
    assignment.subscriptions = non_session_subscriptions
    sms_notifications = NotificationAssignmentSerializer(
        instance=assignment
    ).data

    #####################################################
    # GET NOTIFICATION DATA FOR WHATSAPP_NOTIFICATIONS
    #####################################################
    session_subscriptions = paid_subscriptions.filter(
        guardian__last_session__gt=day_ago,
    )

    print("SUBSCRIPTION IS SESSION")
    print(session_subscriptions)
    assignment.subscriptions = session_subscriptions
    whatsapp_notifications = NotificationAssignmentSerializer(
        instance=assignment
    ).data
    url = settings.NOTIFICATIONS_URL
    payload = json.dumps({
        'sms': sms_notifications,
        'whatsapp': whatsapp_notifications,
        'unpaid': NotificationSubscriptionSerializer(instance=unpaid_subscriptions, many=True).data
    }, indent=2)
    # print(payload)
    headers = {
        'Content-Type': 'application/json',
    }
    try:
        response = requests.request(
            "POST",
            url,
            headers=headers,
            data=payload,
            timeout=1000
        )
        if response.status_code != 200:
            print(response.json())
    except ConnectionError:
        print("failed connection")


def empty_queue(que_qs):
    url = f'{settings.NOTIFICATIONS_URL}/empty-queue'
    payload = json.dumps({
        'queue': AssignmentQueueSerializer(
            instance=AssignmentQueue,
            many=True
        ).data
    }, indent=2)
    headers = {
        'Content-Type': 'application/json',
    }
    try:
        response = requests.request(
            "POST",
            url,
            headers=headers,
            data=payload,
            timeout=1000
        )
        if response.status_code != 200:
            print(response.json())
    except ConnectionError:
        print("failed connection")
