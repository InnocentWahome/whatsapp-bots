from datetime import timedelta

from django.template.loader import render_to_string
from django.utils import timezone

from bot.base_screens import Screen
from payments.models import SubscriptionTransaction
from payments.utils import pay_for_subscription
from schools.models import Student, Branch, Subscription, Guardian, Assignment
from .utils import get_screen
from root.settings import MONTHLY_RATE, TERMLY_RATE


class Menu(Screen):
    state = 'menu'

    def render(self):
        phone = self.context['phone']
        text = render_to_string(
            'bot/welcome.txt',
            context={
                **self.context,
                'errors': self.errors
            }
        )
        return {
            "recipient_type": "individual",
            "to": phone,
            "type": "interactive",
            "interactive": {
                "type": "list",
                "header": {
                    "type": "text",
                    "text": "Menu"
                },
                "body": {
                    "text": text
                },
                "action": {
                    "button": "Menu",
                    "sections": [
                        {
                            "title": "Menu",
                            "rows": [
                                {
                                    "id": "1",
                                    "title": 'Account Balances'
                                },
                                {
                                    "id": "2",
                                    "title": 'Today\'s Assignment'
                                },
                                {
                                    "id": "3",
                                    "title": "Top Up Account"
                                },
                                {
                                    "id": "4",
                                    "title": "Add Student"
                                }
                            ]
                        },
                    ]
                }
            }
        }

    def next_screen(self, current_input):
        if current_input == "1":
            return get_screen('account_balance')
        if current_input == "2":
            if Subscription.objects.filter(
                    guardian__phone=self.context["phone"],
                    student__stream__assignments__date_added__gt=timezone.now() - timedelta(1)
            ).exists():
                return get_screen('assignment_today')
            return get_screen('no_assignment')
        if current_input == "3":
            subscriptions = Subscription.objects.filter(
                guardian__phone=self.context["phone"]
            )
            if not subscriptions.exists():
                screen: Screen = get_screen('get_student_id')
                return screen
            # if subscriptions.count() == 1:
            #    return get_screen('pay_subscription', data={
            #        'subscription_id': subscriptions[0].id
            #    })
            return get_screen('account_top_up')
        if current_input == "4":
            return get_screen('get_student_id')
        return self.error_screen(['Invalid Choice'])


class AccountBalance(Screen):
    state = 'account_balance'

    def render(self):
        phone = self.context['phone']
        subscriptions = Subscription.objects.filter(guardian__phone=phone)
        text = render_to_string(
            'bot/account_balance.txt',
            context={
                **self.context,
                'errors': self.errors,
                'subscriptions': subscriptions,
                'is_empty': not subscriptions.exists()
            }
        )
        return {
            "preview_url": False,
            "recipient_type": "individual",
            "to": phone,
            "type": "text",
            "text": {
                "body": text
            }
        }


class AssignmentToday(Screen):
    state = 'assignment_today'

    def render(self):
        phone = self.context['phone']
        subscriptions = Subscription.objects.filter(
            guardian__phone=phone,
            student__stream__assignments__date_added__gt=timezone.now() - timedelta(1)
        )
        if not subscriptions.exists():
            return {
                "preview_url": False,
                "recipient_type": "individual",
                "to": phone,
                "type": "text",
                "text": {
                    "body": "🙂 No assignments today"
                }
            }

        text = render_to_string('bot/assignment_today.txt')
        return {
            "recipient_type": "individual",
            "to": phone,
            "type": "interactive",
            "interactive": {
                "type": "list",
                "header": {
                    "type": "text",
                    "text": "Select Student"
                },
                "body": {
                    "text": text
                },
                "action": {
                    "button": "Select Student",
                    "sections": [
                        {
                            "title": "Select Student",
                            "rows": list(map(
                                lambda x: {
                                    "id": str(x.id),
                                    "title": f'{x.student.name}'
                                }, subscriptions
                            ))
                        },
                    ]
                }
            }
        }

    def next_screen(self, current_input):
        return get_screen('student_assignments', data={'subscription_id': current_input})


class StudentAssignment(Screen):
    state = 'student_assignments'
    required_fields = ['subscription_id']

    def render(self):
        subscription = Subscription.objects.get(
            id=self.data['subscription_id']
        )
        assignments = Assignment.objects.filter(
            stream__students__subscriptions=subscription,
            date_added__gt=timezone.now() - timedelta(1)
        )
        text = render_to_string(
            'bot/student_assignments.txt',
            context={
                'student': subscription.student,
                'assignments': assignments
            }
        )
        return {
            "preview_url": False,
            "recipient_type": "individual",
            "to": self.context['phone'],
            "type": "text",
            "text": {
                "body": text
            }
        }


class NoAssignmentToday(Screen):
    state = 'no_assignment'

    def render(self):
        text = render_to_string('bot/no_assignment_today.txt')
        return {
            "preview_url": False,
            "recipient_type": "individual",
            "to": self.context["phone"],
            "type": "text",
            "text": {
                "body": text
            }
        }


class GetStudentID(Screen):
    state = 'get_student_id'

    def render(self):
        phone = self.context['phone']
        text = render_to_string(
            'bot/get_student.txt',
            context={
                **self.context,
                'errors': self.errors
            }
        )
        return {
            "preview_url": False,
            "recipient_type": "individual",
            "to": phone,
            "type": "text",
            "text": {
                "body": text
            }
        }

    def next_screen(self, current_input):
        students = Student.objects.filter(student_code=current_input)
        if students.exists():
            # check if number is more than one
            if students.count() > 1:
                branches = Branch.objects.filter(classes__streams__students__in=students)
                return get_screen('select_branch', data={
                    "branch_ids": list(map(lambda x: x.id, branches)),
                    "student_ids": list(map(lambda x: x.id, students))
                })
            subscription = Subscription.objects.get_from_guardian(
                guardian=self.context['guardian'],
                student=students[0]
            )
            # if there is only one student go to the packages page
            return get_screen('pay_subscription', data={
                "subscription_id": subscription.id
            })
        return self.error_screen(['No Such Student is found on our system'])


class SelectBranch(Screen):
    state = 'select_branch'
    required_fields = ['branch_ids', 'student_ids']

    def render(self):
        phone = self.context['phone']
        branches = Branch.objects.filter(id__in=self.data['branch_ids'])
        return {
            "recipient_type": "individual",
            "to": phone,
            "type": "interactive",
            "interactive": {
                "type": "list",
                "header": {
                    "type": "text",
                    "text": "Branches"
                },
                "body": {
                    "text": "Choose the school which your child belongs to."
                },
                "action": {
                    "button": "Select Branch",
                    "sections": [
                        {
                            "title": "Branches",
                            "rows": list(
                                map(
                                    lambda branch: {
                                        "id": str(branch.id),
                                        "title": branch.name
                                    },
                                    branches
                                )
                            )
                        },
                    ]
                }
            }
        }

    def next_screen(self, current_input):
        try:
            student = Student.objects.get(
                stream__stream_class__branch__id=current_input,
                id__in=self.data['student_ids']
            )
            subscription = Subscription.objects.get_from_guardian(
                guardian=Guardian.objects.get_from_phone(self.context["guardian"]),
                student=student
            )
            # if there is only one student go to the packages page
            return get_screen('pay_subscription', data={
                "subscription_id": subscription.id
            })
        except ValueError:
            return self.errors(["Invalid Input"])


class AccountTopUp(Screen):
    state = 'account_top_up'

    def render(self):
        phone = self.context['phone']
        subscriptions = Subscription.objects.filter(
            guardian__phone=phone
        )
        return {
            "recipient_type": "individual",
            "to": phone,
            "type": "interactive",
            "interactive": {
                "type": "list",
                "header": {
                    "type": "text",
                    "text": "Select Student"
                },
                "body": {
                    "text": "Select the student whose subscription you want to top up"
                },
                "action": {
                    "button": "Select Student",
                    "sections": [
                        {
                            "title": "Select Student",
                            "rows": list(
                                map(
                                    lambda subscription: {
                                        "id": str(subscription.id),
                                        "title": subscription.student.name,
                                        "description": f'{subscription.student.stream.name}-{subscription.student.branch}'
                                    },
                                    subscriptions
                                )
                            )
                        },
                    ]
                }
            }
        }

    def next_screen(self, current_input):
        try:
            subscription = Subscription.objects.get(
                id=current_input,
            )
            return get_screen(
                'pay_subscription',
                data={
                    "subscription_id": subscription.id
                })
        except ValueError:
            return self.errors(["Invalid Input"])


class PaySubscription(Screen):
    state = 'pay_subscription'
    required_fields = ['subscription_id']

    def render(self):
        phone = self.context['phone']
        subscription = Subscription.objects.get(
            id=self.data["subscription_id"],
        )
        text = render_to_string(
            'bot/pay_subscription.txt',
            context={
                **self.context,
                'errors': self.errors,
                'subscription': subscription,
            }
        )
        return {
            "recipient_type": "individual",
            "to": phone,
            "type": "interactive",
            "interactive": {
                "type": "list",
                "header": {
                    "type": "text",
                    "text": "Select Package"
                },
                "body": {
                    "text": text
                },
                "action": {
                    "button": "Select Package",
                    "sections": [
                        {
                            "title": "Select Package",
                            "rows": [
                                {
                                    "id": "monthly",
                                    "title": f'1 Month - Ksh.{MONTHLY_RATE}',
                                    "description": "Get unlimited messages a whole month!"
                                },
                                {
                                    "id": "termly",
                                    "title": f'1 Term - Ksh.{TERMLY_RATE}',
                                    "description": "Get unlimited messages the full term!"
                                },
                            ]
                        },
                    ]
                }
            }
        }

    def next_screen(self, current_input):
        # convert to float field
        amount = MONTHLY_RATE if current_input == "monthly" else TERMLY_RATE
        # get the subscription using the subscription id
        subscription = Subscription.objects.get(id=self.data['subscription_id'])
        # create a subscription transaction that will have the
        is_successful, transaction = pay_for_subscription(
            subscription,
            amount,
            self.context["phone"],
            current_input
        )
        if not is_successful:
            print(transaction.reason_failed)
            return self.error_screen(['Ooops 😲😲! Payment Failed.\nPlease try again below.'])
        return get_screen('transaction_pending', data={'transaction_id': transaction.id})


class TransactionPending(Screen):
    state = 'transaction_pending'
    required_fields = ['transaction_id']

    def render(self):
        phone = self.context['phone']
        transaction = SubscriptionTransaction.objects.get(id=self.data["transaction_id"])
        text = render_to_string(
            'bot/transaction_pending.txt',
            context={
                **self.context,
                'errors': self.errors,
                'transaction': transaction,
            }
        )
        return {
            "preview_url": False,
            "recipient_type": "individual",
            "to": phone,
            "type": "text",
            "text": {
                "body": text
            }
        }


screens = locals()

