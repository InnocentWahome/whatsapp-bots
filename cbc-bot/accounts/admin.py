from django.contrib import admin
from accounts.models import User


@admin.register(User)
class UserAdmin(admin.ModelAdmin):
    list_display = 'first_name', 'email', 'is_staff', 'is_superuser'
