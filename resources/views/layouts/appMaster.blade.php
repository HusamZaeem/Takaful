<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="TemplateMo">
        <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
        

        <title>@yield('title')</title>

        
        @include('layouts.stylesheets')
        
    </head>

    <body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white">

        @include('partials.nav')


        @yield('banner')


        @yield('content')


        @include('partials.footer')
        

        @include('layouts.scripts')
        



       

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            @if(session('success') || session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    @if(session('success'))
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: @json(session('success')),
                            timer: 7000,
                            timerProgressBar: true,
                            showConfirmButton: false
                        });
                    @elseif(session('error'))
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: @json(session('error')),
                            showConfirmButton: true
                        });
                    @endif
                });
            </script>
            @endif

        
        
    </body>


</html>