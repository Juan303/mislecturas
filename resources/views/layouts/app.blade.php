<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>{{ env('APP_NAME') }}</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">
        <meta name="csrf_token" content="{{ csrf_token() }}" />

        <!-- Favicons -->
        <link href="{{ asset('images/favicon.ico') }}" rel="icon">
        <!-- Google Fonts -->
<!--        <link rel="preconnect" href="https://fonts.gstatic.com">-->
<!--        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800" rel="stylesheet">-->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons+Outlined" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <!-- BOOTSTRAP TABLE CDN -->
        <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/group-by-v2/bootstrap-table-group-by.css">
        <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.2/dist/bootstrap-table.min.css">
        <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.2/dist/extensions/sticky-header/bootstrap-table-sticky-header.css" >
        <!-- JQUERY UI -->
        <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">
        <!-- DROPZONE -->
<!--        <link href="{{ asset('css/dropzone.css') }}" rel="stylesheet" />-->
        <!-- MATERIAL KIT -->
        <link href="{{ asset('css/material-kit.css?v=2.0.5') }}" rel="stylesheet" />

<!--        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">-->


        <link href="{{ asset('css/imagehover.css') }}" rel="stylesheet">
        <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="{{ asset('css/lightgallery.css') }}" />
        <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.2/css/uikit.min.css" />
        <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css" />

        <!-- Progress bar CSS -->
        <link href="{{ asset('css/progress-bar.css') }}" rel="stylesheet">

        <!-- MI CSS -->
        <link href="{{ asset('css/mi_css.css') }}" rel="stylesheet">


        @yield('styles')
        <style>
            .material-icons-outlined.md-18 { font-size: 18px; }
            .material-icons-outlined.md-24 { font-size: 24px; }
            .material-icons-outlined.md-36 { font-size: 36px; }
            .material-icons-outlined.md-48 { font-size: 48px; }

            .far.md-18, .fas.md-18 { font-size: 18px!important; }
            .far.md-24, .fas.md-24 { font-size: 24px!important; }
            .far.md-36, .fas.md-36 { font-size: 36px!important; }
            .far.md-48, .fas.md-48 { font-size: 48px!important; }
        </style>
    </head>

    <body class="sidebar-collapse" data-spy="scroll">
    <div class="loader">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <p>Buscando información...</p>
                </div>
            </div>
        </div>
    </div>
        {{--@include('cookieConsent::index', ['cookieText' => $cookieText])--}}
        @yield('navigation')
        <div class="wrapper bg-white">
            {{--@include('partials.messages.general_messages')--}}
            @yield('content')
        </div>
        @include('partials.footers.footer')
        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="{{ asset('js/core/popper.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/core/bootstrap-material-design.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/material-kit.js?v=2.0.5') }}"></script>
        <script src="{{ asset('js/jquery-ui-1.12.1/jquery-ui.js') }}" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js" type="text/javascript"></script>
        {{--<!-- PROGRESS BARS -->--}}
        <script src="{{ asset('js/progress-bar.js') }}" type="text/javascript"></script>
        {{--<!-- BUSCADORES -->--}}
        <script src="{{ asset('js/buscadores.js') }}" type="text/javascript"></script>
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- bootstrap-table CDN -->
        <script src="https://unpkg.com/bootstrap-table@1.18.2/dist/bootstrap-table.min.js"></script>
        <script src="https://unpkg.com/bootstrap-table@1.18.2/dist/locale/bootstrap-table-es-ES.min.js"></script>
        <script src="https://unpkg.com/bootstrap-table@1.18.2/dist/extensions/group-by-v2/bootstrap-table-group-by.min.js"></script>

        <!-- Charts -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


        <script src="{{ asset('js/alertas.js') }}" type="text/javascript"></script>
        <!-- moment.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        @if(session('message'))
            <script>
                $(document).ready(function () {
                    @if(session('message')['type'] == 'danger')
                        alertErrorTopEnd('{{ session('message')['text'] }}');
                    @elseif(session('message')['type'] == 'success')
                        alertSuccessTopEnd('{{ session('message')['text'] }}');
                    @elseif(session('message')['type'] == 'warning')
                        alertWarningTopEnd('{{ session('message')['text'] }}');
                    @else
                        alertInfoTopEnd('{{ session('message')['text'] }}');
                    @endif
                })
            </script>
        @endif
        {{--<!-- Gestor Lecturas -->--}}
        <script src="{{ asset('js/gestion-lecturas.js?v='.time()) }}" type="text/javascript"></script>
        {{--<!-- Gestion Mangas -->--}}
        <script src="{{ asset('js/gestion-mangas.js?v='.time()) }}" type="text/javascript"></script>
        {{--<!-- Gestion Colecciones -->--}}
        @yield('scripts')
        <script>
            $(document).ready(function () {
                $(".progress-new-bar").ProgressBar();
                accionesLectura();
            });
        </script>
        <script src="{{ asset('js/common.js?v=5') }}" type="text/javascript"></script>
        <script src="{{ asset('js/formatter.js?v=5') }}" type="text/javascript"></script>
        <!-- VENTANAS MODALES GENERALES -->
        @include('partials.messages.modal_delete')
        @yield('modals')
        {!!  GoogleReCaptchaV3::init() !!}
    </body>
</html>
