@extends('dashboard')

@section('title', 'Startup Scripts')

@section('content')

<div id="startups">

<div class="page-header">
  <h1 class="page-title">
    Startup Scripts
  </h1>
</div>

  <div class="row">
  <div class="col-lg-3 order-lg-1 mb-4">

  <a href="{{ url('startup/add') }}" class="btn btn-block btn-primary @if( !auth()->user()->can('manage startupscripts') ) btn-secondary disabled @endif mb-6">
            Add Startup Script
  </a>





      @include( 'partials.nav', [ 'currentRouteName' => Route::currentRouteName()])

      </div>
      <div class="col-lg-9">
        <div class="card">
          <div class="card-body">

        @if( !auth()->user()->can('manage startupscripts') )

          {{-- <div class="card-alert alert alert-warning mb-0">
              <i class="fe fe-lock" title="fe fe-lock"></i> <strong>Forbidden!</strong> You don't have permission to manage startup scripts.
            </div> --}}

        @alert([ 'type' => 'warning', 'card', 'classes' => 'mb-0'])
          You don't have permission to manage startup scripts.
        @endalert

         @endif

      @can('manage startupscripts')

      <div class="page-header">

        <div class="page-subtitle total-scripts">{{ count($scripts) <= 1 ? count($scripts).' '.str_singular('startup script') : count($scripts).' startup scripts' }}</div>

              <div class="page-options d-flex">

              <div class="input-icon ml-2">

                      <span class="input-icon-addon">
                        <i class="fe fe-search"></i>
                      </span>

                      <input class="search form-control w-10" placeholder="Search Startup Scripts ..." type="text">
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
              <th>Name</th>
              <th>Type</th>
              <th>Last Modified</th>
              <th></th>
            </tr>
          </thead>
          <tbody class="list">

            @forelse ( $scripts as $script )

            <tr>
              <td class="name">{{ $script['name'] }}</td>
              <td class="type">{{ $script['type'] }}</td>
              <td class="last-modified">{{ \Carbon\Carbon::parse($script['date_modified'])->diffForHumans() }}</td>
              <td>
                <form action="{{ route('startup.destroy') }}" method="POST" name="destroyscript-{{ $script['SCRIPTID'] }}" accept-charset="utf-8">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="scriptid" value="{{ $script['SCRIPTID'] }}">

                    <a data-container="body" class="icon removescript" scriptid="{{ $script['SCRIPTID'] }}" scriptname="{{ $script['name'] }}" class="icon" href="#{{$script['SCRIPTID'] }}" {{--onclick="document.forms['destroysnapshot-{{ $snapshot['SNAPSHOTID'] }}'].submit();" --}}>
                <i class="fe fe-trash"></i>

              </a>

                </form>
              </td>
            </tr>

            @empty

                {{-- <div class="alert alert-info">{{ __('No Startup Scripts') }}</div> --}}

                @alert([ 'type' => 'info'])
                  No Startup Scripts
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

require([ 'core' ], function () {

  $(document).ready(function () {

    searchTable('startups', true, 10, [ 'name' , 'type', 'last-modified' ], '.total-scripts', 'startup script', 'startup scripts');

    //function searchTable( id ,pagination = true, page = 10 , values = [], countid, singularCount, pluralCount ){

  });

});

</script>

@endsection