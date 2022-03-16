import graphene
from .types import AssignmentType

from root.graphql import Error, errors_to_graphene
from ..models import Assignment
from ..serializers import AssignmentSerializer


class AssignmentMutation(graphene.Mutation):
    assignment = graphene.Field(AssignmentType)
    errors = graphene.List(Error)

    class Arguments:
        id = graphene.ID(required=False)
        branch = graphene.ID()
        name = graphene.String()
        description = graphene.String()
        stream = graphene.ID()
        subject = graphene.ID()
        start_date = graphene.DateTime()
        due_date = graphene.DateTime()

    def mutate(self, info, **kwargs):
        teacher = info.context.user.teachers.get(branch_id=kwargs['branch'])
        instance = None
        if kwargs.get('id'):
            instance = Assignment.objects.get(id=kwargs.get('id'))
        serializer = AssignmentSerializer(
            instance=instance,
            data={
                **kwargs,
                'teacher': teacher.id
            },
        )
        if not serializer.is_valid():
            return AssignmentMutation(
                errors=errors_to_graphene(serializer.errors)
            )
        assignment = serializer.save()
        return AssignmentMutation(
            assignment=assignment,
        )


class Mutation(graphene.ObjectType):
    assignment = AssignmentMutation.Field()
