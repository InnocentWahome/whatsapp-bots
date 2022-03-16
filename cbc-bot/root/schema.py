import graphene
from schools.schema import Query as SchoolQuery
from schools.schema import Mutation as SchoolMutation
from accounts.schema import Query as AccountQuery
from accounts.schema import Mutation as AccountsMutation


class Query(SchoolQuery, AccountQuery, graphene.ObjectType):
    # This class will inherit from multiple Queries
    # as we begin to add more apps to our project
    pass


class Mutation(SchoolMutation, AccountsMutation, graphene.ObjectType):
    pass


schema = graphene.Schema(
    query=Query,
    mutation=Mutation
)
