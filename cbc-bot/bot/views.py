import asyncio
import json
import sys
import traceback

from asgiref.sync import sync_to_async
from django.http import HttpResponse

from schools.models import Student, Guardian
from .models import Session
from bot.base_screens import Screen
from .utils import get_screen, get_hook_data, send_whatsapp, send_error_message


def get_message_body(session: Session, text: str, context=None):
    context = {} if not context else context
    if not session.state:
        try:
            student = Student.objects.get(student_code=text)
            screen = get_screen('select_packages', data={
                "student_id": student.id
            })
        except (Student.DoesNotExist, Student.MultipleObjectsReturned):
            # return the default first screen
            screen = get_screen('menu')
        return session.render(screen, context)
    # get current session
    current_screen: Screen = session.current_screen(context)
    # get the next screen
    next_screen = current_screen.next_screen(text)
    if not next_screen:
        session.reset()
        next_screen = get_screen('get_student_id')
    send_error_message(context["phone"], next_screen.errors)
    return session.render(next_screen, context)


def bot_processing(request):
    try:
        if request.method != "POST":
            return HttpResponse("Use POST", status=403)
        data = get_hook_data(request)
        if data:
            phone, session_id, name, text = data
            # session id is the
            session, is_created = Session.objects.get_or_create(session_id=session_id)
            # check if in trigger word and set session appropriately
            trigger_words = ['hi', 'cbc', 'hallo']
            # check if time is expired based on time difference
            if text.lower().strip() in trigger_words:
                session.reset()
            guardian = Guardian.objects.get_from_phone(phone=phone, name=name)
            guardian.log()
            if guardian.has_queue:
                loop = asyncio.new_event_loop()
                loop.run_in_executor(None, guardian.empty_queue)
                return
            context = {
                "phone": phone,
                "name": name,
                "guardian": guardian
            }
            message_body = get_message_body(session, text, context)
            if message_body:
                send_whatsapp(message_body)
    except Exception as e:
        print("-" * 60)
        print(e)
        traceback.print_exc(file=sys.stdout)
        print("-" * 60)


bot_processing_async = sync_to_async(bot_processing, thread_sensitive=False)


async def whatsapp_bot(request):
    data = json.loads(request.body)
    if not data.get("contacts"):
        return HttpResponse("Success")
    # bot_processing(request)
    loop = asyncio.get_event_loop()
    loop.create_task(bot_processing_async(request))
    return HttpResponse("Successful")
