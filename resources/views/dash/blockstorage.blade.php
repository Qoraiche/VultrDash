@extends('dashboard')

@section('title', 'Block Storage')

@section('content')

<div id="blockstorage">


<div class="page-header">
  <h1 class="page-title">
    Block storage
  </h1>
</div>

      <div class="row">
              <div class="col-lg-3 order-lg-1 mb-4">

                <a href="{{ url('blockstorage/add') }}" class="btn btn-block btn-primary @if( !auth()->user()->can('manage blockstorage') ) btn-secondary disabled @endif mb-6">
                  Add Block Storage
                  </a>

               @include( 'partials.nav', [ 'currentRouteName' => Route::currentRouteName()])

              </div>
              <div class="col-lg-9">
                <div class="card">
                  <div class="card-body">

                    @if( !auth()->user()->can('manage blockstorage') )

          {{-- <div class="card-alert alert alert-warning mb-0">
              <i class="fe fe-lock" title="fe fe-lock"></i> <strong>Forbidden!</strong> You don't have permission to manage Blockstorage.
            </div> --}}

            @alert([ 'type' => 'warning', 'card', 'classes' => 'mb-0'])
                You don't have permission to manage Blockstorage.
              @endalert

        @endif

                    @can('manage blockstorage')

                <div class="page-header">

                 <div class="page-subtitle total-blockstorage">{{ count($storages).' block storage' }}</div>

                <div class="page-options d-flex">

                <div class="input-icon ml-2">

                      <span class="input-icon-addon">
                        <i class="fe fe-search"></i>
                      </span>

                      <input class="search form-control w-10" placeholder="Search Block Storage ..." type="text">
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
              <th>Description</th>
              <th>Location</th>
              <th>Attached To</th>
              <th>Cost per month</th>
              <th class="text-center">Status</th>
            </tr>
          </thead>
          <tbody class="list">

            @forelse ( $storages as $storage )

          <tr>
              <td class="description"><span class="firstline">{{ ucfirst($storage['label']) }}</span><span class="secondline">{{ $storage['size_gb'] }} GB</span></td>
              <td class="location">{{ $regions[$storage['DCID']]['country'] }} - {{ $regions[$storage['DCID']]['name'] }}</td>
              <td class="attached-to">{{ ( $storage['attached_to_SUBID'] ) === NULL ? '--' : $storage['attached_to_SUBID'] }}</td>
              <td class="charges"><i class="fe fe-dollar-sign"></i>{{ $storage['cost_per_month'] }}</td>

             <td><span class="status-icon bg-{{ strtolower($storage['status']) == 'active' ? 'success' : 'warning' }}"></span> {{ ucfirst($storage['status']) }}
             </td>

              <td>
                  <form action="{{ route('blockstorage.delete') }}" method="POST" name="deletestorage-{{ $storage['SUBID'] }}" accept-charset="utf-8">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="subid" value="{{ $storage['SUBID'] }}">
                    <a class="icon removestorage" storageid="{{ $storage['SUBID'] }}" class="icon" href="#{{ $storage['SUBID'] }}" {{--onclick="document.forms['destroysnapshot-{{ $snapshot['SNAPSHOTID'] }}'].submit();" --}}>
                      <i class="fe fe-trash"></i>
                    </a>
                  </form>
                </td>
          </tr>

          @empty

                {{-- <div class="alert alert-info">{{ __('No Block Storage') }}</div> --}}

                @alert(['type' => 'info'])
                  No Block Storage
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

          searchTable('blockstorage', true, 10, [ 'location', 'description', 'charges', 'attached-to' ], '.total-blockstorage', 'block storage', 'block storage');

        $('.removestorage').popover(
            {
              html: true,
              trigger: 'click',
              content: '<div class="card-body vultr-notify">\
                  <h5>Delete Block Storage?</h5>\
                  <p class="vu-notify-msg">Are you sure you want to delete this volume? All data will be destroyed (this action cannot be undone).</p>\
                </div>\
                <div class="card-footer">\
                  <button type="button" id="confirmbtn" class="btn btn-primary btn-block">Delete Block Storage</button>\
                  <button type="button" id="canecelbtn" class="btn btn-secondary btn-block">Cancel</button>\
                </div>',
          }
        );

        $('.removestorage').on('shown.bs.popover', function () {

            var that = this;

            $('#confirmbtn').click(function(){

                $(this).addClass('btn-loading');

                document.forms['deletestorage-' + $(that).attr('storageid') + ''].submit();

            });

            $('#canecelbtn').click(function(){
                $('.removestorage').popover('hide');
            });

          });

          });
        
        });

      </script>

@endsection