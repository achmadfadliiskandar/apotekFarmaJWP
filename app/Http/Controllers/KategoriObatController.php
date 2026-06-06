<?php

namespace App\Http\Controllers;
use App\Models\KategoriObat;


use Illuminate\Http\Request;

class KategoriObatController extends Controller
{
    public function index()
    {
        $kategori = KategoriObat::all();
        return view('kategori_obat.index', compact('kategori'));
    }
    public function create(){
        return view('kategori_obat.create');
    }
    public function store(Request $request){
        $request->validate([
            'nama_kategori' => 'required|max:100',
        ]);
        $kategori_obat = KategoriObat::create([
            'nama_kategori'=> $request->nama_kategori
        ]);
        return redirect()->route('kategori_obat.index')->with('success', 'Kategori obat berhasil ditambahkan!');
    }
    public function edit($id)
    {
        $kategori = KategoriObat::findOrFail($id);
        return view('kategori_obat.edit', compact('kategori'));
    }
    public function update(Request $request, $id)
    {
        // 1. Validasi inputan edit
        $request->validate([
            'nama_kategori' => 'required|max:100',
        ]);
        $kategori = KategoriObat::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);
        return redirect()->route('kategori_obat.index')->with('success', 'Kategori obat berhasil diperbarui!');
    }
    public function destroy($id)
    {
        $kategori = KategoriObat::findOrFail($id);
        $kategori->delete();
        return redirect()->route('kategori_obat.index')->with('success', 'Kategori obat berhasil dihapus!');
    }
}