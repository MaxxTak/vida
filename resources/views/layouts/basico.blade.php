<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Formulário') }}</title>

    <!-- Styles -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/compartilhado/buttons.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/js/compartilhado/DataTables/Select-1.2.6/css/select.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/js/compartilhado/DataTables/RowReorder-1.2.5/rowReorder.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/compartilhado/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/compartilhado/fullcalendar.min.css') }}" rel="stylesheet">
    
    <script> var base_url = "{{asset('/')}}"; </script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/popper.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/tooltip.min.js') !!}"></script>
    <script src="{{ asset('/js/compartilhado/jquery.min.js') }}"></script>
    <script src="{{ asset('/js/compartilhado/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/compartilhado/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('/js/compartilhado/DataTables/AccentNeutralise/accent-neutralise.js') }}"></script>
    <script src="{{ asset('/js/compartilhado/DataTables/Select-1.2.6/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('/js/compartilhado/DataTables/RowReorder-1.2.5/dataTables.rowReorder.min.js') }}"></script>
    <script src="{{ asset('/js/compartilhado/moment.min.js') }}"></script>

</head>
<body class="app">
    @include('vida.partials.spinner')

    <div>
        <!-- #Left Sidebar ==================== -->
        @include('vida.partials.sidebar')

        <!-- #Main ============================ -->
        <div class="page-container">
            <!-- ### $Topbar ### -->
            @include('vida.partials.topbar')

            <!-- ### $App Screen Content ### -->
            <main class='main-content bgc-grey-100'>
                <div id='mainContent'>
                    <div class="container-fluid">

                        <h4 class="c-grey-900 mT-10 mB-30">@yield('page-header')</h4>

						@include('vida.partials.messages')
						@yield('content')

                    </div>
                </div>
            </main>

            <!-- ### $App Screen Footer ### -->
            <footer class="bdT ta-c p-30 lh-0 fsz-sm c-grey-600">
                <span>Copyright © 2018 IntegrallMed. Desenvolvido por
                    <a href="https://www.haaretecnologia.com.br" target='_blank' title="Haare Tecnologia">Haare Tecnologia</a>. Todos os direitos reservados.</span>
            </footer>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
