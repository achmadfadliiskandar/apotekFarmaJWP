document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebarMenu");
    const overlay = document.getElementById("sidebarOverlay");
    const btnToggle = document.getElementById("btnSidebarToggle");
    const btnClose = document.getElementById("btnSidebarClose");

    // 1. Aksi Membuka Sidebar di Layar HP
    if (btnToggle) {
        btnToggle.addEventListener("click", function () {
            sidebar.classList.add("show");
            overlay.classList.add("show");
        });
    }

    // 2. Fungsi Menutup Sidebar
    function closeSidebar() {
        if (sidebar) sidebar.classList.remove("show");
        if (overlay) overlay.classList.remove("show");
    }

    // Jalankan penutupan jika tombol silang atau area hitam luar diklik
    if (btnClose) btnClose.addEventListener("click", closeSidebar);
    if (overlay) overlay.addEventListener("click", closeSidebar);
});