from payments.stk import initiate_stk
from django.test import TestCase


class STKTestCase(TestCase):
    def setUp(self) -> None:
        self.phone_number = '254797792447'
        self.redirect_url = 'https://callback-pg.herokuapp.com/subscription-stk'
        self.amount = 10.0

    def test_initiate_payments(self):
        response = initiate_stk(
            phone_number=self.phone_number,
            amount=self.amount,
            callback_url=self.redirect_url,
            account_ref="Name With Space"
        )
