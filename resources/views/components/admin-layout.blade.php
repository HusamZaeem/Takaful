<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Panel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('head')

    <style>
    #sidebar .sidebar-icon {
    width: 24px !important;
    height: 24px !important;
    min-width: 24px;
    min-height: 24px;
    transition: all 0.3s ease-in-out;
    flex-shrink: 0;
    }

    #sidebar.collapsed .sidebar-icon {
        width: 32px !important;
        height: 32px !important;
    }

    #sidebar.collapsed .nav-label {
        display: none;
    }

    #sidebar.collapsed button {
        justify-content: center;
    }
</style>



</head>
<body class="antialiased bg-gray-700 min-h-screen">
    {{ $slot }}

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: @json(session('success')),
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                });
            });
        </script>
    @endif

    @stack('scripts')
</body>
</html>