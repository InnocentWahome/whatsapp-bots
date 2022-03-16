<?php

namespace App\Notifications;

use App\Channels\AfricaIsTalking;
use App\Channels\TumaText;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SendMpesaNumberTwoFactorCode extends Notification implements ShouldQueue
{

    use Queueable;

    protected $mpesa_number_code;

    protected $phone_number;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($mpesa_number_code, $phone_number)
    {
        $this->mpesa_number_code = $mpesa_number_code;
        $this->phone_number = $phone_number;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TumaText::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    /**
     * @param $notifiable
     * @return array
     */
    public function toAfricaIsTalking($notifiable){

        return [
            'numbers' => $this->phone_number,
            'message' => 'Your WhatsApp Code is : '.$this->mpesa_number_code. ' DO NOT share this code with anyone'
        ];
    }

    public function toTumaText($notifiable){

        return [
            'numbers' => $this->phone_number,
            'message' => 'Your WhatsApp Code is : '.$this->mpesa_number_code. ' DO NOT share this code with anyone'
        ];
    }
}
