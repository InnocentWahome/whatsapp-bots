import graphene

from root.graphql import PaginationType
from utils.db import paginate_queryset
from .types import (
    SchoolType, BranchType, ClassType, StreamType,
    PricingModelType, TeacherType, AssignmentType, SubscriptionType
)
from ..models import (
    School, Branch, Stream, Teacher,
    PricingModel, Assignment, Class, Subscription
)


def get_model_list(model_class, filters, pagination):
    filters = dict() if filters is None else filters
    qs = model_class.objects.filter(**filters)
    if pagination:
        return paginate_queryset(
            qs=qs,
            page_size=pagination.page_size,
            page_number=pagination.page_number
        )
    return qs


def get_model_item(model_class, **kwargs):
    try:
        return model_class.objects.get(id=kwargs['id'])
    except model_class.DoesNotExist:
        return None


class Query(graphene.ObjectType):
    schools = graphene.List(SchoolType, filters=graphene.JSONString(), pagination=PaginationType)

    @staticmethod
    def resolve_schools(self, info, filters=None, pagination=None):
        return get_model_list(School, filters, pagination)

    branches = graphene.List(BranchType, filters=graphene.JSONString(), pagination=PaginationType)

    @staticmethod
    def resolve_branches(self, info, filters=None, pagination=None):
        return get_model_list(Branch, filters, pagination)

    classes = graphene.List(ClassType, filters=graphene.JSONString(), pagination=PaginationType)

    @staticmethod
    def resolve_classes(self, info, filters=None, pagination=None):
        return get_model_list(Class, filters, pagination)

    streams = graphene.List(StreamType, filters=graphene.JSONString(), pagination=PaginationType)

    @staticmethod
    def resolve_streams(self, info, filters=None, pagination=None):
        return get_model_list(Stream, filters, pagination)

    teachers = graphene.List(TeacherType, filters=graphene.JSONString(), pagination=PaginationType)

    @staticmethod
    def resolve_teachers(self, info, filters=None, pagination=None):
        return get_model_list(Teacher, filters, pagination)

    assignments = graphene.List(AssignmentType, filters=graphene.JSONString(), pagination=PaginationType)

    @staticmethod
    def resolve_assignments(self, info, filters=None, pagination=None):
        return get_model_list(Assignment, filters, pagination)

    subscriptions = graphene.List(SubscriptionType, filters=graphene.JSONString(),
                                  pagination=PaginationType)

    @staticmethod
    def resolve_subscriptions(self, info, filters=None, pagination=None):
        return get_model_list(Subscription, filters, pagination)

    pricing_models = graphene.List(PricingModelType, filters=graphene.JSONString(), pagination=PaginationType)

    @staticmethod
    def resolve_pricing_models(self, info, filters=None, pagination=None):
        return get_model_list(PricingModel, filters, pagination)

    school = graphene.Field(SchoolType, id=graphene.ID(required=True))

    @staticmethod
    def resolve_school(self, info, **kwargs):
        return get_model_item(School, **kwargs)

    branch = graphene.Field(BranchType, id=graphene.ID(required=True))

    @staticmethod
    def resolve_branch(self, info, **kwargs):
        return get_model_item(Branch, **kwargs)

    branch_class = graphene.Field(ClassType, id=graphene.ID(required=True))

    @staticmethod
    def resolve_branch_class(self, info, **kwargs):
        return get_model_item(Class, **kwargs)

    stream = graphene.Field(StreamType, id=graphene.ID(required=True))

    @staticmethod
    def resolve_stream(self, info, **kwargs):
        return get_model_item(Stream, **kwargs)

    pricing_model = graphene.Field(PricingModelType, id=graphene.ID(required=True))

    @staticmethod
    def resolve_pricing_model(self, info, **kwargs):
        return get_model_item(PricingModel, **kwargs)
