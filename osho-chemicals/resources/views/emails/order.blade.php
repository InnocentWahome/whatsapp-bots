@component('mail::message')
# Welcome

The customer below would like to enquiry about {{$email->email_message}}.
Here is the contact:<br>
Phone number: {{$email->phone_number}}


@component('mail::button', ['url' => 'http://oshochem.com'])
Visit our website
@endcomponent

Thanks,<br>
Osho Whatsapp Chatbot
@endcomponent
