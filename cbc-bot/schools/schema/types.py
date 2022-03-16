import graphene
from graphene_django import DjangoObjectType
from schools.models import (
    School,
    Branch,
    Class,
    Stream,
    Student,
    Teacher,
    Assignment,
    Guardian,
    PricingModel,
    Subscription,
    Incentive, Subject
)


class SchoolType(DjangoObjectType):
    class Meta:
        model = School


class BranchType(DjangoObjectType):
    class Meta:
        model = Branch


class ClassType(DjangoObjectType):
    class Meta:
        model = Class


class StudentType(DjangoObjectType):
    class Meta:
        model = Student


class TeacherType(DjangoObjectType):
    class Meta:
        model = Teacher


class AssignmentType(DjangoObjectType):
    class Meta:
        model = Assignment


class GuardianType(DjangoObjectType):
    class Meta:
        model = Guardian


class PricingModelType(DjangoObjectType):
    class Meta:
        model = PricingModel


class SubscriptionType(DjangoObjectType):
    class Meta:
        model = Subscription

    is_subscribed = graphene.Boolean()

    def resolve_is_subscribed(self: Subscription, info):
        return self.is_subscribed


class IncentiveType(DjangoObjectType):
    class Meta:
        model = Incentive


class SubjectType(DjangoObjectType):
    class Meta:
        model = Subject


class StreamType(DjangoObjectType):
    class Meta:
        model = Stream

    display_name = graphene.String()

    def resolve_display_name(self: Stream, info):
        class_name = self.stream_class.name
        return f'{self.name}{class_name if class_name != "Main" else ""}'

    subscribers = graphene.List(SubscriptionType)

    def resolve_subscribers(self, info):
        return Subscription.objects.filter(student__stream=self)
