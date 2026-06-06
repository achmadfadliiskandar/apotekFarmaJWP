<div class="col-md-3 col-lg-2 px-0 sidebar d-flex flex-column">
    <div class="p-3 text-center border-bottom border-white border-opacity-25">
        <h5 class="fw-bold mb-0 text-white"><i class="bi bi-capsule-capsule me-2"></i>JeWePE Farma</h5>
    </div>

    <ul class="nav flex-column mt-3 flex-grow-1">
        <li class="nav-item">
            <a class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        @php
            // Cek apakah salah satu sub-menu master data sedang aktif
            $isMasterActive = Route::is('kategori_obat.*') || Route::is('daftar_obat.*') || Route::is('users.*');
        @endphp
        <li class="nav-item mt-2">
            <a class="nav-link {{ $isMasterActive ? '' : 'collapsed' }}" 
               data-bs-toggle="collapse" 
               href="#menuMasterData" 
               role="button" 
               aria-expanded="{{ $isMasterActive ? 'true' : 'false' }}" 
               aria-controls="menuMasterData">
                <div class="d-flex w-100 align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-folder-fill text-warning"></i>
                        <span>Master Data</span>
                    </div>
                    <i class="bi bi-chevron-down arrow-icon small"></i>
                </div>
            </a>
            
            <div class="collapse {{ $isMasterActive ? 'show' : '' }}" id="menuMasterData">
                <ul class="nav flex-column ms-3 ps-2 border-start border-white border-opacity-25">
                    @if (Auth::user()->role == 'admin_utama')
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ Route::is('kategori_obat.*') ? 'active' : '' }}" href="{{ route('kategori_obat.index') }}">
                            <i class="bi bi-tag"></i> Kategori Obat
                        </a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ Route::is('daftar_obat.*') ? 'active' : '' }}" href="{{ route('daftar_obat.index') }}">
                            <i class="bi bi-capsule"></i> Daftar Obat
                        </a>
                    </li>
                    @if (Auth::user()->role == 'admin_utama')
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ Route::is('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                            <i class="bi bi-people"></i> Manajemen Pengguna
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </li>

        @php
            // Cek apakah salah satu sub-menu transaksi sedang aktif
            $isTransaksiActive = Route::is('stok-masuk') || Route::is('stok-keluar');
        @endphp
        <li class="nav-item mt-2">
            <a class="nav-link {{ $isTransaksiActive ? '' : 'collapsed' }}" 
               data-bs-toggle="collapse" 
               href="#menuTransaksiStok" 
               role="button" 
               aria-expanded="{{ $isTransaksiActive ? 'true' : 'false' }}" 
               aria-controls="menuTransaksiStok">
                <div class="d-flex w-100 align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left-right text-info"></i>
                        <span>Transaksi Stok</span>
                    </div>
                    <i class="bi bi-chevron-down arrow-icon small"></i>
                </div>
            </a>
            
            <div class="collapse {{ $isTransaksiActive ? 'show' : '' }}" id="menuTransaksiStok">
                <ul class="nav flex-column ms-3 ps-2 border-start border-white border-opacity-25">
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ Route::is('stok-masuk') ? 'active' : '' }}" href="{{ route('stok-masuk') }}">
                            <i class="bi bi-arrow-down-left-circle text-success"></i> Stok Masuk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ Route::is('stok-keluar') ? 'active' : '' }}" href="{{ route('stok-keluar') }}">
                            <i class="bi bi-arrow-up-right-circle text-danger"></i> Stok Keluar
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::is('laporan') ? 'active' : '' }}" href="{{ route('laporan') }}">
                <i class="bi bi-file-earmark-text"></i> Laporan
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Route::is('pengaturan') ? 'active' : '' }}" href="{{ route('pengaturan') }}">
                <i class="bi bi-gear-fill"></i> Pengaturan
            </a>
        </li>
        
        <li class="nav-item mt-2">
            <form action="{{ url('logout') }}" method="POST">
                @csrf 
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-right text-danger"></i> Keluar
                </button>
            </form>
        </li>
    </ul>
</div>