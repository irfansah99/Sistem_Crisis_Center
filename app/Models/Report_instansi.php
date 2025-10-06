<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report_instansi extends Model
{
    use HasFactory;
    protected $table = 'report_instansi';
    protected $fillable = [
        'report_id',
        'admin_id',
        'instansi_id',
        'status',
        'catatan_intansi',
    ];

    protected $primaryKey = 'id';

    public function report() {
        return $this->belongsTo(Report::class, 'report_id');
    }
    public function admin() {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'instansi_id');
    }
    
}
