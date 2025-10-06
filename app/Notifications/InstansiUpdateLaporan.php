<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InstansiUpdateLaporan extends Notification implements ShouldQueue
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
            ->subject("Dear {$notifiable->name}, instansi {$this->laporan->instansi->nama_instansi} telah mengirim laporan")
            ->greeting("Halo {$notifiable->name} 👋")
            ->line("instansi {$this->laporan->instansi->nama_instansi} telah memperbarui laporan.")
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
            'pesan'      => ("instansi {$this->laporan->instansi->nama_instansi} telah memperbarui laporan."),
        ];
    }
}
