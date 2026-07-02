<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Job Tracker') }}</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #1e2a3b 0%, #2d3e54 50%, #1e2a3b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .auth-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 10px 40px rgba(0,0,0,.2);
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
        }
        .auth-logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .auth-logo i {
            font-size: 2.5rem;
            color: #4361ee;
        }
        .auth-logo h4 {
            font-weight: 700;
            color: #1e2a3b;
            margin-top: .5rem;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-logo">
            <i class="bi bi-briefcase-fill"></i>
            <h4>Job Tracker</h4>
        </div>

        {{ $slot }}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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

        function togglePassword(inputId, iconElement) {
            const input = document.getElementById(inputId);
            const icon = iconElement.querySelector('i');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>
