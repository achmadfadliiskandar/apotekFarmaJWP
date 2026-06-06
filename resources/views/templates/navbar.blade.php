<nav class="navbar navbar-expand-lg navbar-white bg-white border-bottom px-4 py-3 shadow-sm">
    <div class="container-fluid px-0">
        <span class="navbar-brand mb-0 h1 fs-5 fw-semibold text-secondary">Apotek Farma JeWePe</span>
        
        <div class="d-flex align-items-center ms-auto">
            <i class="bi bi-person-circle fs-5 me-2 text-primary"></i>
            <span class="fw-medium text-dark">{{ Auth::user()->name ?? 'Admin Utama' }}</span>
        </div>
    </div>
</nav>