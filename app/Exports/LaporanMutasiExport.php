<?php

namespace App\Exports;

use App\Models\MutasiObat;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class LaporanMutasiExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $tanggal_awal;
    protected $tanggal_akhir;

    // Menangkap parameter filter tanggal dari controller
    public function __construct($tanggal_awal, $tanggal_akhir)
    {
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
    }

    /**
     * Query data ke database MySQL (Mendukung filter tanggal)
     */
    public function query()
    {
        $query = MutasiObat::with(['daftarObat', 'user']);

        if (!empty($this->tanggal_awal)) {
            $query->where('tanggal', '>=', $this->tanggal_awal);
        }

        if (!empty($this->tanggal_akhir)) {
            $query->where('tanggal', '<=', $this->tanggal_akhir);
        }

        return $query->orderBy('tanggal', 'desc');
    }

    /**
     * Menentukan Header / Judul Kolom Baris Pertama di Excel
     */
    public function headings(): array
    {
        return [
            'No',
            'Daftar Obat ID',
            'Nama Obat',
            'User ID',
            'Nama Petugas',
            'Jenis Mutasi',
            'Jumlah',
            'Satuan',
            'Tanggal',
            'Keterangan'
        ];
    }

    /**
     * Memetakan data dari database ke baris kolom Excel secara rapi
     */
    private $rowNumber = 0;
    public function map($mutasi): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $mutasi->daftar_obats_id,
            $mutasi->daftarObat->nama_obat ?? 'Obat Tidak Ditemukan',
            $mutasi->user_id,
            $mutasi->user->name ?? 'System',
            strtoupper($mutasi->jenis), // MASUK / KELUAR
            $mutasi->jenis == 'masuk' ? '+' . $mutasi->jumlah : '-' . $mutasi->jumlah,
            $mutasi->daftarObat->satuan ?? '',
            Carbon::parse($mutasi->tanggal)->format('d-m-Y'),
            $mutasi->keterangan ?? '-'
        ];
    }
}