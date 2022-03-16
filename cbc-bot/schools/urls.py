from django.urls import path
from .views import (
    list_assignments, create_assignment, update_assignment, view_assignment,
    list_branches, list_streams, list_subjects
)

app_name = 'schools'

urlpatterns = [
    path('assignments/<int:assignment_id>', view_assignment),
    path('assignments/<int:assignment_id>/update', update_assignment),

    path('teacher/branches', list_branches),
    path('teacher/branches/<int:branch_id>/assignments', list_assignments),
    path('teacher/branches/<int:branch_id>/assignments/create', create_assignment),
    path('teacher/branches/<int:branch_id>/streams', list_streams),
    path('teacher/branches/<int:branch_id>/subjects', list_subjects)
]
