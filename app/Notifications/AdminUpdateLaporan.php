<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminUpdateLaporan extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $laporan;
    protected $oldData;
    protected $newData;
    
    public function __construct($laporan, $oldData ,$newData )
    {
        $this->laporan = $laporan;
        $this->oldData = $oldData;
        $this->newData = $newData;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Dear ' . $notifiable->name . ', Update Laporan Anda')
            ->greeting('Halo ' . $notifiable->name . ' 👋')
            ->line('Laporan Anda sudah diperbarui oleh admin.')
            ->action('Lihat Laporan', url('/laporan/' . $this->laporan->id))
            ->salutation('Hormat kami, Crisis Center Jakarta Timur');

    }
    

    public function toArray(object $notifiable): array
    {
        $pesanPerubahan = [];
    
        // cek apakah field ada di newData (artinya berubah)
        if (array_key_exists('status', $this->newData)) {
            $pesanPerubahan[] = "Status laporan Anda telah diperbarui.";
        }
    
        if (array_key_exists('level_krisis', $this->newData)) {
            $pesanPerubahan[] = "Level krisis laporan Anda telah diperbarui.";
        }
    
        if (array_key_exists('catatan_admin', $this->newData)) {
            $pesanPerubahan[] = "Catatan laporan Anda telah diperbarui.";
        }
    
        // buat pesan final
        if (empty($pesanPerubahan)) {
            $finalPesan = "Laporan Anda telah diperbarui.";
        } else if (count($pesanPerubahan) === 1) {
            $finalPesan = $pesanPerubahan[0];
        } else {
            $finalPesan = "Laporan Anda telah diperbarui.";
        }
    
        return [
            'laporan_id' => $this->laporan->id,
            'pesan'      => $finalPesan,
        ];
    }
    
    
    
    
}
