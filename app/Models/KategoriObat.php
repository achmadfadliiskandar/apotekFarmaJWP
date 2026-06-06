<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriObat extends Model
{
    protected $fillable = ['nama_kategori'];
    public function daftarObat()
    {
        return $this->hasMany(DaftarObat::class, 'kategori_obats_id', 'id');
    }
}
