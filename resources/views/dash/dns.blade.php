@extends('dashboard')

@section('title', 'DNS')

@section('content')

<div id="dns-entries">

<div class="page-header">
  <h1 class="page-title">
    DNS
  </h1>
</div>

      <div class="row">
              <div class="col-lg-3 order-lg-1 mb-4">

                <a href="{{ url('dns/add') }}" class="btn btn-block btn-primary @if( !auth()->user()->can('manage dns') ) btn-secondary disabled @endif mb-6">
                  Add Domain
                  </a>

               @include( 'partials.nav', [ 'currentRouteName' => Route::currentRouteName()])

              </div>
              <div class="col-lg-9">
                <div class="card">
                  <div class="card-body">

          @if( !auth()->user()->can('manage dns') )

            {{-- <div class="card-alert alert alert-warning mb-0">
                <i class="fe fe-lock" title="fe fe-lock"></i> <strong>Forbidden!</strong> You don't have permission to manage DNS.
              </div> --}}

              @alert([ 'type' => 'warning', 'card', 'classes' => 'mb-0'])
                You don't have permission to manage DNS.
              @endalert

          @endif


        @can('manage dns')

        <div class="page-header">

        <div class="page-subtitle total-dns">{{ count($dnslist) .' DNS' }}</div>

              <div class="page-options d-flex">

              <div class="input-icon ml-2">

                      <span class="input-icon-addon">
                        <i class="fe fe-search"></i>
                      </span>

                      <input class="search form-control w-10" placeholder="Search DNS entries ..." type="text">
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
              <th>Domain</th>
              <th>OS</th>
            </tr>
          </thead>
          <tbody class="list">

            @forelse ( $dnslist as $dns )

            <tr>

            <td class="domain">{{ $dns['domain'] }}</td>
            <td class="date-created">{{ $dns['date_created'] }}</td>

            <td>
                <form action="{{ route('dns.delete') }}" method="POST" name="deletedns-{{ $dns['domain'] }}" accept-charset="utf-8">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="domain" value="{{ $dns['domain'] }}">
                    <a class="icon deletedns" domain="{{ $dns['domain'] }}" class="icon" href="#{{ $dns['domain'] }}" {{--onclick="document.forms['destroysnapshot-{{ $snapshot['SNAPSHOTID'] }}'].submit();" --}}>
                      <i class="fe fe-trash"></i>
                    </a>
                </form>
            </td>

            </tr>

          @empty

                {{-- <div class="alert alert-info">{{ __('No DNS entries') }}</div> --}}

                @alert(['type' => 'info'])
                  No DNS entries
                @endalert
                
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

          searchTable('dns-entries', true, 10, [ 'name', 'date-created' ], '.total-dns', 'DNS', 'DNS');

        $('.deletedns').popover(
            {
              html: true,
              trigger: 'click',
              content: '<div class="card-body vultr-notify">\
                  <h5>Delete Domain?</h5>\
                  <p class="vu-notify-msg">This will permanently delete the domain and all associated records. Are you sure you want to do this?</p>\
                </div>\
                <div class="card-footer">\
                  <button type="button" id="confirmbtn" class="btn btn-primary btn-block">Delete Domain</button>\
                  <button type="button" id="canecelbtn" class="btn btn-secondary btn-block">Cancel</button>\
                </div>',
          }
        );

        $('.deletedns').on('shown.bs.popover', function () {

            var that = this;

            $('#confirmbtn').click(function(){

                $(this).addClass('btn-loading');

                document.forms['deletedns-' + $(that).attr('domain') + ''].submit();

            });

            $('#canecelbtn').click(function(){

                $('.deletedns').popover('hide');

            });

          });

          });
        });

      </script>

@endsection