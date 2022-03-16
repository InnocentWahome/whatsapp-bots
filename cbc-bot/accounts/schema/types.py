from graphene_django import DjangoObjectType

from accounts.models import User


class UserType(DjangoObjectType):
    class Meta:
        model = User
        exclude = ('password',)


