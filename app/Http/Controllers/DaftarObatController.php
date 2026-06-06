<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriObat;
use App\Models\DaftarObat;
use Illuminate\Support\Facades\Auth;


class DaftarObatController extends Controller
{
    public function index()
    {
        $daftarObat = DaftarObat::with('kategoriObat')->get();
        return view('daftar_obat.index', compact('daftarObat'));
    }
    public function create()
    {
        $kategori = KategoriObat::all();
        return view('daftar_obat.create', compact('kategori'));
    }
    public function store(Request $request)
    {
        // 1. Validasi input sesuai panjang varchar dan kriteria tabel database
        $request->validate([
            'kategori_obats_id' => 'required|exists:kategori_obats,id',
            'kode_obat'        => 'required|max:20|unique:daftar_obats,kode_obat',
            'nama_obat'        => 'required|max:150',
            'stok'             => 'required|integer|min:0',
            'satuan'           => 'required|max:30',
        ], [
            'kode_obat.unique' => 'Kode obat sudah terdaftar di sistem!',
            'stok.min'         => 'Stok awal tidak boleh bernilai minus!'
        ]);

        // 2. Menyimpan data obat ke tabel dengan mengikat user_id yang sedang aktif login
        DaftarObat::create([
            'kategori_obats_id' => $request->kategori_obats_id,
            'user_id'          => Auth::id(), // Mengisi user_id otomatis dari admin yang login
            'kode_obat'        => $request->kode_obat,
            'nama_obat'        => $request->nama_obat,
            'stok'             => $request->stok,
            'satuan'           => $request->satuan,
        ]);

        // 3. Kembali ke index obat dengan pesan sukses
        return redirect()->route('daftar_obat.index')->with('success', 'Data obat baru berhasil disimpan!');
    }
    public function edit($id)
    {
        $obat = DaftarObat::findOrFail($id);
        $kategori = KategoriObat::all();
        return view('daftar_obat.edit', compact('obat', 'kategori'));
    }
    public function update(Request $request, $id)
    {
        $obat = DaftarObat::findOrFail($id);

        // 1. Validasi data (Kecualikan pemeriksaan unik untuk kode_obat milik data ini sendiri)
        $request->validate([
            'kategori_obats_id' => 'required|exists:kategori_obats,id',
            'kode_obat'        => 'required|max:20|unique:daftar_obats,kode_obat,' . $id,
            'nama_obat'        => 'required|max:150',
            'stok'             => 'required|integer|min:0',
            'satuan'           => 'required|max:30',
        ]);

        // 2. Jalankan pembaruan data
        $obat->update([
            'kategori_obats_id' => $request->kategori_obats_id,
            'user_id'          => Auth::id(), // Pencatat diperbarui ke user terakhir yang mengubahnya
            'kode_obat'        => $request->kode_obat,
            'nama_obat'        => $request->nama_obat,
            'stok'             => $request->stok,
            'satuan'           => $request->satuan,
        ]);

        return redirect()->route('daftar_obat.index')->with('success', 'Data obat berhasil diperbarui!');
    }
    public function destroy($id)
    {
        $obat = DaftarObat::findOrFail($id);
        $obat->delete();
        return redirect()->route('daftar_obat.index')->with('success', 'Data obat berhasil dihapus dari sistem!');
    }
}
