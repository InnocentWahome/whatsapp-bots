from datetime import timedelta

from django.test import TestCase
from django.utils import timezone

from accounts.models import User
from schools.models import Assignment, Teacher, Branch, School, Subject, Stream, Class, PricingModel, Guardian, \
    Subscription, Student
from schools.utils import send_notifications


class NotificationTestCse(TestCase):
    def setUp(self) -> None:
        self.user = User.objects.create(
            username='test',
            first_name='John',
            last_name='Doe',
            email='johndoe@gmail.com'
        )
        self.school = School.objects.create(
            name='Test School',
            is_verified=False
        )
        self.branch = Branch.objects.create(
            name='Test Branch',
            school=self.school
        )
        self.teacher = Teacher.objects.create(
            user=self.user,
            name='Mr. Maneno',
            phone='254797792447',
            branch=self.branch
        )
        self.subject = Subject.objects.create(
            name='MATH',
            description='This is description',
            school=self.school
        )
        self.stream_class = Class.objects.create(
            name='CLASS 6',
            branch=self.branch
        )
        self.stream = Stream.objects.create(
            name='CLASS 6 NORTH',
            stream_class=self.stream_class
        )

    def test_notification_in_session(self):
        print("##########  IN SESSION COMMUNICATION    #############")
        # create the guardian and the subscription
        guardian = Guardian.objects.create(
            name='Test Guardian 1',
            phone='254797792447'
        )
        guardian.last_session = timezone.now()
        guardian.save()
        student = Student.objects.create(
            name='Test Student',
            student_code='18/02588',
            branch=self.branch,
            stream=self.stream
        )
        # create a message subscription
        subscription = Subscription.objects.create(
            guardian=guardian,
            student=student,
            balance=10,
            expiry_date=timezone.now() + timedelta(days=1)
        )
        self.assignment = Assignment.objects.create(
            name='Test Assignment',
            description='This is a description',
            teacher=self.teacher,
            subject=self.subject,
            stream=self.stream
        )


"""
    def test_notification_out_session(self):
        print("##########  OUT OF SESSION   #############")
        # create the guardian and the subscription
        guardian = Guardian.objects.create(
            name='Test Guardian 1',
            phone='254797792447'
        )
        student = Student.objects.create(
            name='Test Student',
            student_code='18/02588',
            branch=self.branch,
            stream=self.stream
        )
        # create a message subscription
        subscription = Subscription.objects.create(
            guardian=guardian,
            student=student,
            balance=10
        )
        self.assignment = Assignment.objects.create(
            name='Test Assignment',
            description='This is a description',
            teacher=self.teacher,
            subject=self.subject,
            stream=self.stream
        )
"""
