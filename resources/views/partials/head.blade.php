<!DOCTYPE html>
<html lang="en" >

<head>

  <meta charset="UTF-8">
  <meta name="robots" content="noindex">
  <title>VultrOn
    @if(View::hasSection('title'))
        - @yield('title')
    @else
        - Dashboard
    @endif
</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

  <link rel="shortcut icon" href="{{ asset('vultron-icon.png') }}" />
  
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

{{--   <!-- Google Maps Plugin -->
  <link href="{{ asset('plugins/maps-google/plugin.css') }}" rel="stylesheet" />
  <script src="{{ asset('plugins/maps-google/plugin.js') }}"></script> --}}

  <!-- Input Mask Plugin -->
  <script src="{{ asset('plugins/input-mask/plugin.js') }}"></script>

</head>

<body>