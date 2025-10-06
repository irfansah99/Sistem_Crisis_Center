<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Instansi extends Authenticatable
{
    use  HasFactory, Notifiable;
    protected $table = 'instansi';
    protected $fillable = [
        'nama_instansi',
        'jenis',
        'phone',
        'image',
        'email',
        'alamat',
        'password',
    ];

    protected $primaryKey = 'id';
    protected $hidden = ['password'];
}
