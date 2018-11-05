@extends('modals.view-server')

@section('title', 'Manage Server - Snapshots')

@section('server-view-tab')

<div class="page-header">
  <div class="page-options d-flex">

  <form class="d-flex" action="{{ route('snapshots.create') }}" method="POST" accept-charset="utf-8">
    @csrf

    <input type="hidden" name="subid" value="{{ $serverInfo->SUBID }}">
    <input type="hidden" name="page" value="setting">

    	<div class="input-icon">
        <input class="form-control w-10" name="snapshot_label" placeholder="Label" type="text">
      </div>

      <button type="submit" class="btn btn-primary ml-2" onclick="$(this).addClass('btn-loading');">Take Snapshot</button>

  </form>
    
  </div>
</div>

<div class="table-responsive instances-table">

  @if ( Session::has('message') )

            <div class="alert alert-info">{!! session( 'message' ) !!}</div>

      @endif

      @if ( Session::has('error') )

            <div class="alert alert-warning">{!! session( 'error' ) !!}</div>

      @endif

        <table class="table table-hover table-borderless">
          <thead>
            <tr>
              <th id="server">Server</th>
              <th id="size">Size</th>
              <th id="date">Date</th>
              <th id="os">Os</th>
              <th id="status">Status</th>
              <th id="action"></th>
            </tr>
          </thead>
          <tbody>

            @forelse ($snapshots as $snapshot)
                
              <tr>
                  <td class="server"><span class="firstline">
                    {{ isset($snapshot['SNAPSHOTID']) ? $snapshot['SNAPSHOTID'] : '--' }}</span><span class="secondline">{!! $snapshot['description'] === '' ? '--' : $snapshot['description'] !!}</span>
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

                    <td class="status {{ $snapshot['status'] == 'complete' ? 'active' : 'orange' }}">
                    {{ ucfirst($snapshot['status']) }}
                  </td>
                  <td>

                      <form class="d-inline" style="margin-right: 15px;" action="{{ route('snapshots.destroy') }}" method="POST" accept-charset="utf-8">
                            @method('DELETE')
                            @csrf
                            
                            <input type="hidden" name="snapshotid" value="{{ $snapshot['SNAPSHOTID'] }}">
                          <a class="icon removesnapshot" snapshotid="{{ $snapshot['SNAPSHOTID'] }}" class="icon" href="#{{ $snapshot['SNAPSHOTID'] }}" data-toggle="tooltip" data-placement="top" title="Delete Snapshot" {{--onclick="document.forms['destroysnapshot-{{ $snapshot['SNAPSHOTID'] }}'].submit();" --}}>
                            <i class="fe fe-trash"></i>
                          </a>
                      </form>

                        <form class="d-inline" action="{{ route('servers.restoresnapshot') }}" method="POST" accept-charset="utf-8">
                            @csrf

                            <input type="hidden" name="serverid" value="{{ $serverInfo->SUBID }}">
                            <input type="hidden" name="snapshotid" value="{{ $snapshot['SNAPSHOTID'] }}">
                          <a class="icon restoresnapshot" snapshotid="{{ $snapshot['SNAPSHOTID'] }}" class="icon" href="#{{ $snapshot['SNAPSHOTID'] }}" data-toggle="tooltip" data-placement="top" title="Restore Snapshot" {{--onclick="document.forms['destroysnapshot-{{ $snapshot['SNAPSHOTID'] }}'].submit();" --}}>
                            <i class="fe fe-refresh-cw"></i>
                          </a>
                      </form>

                    </td>
                  </tr>

            @empty
                
                <div class="alert alert-info">No Snapshots to restore</div>

            @endforelse
            
              
          </tbody>
        </table>

      </div>

@endsection