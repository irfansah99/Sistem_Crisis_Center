<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class ReportInstansiCreate extends Notification implements ShouldQueue
{
    use Queueable;

    protected $laporan;


    public function __construct($laporan)
    {
        $this->laporan = $laporan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        Log::info('DEBUG ReportInstansiCreate', $this->laporan->toArray());
        return (new MailMessage)
            ->subject("Pemberitahuan untuk {$notifiable->nama_instansi}: Admin {$this->laporan->admin->name} telah meneruskan laporan")
            ->greeting("Halo {$notifiable->nama_instansi} 👋")
            ->line("Admin telah meneruskan laporan dengan deskripsi: {$this->laporan->report->deskripsi}. Mohon segera ditindaklanjuti.")
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
            'pesan'      => ("Admin telah meneruskan laporan dengan deskripsi: {$this->laporan->report->deskripsi}. Mohon segera ditindaklanjuti."),
        ];
    }
}
