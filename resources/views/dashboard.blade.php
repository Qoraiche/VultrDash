@include('partials.head')

<div class="page">
      
  <div class="page-main">

  @include('partials.dash-header')

        @include('partials.dash-topmenu')

<div id="vultr-wp-dashboard">


  <div class="vultr-wp-container container full-width no-pad">
    
    @yield('content')

  </div>

</div>

</div>

</div>

@include('partials.footer')