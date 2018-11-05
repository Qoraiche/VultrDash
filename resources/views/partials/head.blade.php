<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="robots" content="noindex">
  <title>Vultrdash
    @if(View::hasSection('title'))
        - @yield('title')
    @else - Dashboard @endif
</title>

  <link rel="shortcut icon" href="{{ asset('vultrdash_icon.ico') }}" />
  <link rel="icon" type="image/png" href="{{ asset('vultrdash_icon.png') }}">
  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css'>
  <link rel='stylesheet prefetch' href='{{ asset('css/dashboard.css') }}'>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

  <script src="{{ asset('js/require.min.js') }}"></script>

  <script>
      requirejs.config({
          baseUrl: '..'
      });
  </script>

  <script src="{{ asset('js/dashboard.js') }}"></script>

  <!-- list -->
  <script src="{{ asset('js/vendors/list.min.js') }}"></script>

  <!-- c3.js Charts Plugin -->
  <link href="{{ asset('plugins/charts-c3/plugin.css') }}" rel="stylesheet" />
  <script src="{{ asset('plugins/charts-c3/plugin.js') }}"></script>

  <!-- Input Mask Plugin -->
  <script src="{{ asset('plugins/input-mask/plugin.js') }}"></script>

</head>

<body>