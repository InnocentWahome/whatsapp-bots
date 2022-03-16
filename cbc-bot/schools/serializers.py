from rest_framework import serializers

from schools.models import Assignment, Branch, Stream, Subject, Teacher, School, Class, Subscription, Student, Guardian, \
    AssignmentQueue
from utils.serializers import RelatedField


class SchoolSerializer(serializers.ModelSerializer):
    class Meta:
        model = School
        fields = '__all__'


class BranchSerializer(serializers.ModelSerializer):
    school = RelatedField(School, SchoolSerializer)

    class Meta:
        model = Branch
        fields = '__all__'


class TeacherSerializer(serializers.ModelSerializer):
    class Meta:
        model = Teacher
        fields = '__all__'


class SubjectSerializer(serializers.ModelSerializer):
    school = RelatedField(School, SchoolSerializer)

    class Meta:
        model = Subject
        fields = '__all__'


class ClassSerializer(serializers.ModelSerializer):
    class Meta:
        model = Class
        fields = '__all__'


class StreamSerializer(serializers.ModelSerializer):
    stream_class = RelatedField(Class, ClassSerializer)

    class Meta:
        model = Stream
        fields = '__all__'


class AssignmentSerializer(serializers.ModelSerializer):
    teacher = RelatedField(Teacher, TeacherSerializer)
    stream = RelatedField(Stream, StreamSerializer)
    subject = RelatedField(Subject, SubjectSerializer)

    class Meta:
        model = Assignment
        fields = '__all__'


class StudentSerializer(serializers.ModelSerializer):
    stream = RelatedField(Stream, StreamSerializer)
    branch = RelatedField(Branch, BranchSerializer)

    class Meta:
        model = Student
        fields = '__all__'


class GuardianSerializer(serializers.ModelSerializer):
    class Meta:
        model = Guardian
        fields = '__all__'


class SubscriptionSerializer(serializers.ModelSerializer):
    guardian = RelatedField(Guardian, GuardianSerializer)
    student = RelatedField(Student, StudentSerializer)

    class Meta:
        model = Subscription
        fields = '__all__'


class NotificationSubscriptionSerializer(serializers.ModelSerializer):
    class Meta:
        model = Subscription
        fields = '__all__'


class NotificationAssignmentSerializer(serializers.ModelSerializer):
    subscriptions = SubscriptionSerializer(many=True)
    subject = RelatedField(Subject, SubjectSerializer)

    class Meta:
        model = Assignment
        fields = '__all__'


class AssignmentQueueSerializer(serializers.ModelSerializer):
    class Meta:
        model = AssignmentQueue
        fields = '__all__'
