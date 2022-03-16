from django.db import models
from django.utils import timezone
from jsonfield import JSONField

from bot.utils import get_screen


class Session(models.Model):
    session_id = models.CharField(max_length=200, primary_key=True)
    state = models.CharField(max_length=200, null=True)
    data = JSONField(null=True)
    created_at = models.DateTimeField(auto_now_add=True, null=True)
    updated_at = models.DateTimeField(auto_now=True, null=True)

    def __str__(self):
        return self.session_id

    def update(self, state, data):
        self.state = state
        self.data = data
        self.save()

    def reset(self):
        self.state = None
        self.data = None
        self.save()

    def is_expired(self, time_difference: timezone.timedelta = timezone.timedelta(minutes=2)):
        time_now = timezone.now()
        last_interaction_diff = time_now - self.updated_at
        return time_difference < last_interaction_diff

    def current_screen(self, context):
        return get_screen(self.state, data=self.data, context=context)

    def render(self, screen, context):
        """gets the screen type and renders the screen"""
        self.update(
            state=screen.state,
            data=screen.data,
        )
        # set screen context
        screen.set_context(context)
        return screen.render()
