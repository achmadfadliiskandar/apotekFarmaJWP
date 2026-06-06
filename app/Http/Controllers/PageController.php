<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MutasiObat;
use App\Models\DaftarObat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash; // Wajib di-import jika menggunakan Hash::make
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LaporanMutasiExport;
use Maatwebsite\Excel\Facades\Excel;


class PageController extends Controller
{
    /**
     * Menampilkan halaman Transaksi Stok Masuk
     */
    public function stokMasukIndex()
    {
        $daftarObat = DaftarObat::orderBy('nama_obat', 'asc')->get();

        // 2. Ambil riwayat khusus mutasi 'masuk' untuk tabel bagian bawah
        // Menggunakan eager loading (with) agar query ringan saat memuat nama obat dan nama user pencatat
        $mutasiMasuk = MutasiObat::with(['daftarObat', 'user'])
                        ->where('jenis', 'masuk')
                        ->orderBy('tanggal', 'desc')
                        ->get();
        return view('stok-masuk',compact('daftarObat', 'mutasiMasuk'));
    }
    public function stokMasukStore(Request $request){
        $request->validate([
            'daftar_obats_id' => 'required|exists:daftar_obats,id',
            'jumlah'         => 'required|integer|min:1',
            'keterangan'     => 'nullable|string|max:255',
        ]);
        MutasiObat::create([
            'daftar_obats_id' => $request->daftar_obats_id,
            'user_id'        => Auth::id(), // ID Petugas yang login
            'jenis'          => 'masuk',
            'jumlah'         => $request->jumlah,
            'keterangan'     => $request->keterangan ?? 'Suplai Stok Masuk',
            'tanggal'        => now(), // Mengisi waktu saat ini
        ]);

        // 3. UPDATE/TAMBAH STOK FISIK DI TABEL DAFTAR OBAT
        $obat = DaftarObat::findOrFail($request->daftar_obats_id);
        $obat->increment('stok', $request->jumlah); // Otomatis menambahkan stok lama + jumlah baru
        return redirect()->route('stok-masuk')->with('success', 'Transaksi stok masuk berhasil dicatat dan stok obat telah bertambah!');
    }

    /**
     * Menampilkan halaman Transaksi Stok Keluar
     */
    public function stokKeluarIndex()
    {
        // 1. Ambil semua data obat untuk dropdown select form atas
        $daftarObat = DaftarObat::orderBy('nama_obat', 'asc')->get();

        // 2. Ambil riwayat khusus mutasi 'keluar' untuk tabel bagian bawah
        $mutasiKeluar = MutasiObat::with(['daftarObat', 'user'])
                        ->where('jenis', 'keluar')
                        ->orderBy('tanggal', 'desc')
                        ->get();
        return view('stok-keluar',compact('daftarObat', 'mutasiKeluar'));
    }

    public function stokKeluarStore(Request $request)
    {
        $request->validate([
            'daftar_obats_id' => 'required|exists:daftar_obats,id',
            'jumlah'         => 'required|integer|min:1',
            'keterangan'     => 'nullable|string|max:255',
        ]);
        $detail_obat = DaftarObat::findOrFail($request->daftar_obats_id);
        if ($detail_obat->stok == 0) {
            return redirect()->back()->with('error', 'Transaksi gagal! Stok obat ini sudah habis (0).')->withInput();
        }
        if ($request->jumlah > $detail_obat->stok) {
            return redirect()->back()->with('error', 'Transaksi gagal! Jumlah pengeluaran (' . $request->jumlah . ') melebihi sisa stok yang ada (' . $obat->stok . ').')->withInput();
        }
        MutasiObat::create([
            'daftar_obats_id' => $request->daftar_obats_id,
            'user_id'        => Auth::id(),
            'jenis'          => 'keluar',
            'jumlah'         => $request->jumlah,
            'keterangan'     => $request->keterangan ?? 'Pengurangan Stok Keluar',
            'tanggal'        => now(),
        ]);
        $detail_obat->decrement('stok', $request->jumlah);
        return redirect()->route('stok-keluar')->with('success', 'Transaksi stok keluar berhasil dicatat dan stok obat telah dikurangi!');
    }

    /**
     * Menampilkan halaman Laporan
     */
    public function laporanIndex(Request $request)
    {
        $query = MutasiObat::with(['daftarObat', 'user']);

        // 2. Jika input filter 'tanggal_awal' diisi oleh user
        if ($request->filled('tanggal_awal')) {
            $query->where('tanggal', '>=', $request->tanggal_awal);
        }

        // 3. Jika input filter 'tanggal_akhir' diisi oleh user
        if ($request->filled('tanggal_akhir')) {
            $query->where('tanggal', '<=', $request->tanggal_akhir);
        }
        // 4. Ambil datanya dengan urutan transaksi paling baru berada di paling atas tabel
        $semuaMutasi = $query->orderBy('tanggal', 'desc')->get();
        // 5. Kirim data variabel $semuaMutasi ke halaman view laporan.blade.php
        return view('laporan', compact('semuaMutasi'));
    }

    public function laporanPdf(Request $request)
    {
        $query = MutasiObat::with(['daftarObat', 'user']);

        if ($request->filled('tanggal_awal')) {
            $query->where('tanggal', '>=', $request->tanggal_awal);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->where('tanggal', '<=', $request->tanggal_akhir);
        }

        $semuaMutasi = $query->orderBy('tanggal', 'desc')->get();

        // Contoh eksekusi menggunakan DomPDF (pastikan library sudah di-install)
        $pdf = Pdf::loadView('laporan.pdf', compact('semuaMutasi'));
        return $pdf->download('laporan-mutasi-obat.pdf');
    }

    public function laporanExcel(Request $request)
    {
        // 1. Ambil parameter filter dari URL
        $awal  = $request->query('tanggal_awal');
        $akhir = $request->query('tanggal_akhir');

        // 2. Tentukan nama file secara dinamis
        $nama_file = 'laporan-mutasi-stok';
        if ($awal && $akhir) {
            $nama_file .= '-periode-' . $awal . '-sd-' . $akhir;
        } else {
            $nama_file .= '-semua-waktu';
        }
        $nama_file .= '.xlsx';

        // 3. Download berkas spreadsheet Excel
        return Excel::download(new LaporanMutasiExport($awal, $akhir), $nama_file);
    }

    /**
     * Menampilkan halaman Pengaturan
     */
    public function pengaturanIndex()
    {
        return view('pengaturan');
    }
    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        // 1. Validasi Input (Pastikan email unik kecuali untuk email milik user itu sendiri)
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ], [
            'email.unique' => 'Alamat email ini sudah digunakan oleh petugas lain!'
        ]);

        // 2. Update data ke database
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('pengaturan')->with('success', 'Informasi profil Anda berhasil diperbarui!');
    }
    public function updatePassword(Request $request)
    {
        // 1. Validasi Input Form
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:8|confirmed', // 'confirmed' otomatis mencocokkan dengan field password_confirmation
        ], [
            'password.min'       => 'Kata sandi baru minimal harus terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi ulang kata sandi baru tidak cocok dengan yang Anda masukkan.',
        ]);

        $user = Auth::user();

        // 2. Periksa apakah password lama yang diinput cocok dengan di database encryp bcrypt
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Kata sandi saat ini yang Anda masukkan salah.')->withInput();
        }

        // 3. Update Password Baru (Enkripsi dengan Hash::make)
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('pengaturan')->with('success', 'Kata sandi akun Anda berhasil diperbarui!');
    }
}