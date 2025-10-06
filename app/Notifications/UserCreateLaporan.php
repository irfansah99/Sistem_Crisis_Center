<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class UserCreateLaporan extends Notification implements ShouldQueue
{
    use Queueable;

    protected $laporan;
    public function __construct($laporan)
    {
       $this->laporan = $laporan;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {




        return (new MailMessage)
            ->subject("Dear {$notifiable->name}, User {$this->laporan->user->name} telah mengirim laporan")
            ->greeting("Halo {$notifiable->name} 👋")
            ->line("User {$this->laporan->user->name} telah mengirim laporan dengan deskripsi: {$this->laporan->deskripsi}")
            ->action('Lihat Laporan', url("/laporan/{$this->laporan->id}"))
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
            'laporan_id' => $this->laporan->id,
            'pesan'      => ("User {$this->laporan->user->name} telah mengirim laporan dengan deskripsi: {$this->laporan->deskripsi}"),
        ];
    }
}
