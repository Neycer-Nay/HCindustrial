<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>HC SERVICIOS INDUSTRIAL</title>
    <link rel="icon" href="{{ asset(path: 'img/logoICO.ico') }}" type="image/x-icon">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset(path: 'dist/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset(path: 'dist/assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset(path: 'dist/assets/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset(path: 'dist/assets/modules/weather-icon/css/weather-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset(path: 'dist/assets/modules/weather-icon/css/weather-icons-wind.min.css') }}">
    <link rel="stylesheet" href="{{ asset(path: 'dist/assets/modules/summernote/summernote-bs4.css') }}">

    <!-- Selec2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Lightbox2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
    <!-- icon bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <!-- CSS de Cropper.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset(path: 'dist/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset(path: 'dist/assets/css/components.css') }}">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">

            <!-- header -->
            @include('shared.header')
            <!-- End header -->

            <!-- Sidebar -->
            @include('shared.aside')
            <!--end Sidebar-->
            <!-- Main Content -->

            <!-- Dasboard comentadot -->

            @yield('contenido')


            <!--End Main Content -->
            @include('shared.footer')
            <!--  Footer -->

            <!-- End Footer -->
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset(path: 'dist/assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/modules/popper.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/js/stisla.js') }}"></script>

    <!-- JS Libraies -->
    <script src="{{ asset(path: 'dist/assets/modules/simple-weather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/modules/chart.min.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/modules/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/modules/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset(path: 'dist/assets/js/page/index-0.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset(path: 'dist/assets/js/scripts.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/js/custom.js') }}"></script>

    <!-- Select2  jquery -->

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Swet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Lightbox2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <!-- JS de Cropper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script>
        lightbox.option({
            'albumLabel': 'Foto %1 de %2',  // Personaliza el texto aquí
        });
    </script>

    @yield('scripts')

    @stack('scripts')


</body>

</html>