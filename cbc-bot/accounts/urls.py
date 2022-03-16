from django.urls import path
from .views import login, user

app_name = 'accounts'

urlpatterns = [
    path('login', login),
    path('user', user)
]
