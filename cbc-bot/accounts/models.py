from django.contrib.auth.models import AbstractUser, UserManager
from django.db import models


class User(AbstractUser):
    email = models.EmailField(
        unique=True,
        null=False,
        error_messages={
            'unique': "The email is already in use",
        },
    )
    phone = models.CharField(max_length=20, null=True)
    email_confirmed = models.BooleanField(default=False)
    objects = UserManager()
    created_by = models.ForeignKey("self", null=True, on_delete=models.SET_NULL)

    @staticmethod
    def generate_username(full_name):
        """ Generate first and last name from full name
        Arguments:
            full_name string
        Returns: username string
        """
        # get first and last name
        first_name, last_name = full_name.lower().split(' ')
        # try initials first names plus last whole name
        username = '{}{}'.format(first_name[0], last_name)
        if User.objects.filter(username=username).count() > 0:
            # if not, try first full name plus initials from last names
            username = '{}{}'.format(first_name, last_name[0])
            if User.objects.filter(username=username).count() > 0:
                # if it doesn't fit, put the first name plus a number
                users = User.objects.filter(
                    username__regex=r'^%s[1-9]{1,}$' % first_name
                ).order_by('username').values('username')
                if len(users) > 0:
                    last_number_used = list(map(lambda x: int(x['username'].replace(first_name, '')), users))
                    last_number_used.sort()
                    last_number_used = last_number_used[-1]
                    number = last_number_used + 1
                    username = '{}{}'.format(first_name, number)
                else:
                    username = '{}{}'.format(first_name, 1)
        return username
