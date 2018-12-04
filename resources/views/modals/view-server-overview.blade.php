@extends('modals.view-server')

@section('server-view-tab')

  <div class="card">
    <div class="card-body">

<div class="row">

<div class="col-sm-6 col-lg-3">
    <div class="card p-3">
      <div class="d-flex align-items-center">
        <span class="stamp stamp-md bg-blue mr-3">
          <i class="fe fe-dollar-sign"></i>
        </span>

        <div>
          <h4 class="m-0"><span>${{ $serverInfo->pending_charges }} <small>/${{ $serverInfo->cost_per_month }}</small></span></h4>
          <small class="text-muted">Current charges</small>
        </div>

      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="card p-3">
      <div class="d-flex align-items-center">
        <span class="stamp stamp-md bg-green mr-3">
          <i class="fe fe-heart"></i>
        </span>
        <div>
          <h4 class="m-0">
            <span class="{{ strtolower($serverInfo->status) == 'active' ? 'active' : 'pending orange' }}">{{ucfirst($serverInfo->status) }}</span>
          </h4>
          <small class="text-muted">Status</small>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="card p-3">
      <div class="d-flex align-items-center">
        <span class="stamp stamp-md bg-red mr-3">
          <i class="fe fe-hard-drive"></i>
        </span>
        <div>
          <h4 class="m-0"><span>{{ $serverInfo->disk }}</span></h4>
          <small class="text-muted">Disk</small>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="card p-3">
      <div class="d-flex align-items-center">
        <span class="stamp stamp-md bg-yellow mr-3">
          <i class="fe fe-monitor"></i>
        </span>
        <div>
          <h4 class="m-0"><span>

            @if( $os->getOsByKeyId( $serverInfo->OSID, 'family' ) == 'application')

                {{ ucfirst( $app->getAppByKeyId( $serverInfo->APPID ) ) }}

            @else
                {{ ucfirst( $serverInfo->os ) }}
            @endif

          </span></h4>
          <small class="text-muted">

            @if( $os->getOsByKeyId( $serverInfo->OSID, 'family' ) == 'application' )
                Application

            @elseif( $os->getOsByKeyId( $serverInfo->OSID, 'family' ) == 'backup' )
                Backup

            @elseif( $os->getOsByKeyId( $serverInfo->OSID, 'family' ) == 'snapshot' )
                Snapshot

            @else
                Operating System
            @endif

          </small>
        </div>
      </div>
    </div>
  </div>

<div class="col-md-12 col-xl-6">
<div class="card">
<div class="card-header">
  <h3 class="card-title">{{ __('Bandwidth usage') }}</h3>
  <div class="card-options">
    <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
    <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
  </div>
</div>

<div class="m-5">

<div class="clearfix">
  <div class="float-left">
    <strong>{{ round(getPercent( $serverInfo->current_bandwidth_gb, $serverInfo->allowed_bandwidth_gb ), 2) }}%</strong>
  </div>
  <div class="float-right">
    <small class="text-muted">{{ round($serverInfo->current_bandwidth_gb) }} GB - {{ $serverInfo->allowed_bandwidth_gb }} GB</small>
  </div>
</div>

<div class="progress progress-xs">
  <div class="progress-bar bg-{{ $serverInfo->current_bandwidth_gb < 500 ? 'green' : 'yellow' }}" role="progressbar" style="width: {{ round(getPercent($serverInfo->current_bandwidth_gb, $serverInfo->allowed_bandwidth_gb)) }}%" aria-valuenow="{{ round(getPercent($serverInfo->current_bandwidth_gb, $serverInfo->allowed_bandwidth_gb)) }}" aria-valuemin="0" aria-valuemax="100">
  </div>
</div>

<small class="text-muted">Current bandwidth usage</small>

</div>

  <div id="bandwidth-chart" style="height: 14rem"></div>

</div>

<script>
require(['c3', 'jquery'], function(c3, $) {
  $(document).ready(function(){

    var chart = c3.generate({

      bindto: '#bandwidth-chart', // id of chart wrapper
      data: {
        columns: [
            // each columns data
        ['incoming_bytes', @foreach(array_slice($bandwidth->incoming_bytes, -10) as $data => $value) {{ formatBytes($value[1], false, 2).',' }} @endforeach],

        ['outgoing_bytes',@foreach(array_slice($bandwidth->outgoing_bytes, -10) as $data => $value) {{ formatBytes($value[1], false, 2).',' }} @endforeach]

        ],
        type: 'bar', // default type of chart
        colors: {
          'incoming_bytes': tabler.colors["blue"],
          'outgoing_bytes': tabler.colors["pink"]
        },
        names: {
            // name of each serie
          'incoming_bytes': 'Incoming Bytes (MB)',
          'outgoing_bytes': 'Outgoing Bytes (MB)'
        }
      },
      axis: {
        x: {
          type: 'category',
          // name of each category
          categories: [@foreach(array_slice($bandwidth->outgoing_bytes, -10) as $data => $value) {!! '"'.dateHelper($value[0], 'j M').'",' !!} @endforeach]
        },
      },
      bar: {
        width: 16
      },
      legend: {
                show: false, //hide legend
      },
      padding: {
        bottom: 0,
        top: 0
      },
    });
  });
});

</script>

</div>

<div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Latest Activity</h3>
              <div class="card-options">
                <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table card-table table-striped table-vcenter">
                <thead>
                  <tr>
                    <th colspan="2">User</th>
                    <th>Activity</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse( $activities as $activity )
                  <tr>
                    <td class="w-1">
                      <span class="avatar" style="background-image: url({{ Gravatar::src( $activity->causer->email ) }})"></span>
                    </td>
                    <td class="text-nowrap">{{ $activity->causer->slug() }}</td>
                    <td>{{ $activity->description }}</td>
                    <td class="text-nowrap">{{ \Carbon\Carbon::parse($activity->created_at )->diffForHumans() }}</td>
                  </tr>

                  @empty

                   {{-- <div class="alert alert-info">
                      No activity
                    </div> --}}

                    @alert([ 'type' => 'info'])
                       No activity
                    @endalert

                  @endforelse
        
                </tbody>
              </table>
            </div>

            @if ( !$activities->isEmpty() )

            <div class="card-footer">

              <small class="float-right"><a href="{{ route('servers.view.activity', ['serverid' => $serverid]) }}">View activities</a></small>
              
            </div>

            @endif

          </div>
</div>

@if ( $appInfo->app_info !== "")

<div class="col-lg-12">

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Application Information</h3>
        <div class="card-options">
          <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
          <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
        </div>
      </div>

        <div class="text-wrap">

          <div class="highlight">
            <pre>{!! makeClickableLinks($appInfo->app_info) !!}</pre>
          </div>

        </div>
            
    </div>
  </div>

  @endif

</div>

</div>

</div>

@endsection