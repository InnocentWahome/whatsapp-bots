from rest_framework.authentication import TokenAuthentication as BaseTokenAuthentication


class TokenAuthentication(BaseTokenAuthentication):
    def authenticate(self, request):
        """ dont raise an exception if it is a graphql endpoint"""
        try:
            return super().authenticate(request)
        except Exception as e:
            if request.path not in ['/graphql', '/graphiql']:
                raise e
            return None
