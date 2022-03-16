from rest_framework.authentication import BasicAuthentication, TokenAuthentication
from rest_framework.authtoken.models import Token
from rest_framework.decorators import authentication_classes, api_view, permission_classes
from rest_framework.permissions import IsAuthenticated
from rest_framework.response import Response
from accounts.serializers import LoginSerializer, UserSerializer


@api_view(['POST'])
@authentication_classes([BasicAuthentication])
@permission_classes([])
def login(request):
    serializer = LoginSerializer(data=request.data)
    if serializer.is_valid():
        user = serializer.save()
        token, created = Token.objects.get_or_create(user=user)
        return Response(
            data={
                'success': True,
                'message': 'User successfully logged in',
                'data': {
                    'token': token.key,
                    'user_id': user.pk,
                    'email': user.email
                }
            },
            status=200
        )
    return Response(
        data={
            'success': False,
            'message': 'Invalid email or password',
            'errors': serializer.errors
        },
        status=400
    )


@api_view(['GET'])
@authentication_classes([TokenAuthentication])
@permission_classes([IsAuthenticated])
def user(request):
    serializer = UserSerializer(instance=request.user)
    return Response(
        data={
            'success': True,
            'message': 'User fetch successful',
            'data': serializer.data
        },
        status=200
    )

