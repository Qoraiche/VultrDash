@include('partials.head')

<div class="page">
  <div class="page-content">
    <div class="container text-center">
      <div class="display-1 text-muted mb-5"><i class="fe fe-alert-circle"></i></div>
      <h1 class="h2 mb-4">Unable to Connect to Vultr API</h1>
  <p class="h4 text-muted font-weight-normal mb-2">The pae will load in <span class="remaining-sec">8</span> seconds…</p>

      @if ( !empty($error) )

        <span class="d-block mb-4">
            <small><strong>Error: </strong>{{ $error }}</small>
        </span>

      @endif

      <a class="btn btn-primary" id="tryagain" href="{{ url('/refresh') }}" onclick="$(this).addClass('btn-loading');">
        <i class="fe fe-arrow-left mr-2"></i>Try Again Now
      </a>
      
    </div>
  </div>
</div>

<script type="text/javascript">

  require([ 'core' ], function () {

  $(document).ready(function () {

    jQuery(function ($) {

        var seconds = 8,
            display = $('.remaining-sec');

        startCountdown(seconds, display);

    });

       setTimeout(function() {

           window.location = '{{ url('/refresh') }}';

       }, 8000);

  });

});


</script>