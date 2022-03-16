from django.contrib import admin
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
    Incentive,
    Subject
)


# Register your models here.
@admin.register(School)
class SchoolAdmin(admin.ModelAdmin):
    pass


@admin.register(Branch)
class BranchAdmin(admin.ModelAdmin):
    pass


@admin.register(Subject)
class SubjectAdmin(admin.ModelAdmin):
    list_display = 'name', 'description', 'school'


@admin.register(Class)
class ClassAdmin(admin.ModelAdmin):
    pass


@admin.register(Stream)
class StreamAdmin(admin.ModelAdmin):
    pass


@admin.register(Student)
class StudentAdmin(admin.ModelAdmin):
    pass


@admin.register(Teacher)
class TeacherAdmin(admin.ModelAdmin):
    pass


@admin.register(Assignment)
class AssignmentAdmin(admin.ModelAdmin):
    list_display = 'name', 'description', 'teacher', 'stream'


@admin.register(PricingModel)
class PricingModelAdmin(admin.ModelAdmin):
    list_display = 'name', 'description', 'code', 'profit_margin', 'cost'


@admin.register(Guardian)
class GuardianAdmin(admin.ModelAdmin):
    pass


@admin.register(Subscription)
class SubscriptionAdmin(admin.ModelAdmin):
    list_display = 'guardian', 'student', 'balance'


@admin.register(Incentive)
class IncentiveAdmin(admin.ModelAdmin):
    pass
