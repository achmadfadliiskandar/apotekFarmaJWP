<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MutasiObat extends Model
{
    protected $fillable = [
        'daftar_obats_id',
        'user_id',        
        'jenis',
        'jumlah',
        'keterangan',
        'tanggal'
    ];
    public function daftarObat()
    {
        return $this->belongsTo(DaftarObat::class, 'daftar_obats_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
