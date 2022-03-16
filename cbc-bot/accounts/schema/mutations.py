import graphene
from rest_framework.authtoken.models import Token

from accounts.schema.types import UserType
from accounts.serializers import (
    LoginSerializer,
)

from root.graphql import Error, errors_to_graphene


class LoginMutation(graphene.Mutation):
    token = graphene.String()
    user = graphene.Field(UserType)
    errors = graphene.List(Error)

    class Arguments:
        email = graphene.String()
        password = graphene.String()

    def mutate(self, info, **kwargs):
        serializer = LoginSerializer(
            data=kwargs,
            context={
                'request': info.context
            }
        )
        if not serializer.is_valid():
            return LoginMutation(
                errors=errors_to_graphene(serializer.errors)
            )
        user = serializer.save()
        token, created = Token.objects.get_or_create(user=user)
        return LoginMutation(
            token=token.key,
            user=user
        )


class Mutation(graphene.ObjectType):
    login = LoginMutation.Field()
