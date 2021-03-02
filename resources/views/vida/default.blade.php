<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IntegrallMed') }}</title>

    <!-- Styles -->
	<link href="{{ mix('/css/app.css') }}" rel="stylesheet">

	@yield('css')

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
                    <a href="https://haaretecnologia.com.br.com.br" target='_blank' title="Haare Tecnologia">Haare Tecnologia</a>. Todos os direitos reservados.</span>
            </footer>
        </div>
    </div>

    <script src="{{ mix('/js/app.js') }}"></script>
    <script src="{{ asset('/js/compartilhado/jquery.min.js') }}"></script>
    <script src="{{ asset('/js/compartilhado/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('/js/compartilhado/moment.min.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/vida/index.js') !!}"></script>

    @yield('js')

</body>

</html>
