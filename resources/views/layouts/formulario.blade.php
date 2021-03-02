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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <style>
    body {font-family: Arial;}

    /* Style the tab */
    .tab {
      overflow: hidden;
      border: 1px solid #8fb5cc;
      background-color: #f0f0f1;
    }

    /* Style the buttons inside the tab */
    .tab button {
      background-color: inherit;
      float: left;
      border: none;
      outline: none;
      cursor: pointer;
      padding: 14px 16px;
      transition: 0.3s;
      font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
      background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
      background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
      display: none;
      padding: 6px 12px;
      border: 1px solid #ccc;
      border-top: none;
    }
  </style>
</head>
<body class="app">


    <div class="row centered">
      @include('vida.partials.spinner')
      @include('vida.partials.sidebar')

      @include('vida.partials.topbar')
      <div class="col-md-3"></div>

      <div class="col-md-6 peer pX-40 pY-80 h-100 bgc-white scrollable pos-r" style='min-width: 320px;'>
        @include('vida.partials.messages')
        @yield('content')
      </div>

    </div>
    <footer class="bdT ta-c p-30 lh-0 fsz-sm c-grey-600">
                <span>Copyright © 2018 IntegrallMed. Desenvolvido por
                    <a href="https://litotech.com.br" target='_blank' title="Litotech">Litotech</a>. Todos os direitos reservados.</span>
    </footer>
    @stack('scripts')
</body>
</html>
