<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendCustomerMessageNotification extends Notification
{
    use Queueable;

    protected $message;

    protected $whatsapp_number;

    protected $profile_name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $whatsapp_number, $profile_name)
    {
        $this->message = $message;
        $this->whatsapp_number = $whatsapp_number;
        $this->profile_name = $profile_name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('NEW MESSAGE FROM CHATBOT : ' . $this->whatsapp_number)
            ->greeting('Hello,')
            ->line('You have a new message from : ' . $this->profile_name . ' : ' . $this->whatsapp_number)
            ->line('WhtasApp no : '.$this->whatsapp_number)
            ->line('Message : '.$this->message)
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
