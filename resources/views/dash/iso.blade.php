@extends('dashboard')

@section('title', 'ISO')

@section('content')

<div id="isos">

<div class="page-header">
  <h1 class="page-title">
    ISO
  </h1>
</div>

<div class="row">
  <div class="col-lg-3 order-lg-1 mb-4">

    <a href="{{ url('iso/add') }}" class="btn btn-block btn-primary @if( !auth()->user()->can('manage iso') ) btn-secondary disabled @endif mb-6">
            Add ISO
  </a>

   @include( 'partials.nav', [ 'currentRouteName' => Route::currentRouteName()])

  </div>
  <div class="col-lg-9">
    <div class="card">
      <div class="card-body">

    @if( !auth()->user()->can('manage iso') )

      <div class="card-alert alert alert-warning mb-0">
          <i class="fe fe-lock" title="fe fe-lock"></i> <strong>Forbidden!</strong> You don't have permission to manage ISO.
        </div>

    @endif

    @can('manage iso')

  <div class="page-header">

    <div class="page-subtitle total-isos">{{ count($isos) <= 1 ? count($isos).' '.str_singular('ISO') : count($isos).' ISOs' }}</div>

          <div class="page-options d-flex">

          <div class="input-icon ml-2">

                  <span class="input-icon-addon">
                    <i class="fe fe-search"></i>
                  </span>

                  <input class="search form-control w-10" placeholder="Search ISOs ..." type="text">
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
                <th class="text-center">Status</th>
                <th>MD5</th>
                <th class="text-center">Size</th>
                <th class="text-center">Uploaded</th>
              </tr>
          </thead>
          <tbody class="list">

            @forelse ( $isos as $iso )

              <tr>
                <td class="name">{{ $iso['filename'] }}</td>
                <td class="status{{ strtolower( $iso['status'] ) == 'complete' ? ' active' : ' orange'}}">{{ ucfirst($iso['status']) }}</td>
                <td class="md5">{{ $iso['md5sum'] }}</td>
                <td class="size">{{ formatBytes($iso['size']) }}</td>
                <td class="date_created">{{ \Carbon\Carbon::parse($iso['date_created'])->diffForHumans() }}</td>
              </tr>

            @empty
            
                <div class="alert alert-info">No ISO's</div>

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

    searchTable('isos', true, 10, [ 'name' , 'status', 'size', 'date_created' ], '.total-isos', 'ISO', 'ISOs');

    //function searchTable( id ,pagination = true, page = 10 , values = [], countid, singularCount, pluralCount ){

  });

});

</script>


@endsection