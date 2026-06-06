@extends('templates.master')

@section('title', 'Edit Data Petugas')

@section('content')
<div class="container-fluid px-0" style="max-width: 800px;">
    
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary rounded-circle px-2">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h4 class="fw-bold text-dark mb-1">Ubah Informasi Petugas</h4>
            <p class="text-muted small mb-0">Perbarui profil data login atau tingkat otorisasi akun pengguna.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm bg-white">
        <div class="card-body p-4">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold small text-secondary">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold small text-secondary">Alamat Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold small text-secondary">Ubah Password Baru</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengganti password lama">
                    <div class="form-text text-muted extra-small">Isi kolom ini hanya jika petugas yang bersangkutan ingin menyetel ulang kata sandinya.</div>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label for="role" class="form-label fw-semibold small text-secondary">Level Hak Akses / Role <span class="text-danger">*</span></label>
                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                        <option value="admin_staff" {{ old('role', $user->role) == 'admin_staff' ? 'selected' : '' }}>Admin Staff (Operator)</option>
                        <option value="admin_super" {{ old('role', $user->role) == 'admin_super' ? 'selected' : '' }}>Admin Utama (Full Access)</option>
                    </select>
                    @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-3">
                    <a href="{{ route('users.index') }}" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-warning text-dark fw-semibold px-4"><i class="bi bi-check-circle me-1"></i> Simpan Pembaruan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection