<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel World</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        [data-bs-theme="dark"] body { background: #0f172a !important; color: #e2e8f0; }
        [data-bs-theme="dark"] .card { background: #1e293b; color: #e2e8f0; }
        [data-bs-theme="dark"] .table { --bs-table-bg: #1e293b; --bs-table-color: #e2e8f0; }
        .flag-emoji { font-size: 1.25rem; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="/">🌍 Laravel World</a>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('countries.index') }}" class="btn btn-outline-light btn-sm">Countries</a>
            <a href="{{ route('states.index') }}" class="btn btn-outline-light btn-sm">States</a>
            <a href="{{ route('cities.index') }}" class="btn btn-outline-light btn-sm">Cities</a>

            <button type="button" class="btn btn-outline-light btn-sm" id="themeToggle" title="Toggle Dark Mode">
                🌙
            </button>
        </div>
    </div>
</nav>

<div class="container">

    @yield('content')

</div>

<!-- Toast container for AJAX/flash messages -->
<div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer"></div>

<script src="{{ asset('js/world.js') }}"></script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: @json(session('success')),
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    });
</script>
@endif

@stack('scripts')
</body>
</html>
