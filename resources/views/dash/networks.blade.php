@extends('dashboard')

@section('title', 'Networks')

@section('content')

<div id="networks">

<div class="page-header">
  <h1 class="page-title">
    Networks
  </h1>
</div>

      <div class="row">
              <div class="col-lg-3 order-lg-1 mb-4">

                <a href="{{ url('networks/add') }}" class="btn btn-block btn-primary @if( !auth()->user()->can('manage networks') ) btn-secondary disabled @endif mb-6">
                  New Private Network
                </a>

               @include( 'partials.nav', [ 'currentRouteName' => Route::currentRouteName()])

              </div>
              <div class="col-lg-9">
                <div class="card">
                  <div class="card-body">

        @if( !auth()->user()->can('manage networks') )

          <div class="card-alert alert alert-warning mb-0">
              <i class="fe fe-lock" title="fe fe-lock"></i> <strong>Forbidden!</strong> You don't have permission to manage Networks.
          </div>

        @endif

          @can('manage networks')

          <div class="page-header">

              <div class="page-subtitle total-networks">{{ count($networks) <= 1 ? count($networks).' '.str_singular('networks') : count($networks).' networks' }}</div>

              <div class="page-options d-flex">

              <div class="input-icon ml-2">

              <span class="input-icon-addon">
              <i class="fe fe-search"></i>
              </span>

              <input class="search form-control w-10" placeholder="Search Networks ..." type="text">
              </div>

              </div>

        </div>

        @if (Session::has('message'))

          <div class="alert alert-info">{!! session('message') !!}</div>

        @endif
      
      <div class="table-responsive instances-table networks-table">

        <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Description</th>
              <th>Location</th>
              <th>Subnet</th>
            </tr>
          </thead>
          <tbody class="list">

            @forelse ( $networks as $network )

            <tr>
              <td class="id">{{ $network['NETWORKID'] }}</td>
              <td class="description">{{ $network['description'] }}</td>
              <td class="location"><img src="{{ asset('images/flags/'.$regions[$network['DCID']]['country'].'.svg') }}" class="rounded w-5 mr-2"> {{ $regions[$network['DCID']]['name'] }}</td>
              <td class="subnet">{{ $network['v4_subnet'] }}</td>

              <td>
                  <form action="{{ route('networks.destroy') }}" method="POST" name="destroynetwork-{{ $network['NETWORKID'] }}" accept-charset="utf-8">
                    
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="networkid" value="{{ $network['NETWORKID'] }}">
                    <a class="icon destroynetwork" networkid="{{ $network['NETWORKID'] }}" class="icon" href="#{{ $network['NETWORKID'] }}" {{--onclick="document.forms['destroysnapshot-{{ $snapshot['SNAPSHOTID'] }}'].submit();" --}}>
                      <i class="fe fe-trash"></i>
                    </a>

                  </form>
              </td>

            </tr>

            @empty
            
              <div class="alert alert-info">No Networks</div>

            @endforelse

        </tbody>
    </table>
</div>

<ul class="pagination"></ul>

@endcan

</div>

</div>

</div>

</div>

</div>

<script type="text/javascript">

      require(['core'], function () {

        $(document).ready(function () {

          searchTable('networks', true, 10, [ 'description', 'rules', 'instances' ], '.total-networks', 'network', 'networks');

        $('.destroynetwork').popover(
            {
              html: true,
              trigger: 'click',
              content: '<div class="card-body vultr-notify">\
                  <h5>Delete Network?</h5>\
                  <p class="vu-notify-msg">Are you sure you want to delete this network? This action cannot be undone.</p>\
                </div>\
                <div class="card-footer">\
                  <button type="button" id="confirmbtn" class="btn btn-primary btn-block">Delete Network</button>\
                  <button type="button" id="canecelbtn" class="btn btn-secondary btn-block">Cancel</button>\
                </div>',
          }
        );

        $('.destroynetwork').on('shown.bs.popover', function () {

            var that = this;

            $('#confirmbtn').click(function(){

                $(this).addClass('btn-loading');

                document.forms['destroynetwork-' + $(that).attr('networkid') + ''].submit();

            });

            $('#canecelbtn').click(function(){
                $('.destroynetwork').popover('hide');
            });

          });

          });
        });

      </script>


@endsection