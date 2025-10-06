<?php

namespace App\Models;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Admin extends Authenticatable
{
    use  HasFactory, Notifiable;

    protected $table = 'admins';

    protected $fillable = [
        'name',
        'password',
        'email',
        'image',
        'phone',
        'role',
    ];

    protected $hidden = ['password'];
    protected $primaryKey = 'id';
}
