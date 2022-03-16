from rest_framework import serializers
from accounts.models import User


class LoginSerializer(serializers.Serializer):
    default_error_messages = {
        'invalid': 'Invalid Email or Password'
    }

    email = serializers.EmailField(required=True)
    password = serializers.CharField(required=True)

    def validate(self, attrs):
        try:
            user = User.objects.get(email=attrs['email'])
            if user.check_password(attrs['password']):
                self.user = user
                return attrs
        except User.DoesNotExist:
            pass
        raise serializers.ValidationError(
            self.default_error_messages['invalid']
        )

    def save(self, **kwargs):
        return self.user

    def update(self, instance, validated_data):
        pass

    def create(self, validated_data):
        pass


class UserSerializer(serializers.ModelSerializer):

    class Meta:
        model = User
        exclude = ('password',)

