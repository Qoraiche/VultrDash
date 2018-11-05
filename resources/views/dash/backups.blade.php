@extends('dashboard')

@section('title', 'Backups')

@section('content')

<div id="backups">

<div class="page-header">
  <h1 class="page-title">
    Backups
  </h1>
</div>

<div class="row">
        <div class="col-lg-3 order-lg-1 mb-4">

         @include( 'partials.nav', [ 'currentRouteName' => Route::currentRouteName()])

        </div>
    <div class="col-lg-9">
      <div class="card">
        <div class="card-body">

        @if( !auth()->user()->can('manage backups') )

          <div class="card-alert alert alert-warning mb-0">
              <i class="fe fe-lock" title="fe fe-lock"></i> <strong>Forbidden!</strong> You don't have permission to manage Backups.
            </div>

        @endif

        @can('manage backups')

         <div class="page-header">

         <div class="page-subtitle total-backups">{{ count($backuplist) <= 1 ? count($backuplist).' '.str_singular('backup') : count($backuplist).' backups' }}</div>

        <div class="page-options d-flex">

        <div class="input-icon ml-2">

              <span class="input-icon-addon">
                <i class="fe fe-search"></i>
              </span>

              <input class="search form-control w-10" placeholder="Search Backups ..." type="text">
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
              <th>Description</th>
              <th>Size</th>
              <th>Date</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody class="list">

            @forelse ( $backuplist as $backup )

            <tr>
                <td class="server">{{ $backup['BACKUPID'] }}</td>
                <td class="description">{{ $backup['description'] }}</td>
                <td class="size">{{ formatBytes($backup['size']) }}</td>
                <td class="date">{{ \Carbon\Carbon::parse($backup['date_created'])->diffForHumans() }}</td>
                <td class="active" id="status">{{ $backup['status'] }}</td>
            </tr>

            @empty

                <div class="alert alert-info">{{ __('No Backups') }}</div>

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

    searchTable('backups', true, 10, [ 'server', 'description' ], '.total-backups', 'backup', 'backups');

    //function searchTable( id ,pagination = true, page = 10 , values = [], countid, singularCount, pluralCount ){

  });

});

</script>


@endsection