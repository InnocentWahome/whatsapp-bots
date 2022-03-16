import json

import requests
from root import settings


class STK(object):
    def __init__(self, organization_id, client_id, client_secret):
        self.organization_id = organization_id
        self.client_id = client_id
        self.client_secret = client_secret

    @property
    def access_token(self):
        url = f'https://tujenge.io/oauth/token'
        response = requests.post(
            url,
            json={
                "grant_type": "client_credentials",
                "client_id": self.client_id,
                "client_secret": self.client_secret
            }
        )
        return response.json()["access_token"]

    def initiate(self, phone_number: str, amount, callback_url, account_ref, description=None):
        url = 'https://tujenge.io/api/v1/quick/payments'
        headers = {
            "Authorization": f"Bearer {self.access_token}",
            "Content-Type": "application/json",
        }

        request = {
            "organizationId": self.organization_id,
            "externalIdentifier": account_ref,
            "phoneNumber": phone_number.replace('254', '0'),
            "amount": amount,
            "callBackUrl": callback_url
        }
        response = requests.post(url, json=request, headers=headers)
        print(response.json())
        return response.json()


stk = STK(**settings.TUJENGE_CONFIG)


def initiate_stk(phone_number, amount, callback_url, account_ref):
    return stk.initiate(phone_number, amount, callback_url, account_ref)
