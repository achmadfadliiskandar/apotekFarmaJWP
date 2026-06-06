<footer class="bg-white border-top py-3 px-4 mt-auto">
    <div class="container-fluid px-0">
        <div class="row align-items-center justify-content-between flex-column flex-sm-row">
            <div class="col-auto text-center text-sm-start mb-2 mb-sm-0">
                <p class="mb-0 small text-muted">
                    &copy; {{ date('Y') }} <span class="fw-semibold text-primary">JeWePE Farma</span>. All rights reserved.
                </p>
            </div>
            <div class="col-auto text-center text-sm-end">
                <span class="badge bg-light text-secondary border small px-2 py-1.5">
                    <i class="bi bi-info-circle me-1"></i> Laravel v{{ app()->version() }}
                </span>
            </div>
        </div>
    </div>
</footer>