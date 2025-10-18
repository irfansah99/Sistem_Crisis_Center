<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailInstansiVerified extends Notification implements ShouldQueue
{
    use Queueable;
    protected $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Dear ' . $notifiable->name . ', Ini adalah kode OTP anda')
            ->greeting('Halo ' . $notifiable->name)
            ->line($this->otp)
            ->line('hanya berlaku 5 menit, jangan bagikan kode ini ke orang lain')
            ->salutation('Hormat kami, Crisis Center Jakarta Timur');
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
