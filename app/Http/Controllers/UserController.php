<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\KategoriObat;
use App\Models\DaftarObat;
use App\Models\MutasiObat;
use Illuminate\Support\Facades\Hash; // Wajib di-import jika menggunakan Hash::make

class UserController extends Controller
{
    // view login
    public function login(){
        return view('auth/login');
    }
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('dashboard');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    public function dashboard(){
        $totalObat     = DaftarObat::count();
        $totalKategori = KategoriObat::count();
        $totalMutasi   = MutasiObat::count();
        $totalUser     = User::count();
        // mengambil 5 stok terendah dan tertinggi(asc,desc)
        $stokterendah = DaftarObat::orderBy('stok','asc')->take(5)->get();
        $stoktertinggi = DaftarObat::orderBy('stok','desc')->take(5)->get();
        return view('dashboard', compact('totalObat','totalKategori','totalMutasi','totalUser','stokterendah','stoktertinggi'));
    }
    // CRUD MANAJEMEN PENGGUNA (USERS)
    public function index()
    {
        // Mengambil semua user kecuali admin yang sedang login saat ini (agar tidak menghapus diri sendiri)
        $users = User::where('id', '!=', Auth::id())->get();
        
        return view('users.index', compact('users'));
    }
    public function create()
    {
        return view('users.create');
    }

    /**
     * Menyimpan data petugas baru ke database (Store)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:admin_super,admin_staff',
        ], [
            'email.unique' => 'Email ini sudah terdaftar di sistem!',
            'password.min' => 'Password minimal harus 6 karakter.'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password via bcrypt
            'role'     => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'Petugas baru berhasil didaftarkan!');
    }

    /**
     * Menampilkan form edit data petugas (Edit)
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6', // Boleh kosong jika tidak ingin ganti password
            'role'     => 'required|in:admin_super,admin_staff',
        ]);

        // Siapkan data yang akan diupdate
        $dataUpdate = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Jika password diisi di form edit, maka update password barunya
        if ($request->filled('password')) {
            $dataUpdate['password'] = Hash::make($request->password);
        }

        $user->update($dataUpdate);

        return redirect()->route('users.index')->with('success', 'Data petugas berhasil diperbarui!');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Mencegah penghapusan jika user ini masih terikat dengan history di tabel mutasi
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Akun petugas berhasil dihapus!');
    }
}
