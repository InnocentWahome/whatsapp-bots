from graphene_django.views import GraphQLView as BaseGraphQLView
from rest_framework.decorators import permission_classes, authentication_classes, api_view
from rest_framework.permissions import AllowAny
from rest_framework.request import Request
from rest_framework.settings import api_settings
import graphene
from graphene.utils.str_converters import to_camel_case


class GraphQLView(BaseGraphQLView):

    def parse_body(self, request):
        if isinstance(request, Request):
            return request.data
        return super(GraphQLView, self).parse_body(request)

    @classmethod
    def as_view(cls, *args, **kwargs):
        view = super(GraphQLView, cls).as_view(*args, **kwargs)
        view = permission_classes((AllowAny,))(view)
        view = authentication_classes(api_settings.DEFAULT_AUTHENTICATION_CLASSES)(view)
        view = api_view(["GET", "POST"])(view)
        return view


class Error(graphene.ObjectType):
    """ represent errors
        field - field for which the error is called
        messages - messages in the field
    """
    field = graphene.String()
    messages = graphene.List(graphene.String)


class PaginationType(graphene.InputObjectType):
    """ This type is in charge of pagination
        number - number of items to be shown
        position - from where we are counting starts
    """
    page_size = graphene.Int()
    page_number = graphene.Int()


PaginationType = graphene.Argument(PaginationType)


def errors_to_graphene(errors: dict):
    """Changes Serialization Errors to My Graphene Error Type
    Args:
        errors - errors from a serializer
    """
    graphene_errors = []
    # create a list of Error Objects
    for error in errors.keys():
        graphene_errors.append(
            Error(
                field=to_camel_case(error),
                messages=errors[error]
            )
        )
    return graphene_errors
