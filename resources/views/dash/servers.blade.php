@extends('dashboard')

@section('title', 'Servers')

@section('content')

      <div class="page-header">
          <h1 class="page-title">
            Servers
          </h1>
      </div>

       <div class="row">
        <div class="col-lg-3 order-lg-1 mb-4">

        <a href="{{ url('/servers/add') }}" class="btn btn-block btn-primary @if( !auth()->user()->can('deploy servers') ) btn-secondary disabled @endif mb-6">
            Deploy Server
          </a>

         @include( 'partials.nav', [ 'currentRouteName' => Route::currentRouteName()])

        </div>
              <div class="col-lg-9">
                <div class="card">
                  <div class="card-body">

      @if( !auth()->user()->can('manage servers') )

          {{-- <div class="card-alert alert alert-warning mb-0">
              <i class="fe fe-lock" title="fe fe-lock"></i> <strong>Forbidden!</strong> You don't have permission to manage servers.
          </div> --}}

        @alert([ 'type' => 'warning', 'card', 'classes' => 'mb-0'])
          You don't have permission to manage Servers.
        @endalert

      @endif

      @if ( Session::has('warning') )

            <div class="alert alert-warning"><i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i> {!! session( 'warning' ) !!}</div>

      @endif
                    
      @if ( Session::has('message') )

            <div class="alert alert-info">{!! session( 'message' ) !!}</div>

      @endif

@can('manage servers')

   <div id="instances">

      <div class="page-header">

          <div class="total-instances page-subtitle">{{ count($servers) <= 1 ? count($servers).' '.str_singular('server') : count($servers).' servers' }}</div>

          <div class="page-options d-flex">

           <div class="input-icon ml-2">

                  <span class="input-icon-addon">
                    <i class="fe fe-search"></i>
                  </span>

                  <input class="search form-control w-10" placeholder="Search Servers ..." type="text">
           </div>

          </div>

      </div>

      <div class="table-responsive">

        <table class="table table-hover table-outline table-vcenter text-nowrap card-table">

          <thead>

            <tr>

              <th></th>
              <th>Server</th>
              <th class="text-center">Location</th>
              <th class="text-center">Disk</th>
              <th class="text-center">Pending charges</th>
              <th class="text-center">Status</th>
              <th></th>
            </tr>
            
          </thead>

          <tbody class="list">

            @forelse ( $servers as $server)

              <tr>

                <td class="type">

                <div class="avatar d-block" server-type='{{ $os->getOsByKeyId( $server['OSID'], 'family') }}' style="background-image: url( {{ asset( $os->getOsByKeyId( $server['OSID'])  == 'application' ? 'images/'.$app->getServerAppImage( $app->getAppByKeyId( $server['APPID']) ) : 'images/'.$os->getServerOSImage($os->getOsByKeyId( $server['OSID'], 'family') )) }} );
                    background-size:contain;background-color: #fff;">
                      <span class="avatar-status {{ strtolower($server['power_status']) == 'running' ? 'bg-green' : 'bg-red' }}"></span>
                    </div>
                </td>

                  <td class="server">
                      <div><a class="text-inherit" href="{{ route('servers.view', $server['SUBID']) }}">{{ $server['label'] == '' ? 'Cloud Instance' : ucwords($server['label']) }}</a></div>
                      <div class="small text-muted">
                        {{ $server['ram'] }} Server - {{ $server['main_ip'] }}
                      </div>
                  </td>
                  
                <td class="location text-center">{{ $server['location'] }}</td>

                <td class="disk text-center">{{ $server['disk'] }}</td>

                <td class="charges text-center"><i class="fe fe-dollar-sign"></i>{{ $server['pending_charges'] }}</td>

                <td>
                  <span class="status-icon bg-{{ strtolower($server['status']) == 'active' ? 'success' : 'warning' }} text-center"></span> {{ ucfirst($server['status']) }}
                </td>

                <td>

    <div class="server-action dropdown">

      <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>

      <div class="dropdown-menu dropdown-menu-right">

        <a href="{{ route('servers.view', $server['SUBID']) }}" class="dropdown-item"><i class="dropdown-icon fe fe-eye"></i> View Server</a>

        <form action="{{ strtolower( $server['power_status'] ) == 'running' ? url('servers/halt') : url('servers/start') }}" method="post" accept-charset="utf-8">
            @csrf
            <input type="hidden" name="serverid" value="{{ $server['SUBID'] }}">

            <a href="javascript:void(0)" class="dropdown-item{{ strtolower($server['power_status']) == 'running' ? ' halt' : ' startserver'}}"><i class="dropdown-icon fe fe-power"></i>{{ strtolower($server['power_status']) == 'running' ? 'Stop Server' : 'Start Server' }}</a>

        </form>

        <form action="{{ url('servers/start') }}" method="post" accept-charset="utf-8">
            @csrf
            <input type="hidden" name="serverid" value="{{ $server['SUBID'] }}"> 

            <a href="javascript:void(0)" class="dropdown-item restart"><i class="dropdown-icon fe fe-refresh-cw"></i>Restart Server</a>

          </form>

            <a href="javascript:void(0)" class="dropdown-item" onclick="window.open('{{ $server['kvm_url'] }}','','width=600,height=450')"><i class="dropdown-icon fe fe-terminal"></i> View Console</a>

        <form action="{{ url('servers/reinstall') }}" method="post" accept-charset="utf-8">
            @csrf
            <input type="hidden" name="serverid" value="{{ $server['SUBID'] }}"> 
        
            <a href="javascript:void(0)" class="dropdown-item reinstall"><i class="dropdown-icon fe fe-disc"></i> Reinstall Server</a>
        
        </form>

        <div class="dropdown-divider"></div>

        <form action="{{ url('servers/destroy') }}" method="post" accept-charset="utf-8">
            @csrf
            <input type="hidden" name="serverid" value="{{ $server['SUBID'] }}"> 
        
            <a href="javascript:void(0)" class="dropdown-item destroy"><i class="dropdown-icon fe fe-trash-2"></i> Destroy Server</a>

      </form>

      </div>
    </div>

                  </td>

                </tr>

                @empty

                    {{-- <div class="alert alert-info">No servers</div> --}}

                    @alert([ 'type' => 'info'])
                      No servers
                    @endalert

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

      require([ 'core', 'selectize' ], function () {

        $(document).ready(function () {

          searchTable('instances', true, 10, ['server', 'charges', 'type', 'location', 'status', 'disk'], '.total-instances', 'server', 'servers');


          $('#sort-location, #sort-status,#sort-type').change(function(){

              if ($(this).val() !== 'all') {

                return instances_list.search($(this).val(), ['location', 'status', 'type']);
                
              }

              return instances_list.search('');

          });

        });

      });

    </script>

@endsection