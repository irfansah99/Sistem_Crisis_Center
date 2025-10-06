<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $table = 'reports';
    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'level_krisis',
        'kategori',
        'lokasi',
        'foto',
        'catatan_admin',
        'status',
    ];

    protected $primaryKey = 'id';

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
