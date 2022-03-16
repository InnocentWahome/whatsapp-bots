from rest_framework import viewsets
from rest_framework.authentication import TokenAuthentication
from rest_framework.permissions import IsAuthenticated
from rest_framework.response import Response

from .models import Assignment, Branch, Stream, Subject, Teacher
from .serializers import AssignmentSerializer, BranchSerializer, StreamSerializer, SubjectSerializer


class TeacherAssignmentViewSet(viewsets.ViewSet):
    authentication_classes = [TokenAuthentication]
    permission_classes = [IsAuthenticated]
    serializer_class = AssignmentSerializer
    queryset = Assignment.objects.all()

    def list_assignments(self, request, branch_id):
        # get the assignments assigned to a particular teacher
        assignments = Assignment.objects.filter(
            teacher__user=request.user,
            teacher__branch_id=branch_id
        )
        serializer = AssignmentSerializer(instance=assignments, many=True)
        return Response(
            data={
                'success': True,
                'message': 'Assignment Fetch Successful',
                'data': serializer.data
            },
            status=200
        )

    def view_assignment(self, request, assignment_id):
        # get the assignments assigned to a particular teacher
        try:
            assignment = Assignment.objects.get(id=assignment_id)
            serializer = AssignmentSerializer(instance=assignment)
            return Response(
                data={
                    'success': True,
                    'message': 'Assignment Fetch Successful',
                    'data': serializer.data
                },
                status=200
            )
        except Assignment.DoesNotExist:
            return Response(
                data={
                    'success': False,
                    'message': 'Assignment Fetch Failiure',
                },
                status=404
            )

    def create_assignment(self, request, branch_id):
        try:
            teacher = request.user.teachers.get(
                branch_id=branch_id
            )
            serializer = AssignmentSerializer(
                data={
                    **request.data,
                    'teacher': teacher.id
                }
            )
            if not serializer.is_valid():
                return Response(
                    data={
                        'success': False,
                        'message': 'Assignment Creation Failed',
                        'errors': serializer.errors
                    },
                    status=400
                )
            serializer.save()
            return Response(
                data={
                    'success': True,
                    'message': 'Assignment Create Successful',
                },
                status=200
            )
        except Teacher.DoesNotExist:
            return Response(
                data={
                    'success': False,
                    'message': 'The Teacher does not belong to the specified Branch',
                },
                status=400
            )

    def update_assignment(self, request, assignment_id):
        try:
            assignment = Assignment.objects.get(id=assignment_id)
            serializer = AssignmentSerializer(instance=assignment, data=request.data)
            if not serializer.is_valid():
                return Response(
                    data={
                        'success': False,
                        'message': 'Assignment Update Failed',
                        'errors': serializer.errors
                    },
                    status=400
                )
            serializer.save()
            return Response(
                data={
                    'success': True,
                    'message': 'Assignment Update Successful',
                    'data': serializer.data
                },
                status=200
            )
        except Assignment.DoesNotExist:
            return Response(
                data={
                    'success': False,
                    'message': 'Assignment not Found',
                },
                status=404
            )

    def list_branches(self, request):
        branches = Branch.objects.filter(teachers__user=request.user)
        serializer = BranchSerializer(instance=branches, many=True)
        return Response(
            data={
                'success': True,
                'message': 'Branch Fetch Successful',
                'data': serializer.data
            },
            status=200
        )

    def list_streams(self, request, branch_id):
        streams = Stream.objects.filter(stream_class__branch_id=branch_id)
        serializer = StreamSerializer(instance=streams, many=True)
        # TODO : relationship add object
        return Response(
            data={
                'success': True,
                'message': 'Streams Fetch Successful',
                'data': serializer.data
            },
            status=200
        )

    def list_subjects(self, request, branch_id):
        subjects = Subject.objects.filter(school__branches__id=branch_id)
        serializer = SubjectSerializer(instance=subjects, many=True)
        return Response(
            data={
                'success': True,
                'message': 'Subjects Fetch Successful',
                'data': serializer.data
            },
            status=200
        )


list_assignments = TeacherAssignmentViewSet.as_view({'get': 'list_assignments'})
view_assignment = TeacherAssignmentViewSet.as_view({'get': 'view_assignment'})
create_assignment = TeacherAssignmentViewSet.as_view({'post': 'create_assignment'})
update_assignment = TeacherAssignmentViewSet.as_view({'post': 'update_assignment'})
list_branches = TeacherAssignmentViewSet.as_view({'get': 'list_branches'})
list_streams = TeacherAssignmentViewSet.as_view({'get': 'list_streams'})
list_subjects = TeacherAssignmentViewSet.as_view({'get': 'list_subjects'})
