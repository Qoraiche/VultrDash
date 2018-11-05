@extends('dashboard')

@section('title', 'Snapshots')

@section('content')

<div id="snapshots">

<div class="page-header">
  <h1 class="page-title">
    Snapshots
  </h1>
</div>

<div class="row">
<div class="col-lg-3 order-lg-1 mb-4">

  <a href="{{ url('snapshots/add') }}" class="btn btn-block btn-primary @if( !auth()->user()->can('manage snapshots') ) btn-secondary disabled @endif mb-6">
            Add Snapshot
  </a>

 @include( 'partials.nav', [ 'currentRouteName' => Route::currentRouteName()])

</div>
<div class="col-lg-9">
  <div class="card">
  <div class="card-body">

    @if( !auth()->user()->can('manage snapshots') )

      <div class="card-alert alert alert-warning mb-0">
          <i class="fe fe-lock" title="fe fe-lock"></i> <strong>Forbidden!</strong> You don't have permission to manage snapshots.
        </div>

    @endif


  @can('manage snapshots')

  <div class="page-header">

    <div class="page-subtitle total-snapshots">{{ count($snapshots) <= 1 ? count($snapshots).' '.str_singular('snapshots') : count($snapshots).' snapshots' }}</div>

          <div class="page-options d-flex">

          <div class="input-icon ml-2">

                  <span class="input-icon-addon">
                    <i class="fe fe-search"></i>
                  </span>

                  <input class="search form-control w-10" placeholder="Search Snapshots ..." type="text">
          </div>

          </div>

    </div>

    @if ( Session::has('message') )

            <div class="alert alert-info">{!! session( 'message' ) !!}</div>

      @endif

      @if ( Session::has('error') )

            <div class="alert alert-warning">{!! session( 'error' ) !!}</div>

      @endif

       <div class="table-responsive">

        <table class="table table-hover table-outline table-vcenter text-nowrap card-table">

          <thead>
            <tr>
              <th>Snapshot</th>
              <th>Size</th>
              <th>Date</th>
              <th>Os</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>

          <tbody class="list">

            @forelse ( $snapshots as $snapshot)

              <tr>

              <td class="server"><span class="firstline">{{ isset($snapshot['SNAPSHOTID']) ? $snapshot['SNAPSHOTID'] : '--' }}</span>
                <div class="small text-muted">
                    {!! $snapshot['description'] === '' ? '--' : $snapshot['description'] !!}
                </div>
              </td>
              
              <td class="size">
                {{ formatBytes($snapshot['size']) }}
              </td>

              <td class="date">

                {{ \Carbon\Carbon::parse($snapshot['date_created'])->diffForHumans() }} 

              </td>

              <td class="os">
                {{  $os->getOsByKeyId( $snapshot['OSID']) == 'application' ? ucfirst( $app->getAppByKeyId( $snapshot['APPID']) ) : ucfirst($os->getOsByKeyId( $snapshot['OSID'])) }}
              </td>

              <td><span class="status-icon bg-{{ strtolower($snapshot['status']) == 'complete' ? 'success' : 'warning' }}"></span> {{ ucfirst($snapshot['status']) }}
             </td>

                <td>

          <form action="{{ route('snapshots.destroy') }}" method="POST" name="destroysnapshot-{{ $snapshot['SNAPSHOTID'] }}" accept-charset="utf-8">
                @method('DELETE')
                @csrf
            <input type="hidden" name="snapshotid" value="{{ $snapshot['SNAPSHOTID'] }}">
              <a class="icon removesnapshot" snapshotid="{{ $snapshot['SNAPSHOTID'] }}" class="icon" href="#{{ $snapshot['SNAPSHOTID'] }}" {{--onclick="document.forms['destroysnapshot-{{ $snapshot['SNAPSHOTID'] }}'].submit();" --}}>
                <i class="fe fe-trash"></i>
              </a>
          </form>

                </td>

              </tr>

            @empty

                <div class="alert alert-info">No snapshots</div>

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

    searchTable('snapshots', true, 10, ['server' , 'os', 'status', 'size', 'date'], '.total-snapshots', 'snapshot', 'snapshots');

  });

});

</script>


@endsection