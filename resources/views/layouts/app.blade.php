<!-- Bootstrap 5 CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Job Tracker') — {{ config('app.name') }}</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --primary: #6366f1;
            --sidebar-bg: #1e2a3b;
            --sidebar-text: #a8b4c8;
            --sidebar-active: #4361ee;
        }

        body { background: #f5f7fb; font-family: 'Segoe UI', sans-serif; }

        /* ── Sidebar ──────────────────────────────── */
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            transition: width .3s;
            overflow-x: hidden;
        }

        #sidebar .brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        #sidebar .brand h5 {
            color: #fff;
            font-weight: 700;
            font-size: .95rem;
            margin: 0;
            white-space: nowrap;
        }

        #sidebar .nav-link {
            color: var(--sidebar-text);
            padding: .55rem 1.5rem;
            border-radius: 0;
            font-size: .875rem;
            display: flex;
            align-items: center;
            gap: .65rem;
            transition: background .2s, color .2s;
            white-space: nowrap;
        }
        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            background: rgba(67,97,238,.25);
            color: #fff;
            border-left: 3px solid var(--sidebar-active);
        }
        #sidebar .nav-section {
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #5d7290;
            padding: 1rem 1.5rem .35rem;
            font-weight: 600;
        }

        /* ── Main Content ─────────────────────────── */
        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Topbar ───────────────────────────────── */
        #topbar {
            background: #fff;
            border-bottom: 1px solid #e5e9f0;
            padding: .75rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 99;
        }

        /* ── Cards ────────────────────────────────── */
        .card { border: none; box-shadow: 0 1px 4px rgba(0,0,0,.06); border-radius: .75rem; }
        .card-header { background: transparent; border-bottom: 1px solid #f0f2f7; padding: 1rem 1.25rem; }

        /* ── Stat Cards ───────────────────────────── */
        .stat-card { border-radius: .75rem; padding: 1.25rem; color: #fff; }
        .stat-card .stat-icon { font-size: 2rem; opacity: .8; }
        .stat-card .stat-number { font-size: 1.75rem; font-weight: 700; }
        .stat-card .stat-label { font-size: .8rem; opacity: .85; }

        /* ── Status Badge Colors ──────────────────── */
        .badge-belum_dilamar { background: #6c757d; }
        .badge-sudah_dilamar { background: #0d6efd; }
        .badge-diproses      { background: #0dcaf0; color: #000; }
        .badge-interview     { background: #ffc107; color: #000; }
        .badge-tes           { background: #fd7e14; }
        .badge-offering      { background: #198754; }
        .badge-ditolak       { background: #dc3545; }
        .badge-diterima      { background: #20c997; }
        .badge-perlu_follow_up { background: #ffc107; color: #000; }
        .badge-tidak_direspon  { background: #6c757d; color: #fff; }

        /* ── Modern Buttons ───────────────────────── */
        .btn-modern {
            font-weight: 600;
            font-size: .875rem;
            padding: .625rem 1.25rem;
            border-radius: .625rem;
            border: none;
            box-shadow: 0 1px 3px rgba(0,0,0,.08);
            transition: all .2s ease;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-modern:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,.12); }
        .btn-modern:active { transform: translateY(0) scale(.98); box-shadow: 0 1px 3px rgba(0,0,0,.08); }
        .btn-modern:disabled, .btn-modern[disabled] { opacity: .45; transform: none; box-shadow: none; cursor: not-allowed; }

        .btn-primary-modern { background: var(--primary); color: #fff; }
        .btn-primary-modern:hover { background: #5558e6; color: #fff; }

        .btn-outline-modern { background: #fff; color: var(--primary); border: 1.5px solid #c7d2fe; }
        .btn-outline-modern:hover { background: #eef2ff; border-color: var(--primary); color: #4f46e5; }

        .btn-danger-modern { background: #ef4444; color: #fff; }
        .btn-danger-modern:hover { background: #dc2626; color: #fff; }

        .btn-warning-modern { background: #f59e0b; color: #fff; }
        .btn-warning-modern:hover { background: #d97706; color: #fff; }

        /* ── Icon-Only Action Buttons (tabel) ────── */
        .btn-action {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            font-size: .9rem;
            border: none;
            box-shadow: 0 1px 3px rgba(0,0,0,.08);
            transition: all .2s ease;
            text-decoration: none;
        }
        .btn-action:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(0,0,0,.12); }
        .btn-action:active { transform: scale(.95); }

        .btn-action-view   { background: #e0e7ff; color: #6366f1; }
        .btn-action-view:hover   { background: #c7d2fe; color: #4f46e5; }
        .btn-action-edit   { background: #dbeafe; color: #3b82f6; }
        .btn-action-edit:hover   { background: #bfdbfe; color: #2563eb; }
        .btn-action-delete { background: #fee2e2; color: #ef4444; }
        .btn-action-delete:hover { background: #fecaca; color: #dc2626; }

        /* ── Sidebar Collapsed (Desktop) ──────────── */
        #sidebar.collapsed { width: 0; }
        #main-content.expanded { margin-left: 0; }

        /* ── Responsive ───────────────────────────── */
        @media (max-width: 768px) {
            #sidebar { width: 0; }
            #sidebar.show { width: var(--sidebar-width); }
            #main-content { margin-left: 0; }
        }
    </style>

    @stack('styles')
</head>
<body>

<!-- ═══════════════════════════════════════════════ -->
<!-- SIDEBAR                                         -->
<!-- ═══════════════════════════════════════════════ -->
<div id="sidebar">
    <div class="brand d-flex align-items-center gap-2">
        <i class="bi bi-briefcase-fill text-primary fs-5"></i>
        <h5>Job Tracker</h5>
    </div>

    <nav class="mt-2">

        {{-- Dashboard --}}
        <div class="nav-section">Utama</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        @if(!auth()->user()->isAdmin())
            {{-- Menu USER --}}
            <div class="nav-section">Lamaran</div>
            <a href="{{ route('jobs.index') }}" class="nav-link {{ request()->routeIs('jobs.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i> Data Lamaran
            </a>
            <a href="{{ route('status-histories.index') }}" class="nav-link {{ request()->routeIs('status-histories.*') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Riwayat Status
            </a>

            <div class="nav-section">Dokumen</div>
            <a href="{{ route('cvs.index') }}" class="nav-link {{ request()->routeIs('cvs.*') ? 'active' : '' }}">
                <i class="bi bi-person-vcard"></i> CV Saya
            </a>
            <a href="{{ route('templates.index') }}" class="nav-link {{ request()->routeIs('templates.*') ? 'active' : '' }}">
                <i class="bi bi-file-richtext"></i> Template Surat
            </a>
            <a href="{{ route('letters.index') }}" class="nav-link {{ request()->routeIs('letters.*') ? 'active' : '' }}">
                <i class="bi bi-envelope-paper"></i> Generate Surat
            </a>
            <a href="{{ route('letters.history') }}" class="nav-link {{ request()->routeIs('letters.history') ? 'active' : '' }}">
                <i class="bi bi-archive"></i> Riwayat Surat
            </a>

            <div class="nav-section">Data</div>
            <a href="{{ route('import.index') }}" class="nav-link {{ request()->routeIs('import.*') ? 'active' : '' }}">
                <i class="bi bi-upload"></i> Import Excel
            </a>
            <a href="{{ route('export.index') }}" class="nav-link {{ request()->routeIs('export.*') ? 'active' : '' }}">
                <i class="bi bi-download"></i> Export Excel
            </a>
        @endif

        {{-- Menu ADMIN only --}}
        @if(auth()->user()->isAdmin())
            <div class="nav-section">Admin</div>
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Manajemen User
            </a>
            <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i> Pengaturan Sistem
            </a>
        @endif

        <div class="nav-section">Akun</div>
        <a href="{{ route('profile.index') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> Profil Saya
        </a>
    </nav>
</div>

<!-- ═══════════════════════════════════════════════ -->
<!-- MAIN CONTENT                                    -->
<!-- ═══════════════════════════════════════════════ -->
<div id="main-content">

    <!-- TOPBAR -->
    <div id="topbar" class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-light" id="sidebarToggle">
                <i class="bi bi-list fs-5"></i>
            </button>
            <span class="text-muted small">@yield('breadcrumb', 'Dashboard')</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted small d-none d-md-block">
                Halo, <strong>{{ auth()->user()->name }}</strong>
                <span class="badge bg-primary ms-1">{{ ucfirst(auth()->user()->role) }}</span>
            </span>
            <form method="POST" action="{{ route('logout') }}" class="d-flex align-items-center m-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- PAGE CONTENT -->
    <div class="p-4 flex-grow-1">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<!-- ═══════════════════════════════════════════════ -->
<!-- SCRIPTS                                         -->
<!-- ═══════════════════════════════════════════════ -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    // Sidebar toggle (Mobile & Desktop)
    document.getElementById('sidebarToggle')?.addEventListener('click', () => {
        if (window.innerWidth <= 768) {
            document.getElementById('sidebar').classList.toggle('show');
        } else {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('main-content').classList.toggle('expanded');
        }
    });

    // Upgrade native confirm() to SweetAlert2 for all forms and elements
    document.addEventListener('DOMContentLoaded', function() {
        // Handle onsubmit in forms
        const deleteForms = document.querySelectorAll('form[onsubmit*="confirm"]');
        deleteForms.forEach(form => {
            const match = form.getAttribute('onsubmit').match(/confirm\('([^']+)'\)/);
            const message = match ? match[1] : 'Apakah Anda yakin ingin melakukan tindakan ini?';
            form.removeAttribute('onsubmit');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                showSweetAlert(message, () => form.submit());
            });
        });

        // Handle onclick in buttons or links
        const confirmElements = document.querySelectorAll('[onclick*="confirm"]');
        confirmElements.forEach(el => {
            const match = el.getAttribute('onclick').match(/confirm\('([^']+)'\)/);
            const message = match ? match[1] : 'Apakah Anda yakin ingin melakukan tindakan ini?';
            el.removeAttribute('onclick');
            el.addEventListener('click', function(e) {
                e.preventDefault();
                showSweetAlert(message, () => {
                    if (el.tagName === 'A') window.location.href = el.href;
                    else if (el.closest('form')) el.closest('form').submit();
                });
            });
        });

        function showSweetAlert(message, onConfirm) {
            Swal.fire({
                title: 'Konfirmasi',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-check-lg me-1"></i> Ya, Lanjutkan',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-4 border-0 shadow-lg',
                    confirmButton: 'btn btn-danger px-4 py-2 mx-2 rounded-3',
                    cancelButton: 'btn btn-light px-4 py-2 mx-2 rounded-3 border'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) onConfirm();
            });
        }
    });
</script>
@stack('scripts')
</body>
</html>