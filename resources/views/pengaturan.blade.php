@extends('templates.master')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="container-fluid px-0">
    
    <div class="mb-4">
        <h4 class="fw-bold text-dark mb-1">Pengaturan Pengguna</h4>
        <p class="text-muted small mb-0">Kelola informasi profil Anda dan perbarui kata sandi keamanan akun secara berkala.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm small mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm small mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        
        <div class="col-md-5">
            <div class="card border-0 shadow-sm bg-white h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-person-text text-primary me-2"></i>Informasi Profil</h5>
                    <hr class="text-muted opacity-20 my-3">
                </div>
                <div class="card-body px-4 pb-4 pt-2">
                    
                    <form action="{{ route('pengaturan.profil') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="text-center mb-4">
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm border" style="width: 90px; height: 90px;">
                                <i class="bi bi-person-vcard text-secondary fs-1"></i>
                            </div>
                            <h6 class="fw-bold text-dark mt-3 mb-1">{{ Auth::user()->name }}</h6>
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-20 px-2.5 py-1.5 small text-uppercase">
                                <i class="bi bi-shield-lock-fill me-1"></i> {{ str_replace('_', ' ', Auth::user()->role ?? 'Petugas') }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary mb-1">ID Pengguna (Primary Key)</label>
                            <input type="text" class="form-control bg-light text-muted small fw-mono" value="{{ Auth::id() }}" readonly disabled>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold small text-secondary mb-1">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control small @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold small text-secondary mb-1">Alamat Email / Username <span class="text-danger">*</span></label>
                            <input type="email" class="form-control small @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center gap-2 shadow-sm fw-semibold">
                                <i class="bi bi-save"></i> Simpan Perubahan Profil
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card border-0 shadow-sm bg-white h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-key text-warning me-2"></i>Perbarui Kata Sandi</h5>
                    <hr class="text-muted opacity-20 my-3">
                </div>
                <div class="card-body p-4 pt-2">
                    <form action="{{ route('pengaturan.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold small text-secondary">Kata Sandi Saat Ini <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary border-end-0"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control border-start-0 @error('current_password') is-invalid @enderror" id="current_password" name="current_password" placeholder="Masukkan kata sandi lama Anda" required>
                                @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold small text-secondary">Kata Sandi Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary border-end-0"><i class="bi bi-shield-plus"></i></span>
                                <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Minimal 8 karakter kombinasi" required>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold small text-secondary">Ulangi Kata Sandi Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary border-end-0"><i class="bi bi-shield-check"></i></span>
                                <input type="password" class="form-control border-start-0" id="password_confirmation" name="password_confirmation" placeholder="Pastikan ketikan harus sama persis" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-warning px-4 d-flex align-items-center gap-2 shadow-sm fw-semibold text-dark">
                                <i class="bi bi-check-all fs-5"></i> Simpan Kata Sandi Baru
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection