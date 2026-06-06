<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarObat extends Model
{
    protected $fillable = [
        'kategori_obats_id', 'user_id', 'kode_obat', 'nama_obat', 'stok', 'satuan'
    ];

    // Relasi balik ke model KategoriObat
    public function kategoriObat()
    {
        return $this->belongsTo(KategoriObat::class, 'kategori_obats_id');
    }
    public function user()
    {
        // Parameter ke-2 adalah Foreign Key di tabel daftar_obat, parameter ke-3 adalah Primary Key di tabel users
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function mutasiObat()
    {
        // Parameter ke-2 adalah Foreign Key di tabel mutasi_obat
        return $this->hasMany(MutasiObat::class, 'daftar_obats_id', 'id');
    }
}
