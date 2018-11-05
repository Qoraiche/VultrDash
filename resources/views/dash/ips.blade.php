@extends('dashboard')

@section('title', 'Reserved IPs')

@section('content')

<div id="ips">

<div class="page-header">
  <h1 class="page-title">
    Reserved IPs
  </h1>
</div>

      <div class="row">
              <div class="col-lg-3 order-lg-1 mb-4">

{{--                 <a href="https://github.com/tabler/tabler" class="btn btn-block btn-primary mb-6">
                  New DNS
                </a> --}}

               @include( 'partials.nav', [ 'currentRouteName' => Route::currentRouteName()])

              </div>
              <div class="col-lg-9">
                <div class="card">
                  <div class="card-body">

          @if( !auth()->user()->can('manage ips') )

          <div class="card-alert alert alert-warning mb-0">
              <i class="fe fe-lock" title="fe fe-lock"></i> <strong>Forbidden!</strong> You don't have permission to manage reserved ips.
          </div>

          @endif

          @can('manage ips')

          <div class="page-header">

              <div class="page-subtitle total-ips">{{ count($ips) <= 1 ? count($ips).' '.str_singular('IPs') : count($ips).' IPs' }}</div>

              <div class="page-options d-flex">

              <div class="input-icon ml-2">

              <span class="input-icon-addon">
              <i class="fe fe-search"></i>
              </span>

              <input class="search form-control w-10" placeholder="Search Ips ..." type="text">
              </div>

              </div>

        </div>

        @if (Session::has('message'))

            <div class="alert alert-info">{!! session('message') !!}</div>

        @endif
      
      <div class="table-responsive">
        <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
          <thead>
            <tr>
              <th>Reserved IP</th>
              <th>Location</th>
              <th>Attached To</th>
              <th>IP Type</th>
            </tr>
          </thead>
          <tbody class="list">

          @forelse ( $ips as $reserverIp )

            <tr>

              <td class="ip">{{ $reserverIp['subnet'] }}</td>
              <td class="location">{{ $DCID['date_created'] }}</td>
              <td class="attached_SUBID">{{ $reserverIp['date_created'] }}</td>
              <td class="iptype">{{ $reserverIp['ip_type'] }}</td>
                
            </tr>

          @empty

                <div class="alert alert-info">{{ __('No reserved IPs') }}</div>

            @endforelse

        </tbody>
    </table>
</div>

<ul class="pagination"></ul>

</div>

@endcan

</div>


</div>

</div>

</div>


<script type="text/javascript">

      require(['core'], function () {

        $(document).ready(function () {

        searchTable('ips', true, 10, [ 'ip', 'location', 'attached_SUBID', 'iptype' ], '.total-ips', 'IP', 'IPs');

        });

      });


</script>

@endsection