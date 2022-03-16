import json

import requests
from django.conf import settings
from django.template.loader import render_to_string

from .screen_urls import get_screens


def _get_screen(state: str, screen_urls: list, data: dict, errors=None, context: dict = None):
    """searches the screen_urls list and returns the screen"""
    states = [x.state for x in screen_urls]
    if state in states:
        screen_index = states.index(state)
        screen_class = screen_urls[screen_index]
        return screen_class(data, errors, context)
    raise Exception(f"invalid screen url name:{state} not found in urls")


def get_screen(state, data=None, context=None, errors=None):
    return _get_screen(state=state, screen_urls=get_screens(), data=data, errors=errors, context=context)


def get_hook_data(request):
    data = json.loads(request.body)
    if data.get("contacts"):
        sender = data["contacts"][0]
        phone = sender["wa_id"]
        session_id = f"whatsapp:{phone}"
        name = sender["profile"]["name"]
        message = data["messages"][0]
        if message.get('interactive'):
            text = message["interactive"]["list_reply"]["id"]
        else:
            text = message["text"]["body"]
        return phone, session_id, name, text
    return None


def send_whatsapp(message_body: dict):
    url = "https://waba.tujenge.io/api/v1/messages"
    payload = json.dumps(message_body)
    headers = {
        'Content-Type': 'application/json',
        'Authorization': f"Bearer {settings.WABA_API_KEY}"
    }
    try:
        response = requests.request("POST", url, headers=headers, data=payload, timeout=1000)
        if response.status_code != 200:
            print(json.dumps(response.json(), indent=2))
    except ConnectionError:
        print("failed connection")


def send_error_message(phone, errors=None):
    if not errors:
        return
    send_whatsapp({
        "preview_url": False,
        "recipient_type": "individual",
        "to": phone,
        "type": "text",
        "text": {
            "body": render_to_string('bot/errors.txt', context={'errors': errors})
        }
    })
