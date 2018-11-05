@extends('dashboard')

@section('title', $serverInfo->$serverid->label == '' 

? 'Manage Server' 

: 'Manage Server ('.$serverInfo->$serverid->label.')')

@section('content')

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="main-content card-body">
        

        {{-- @include( 'partials.nav', [ 'currentRouteName' => Route::currentRouteName()]) --}}

        @if ( $serverInfo->$serverid->status != 'active' )

          <div class="alert alert-icon alert-warning" role="alert">
            <i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i>{{ __('Your server is currently being installed. Most server actions will be unavailable until this has completed') }}
          </div>

          <script type="text/javascript">

             setTimeout(function() {

                 window.location = '{{ url('/refresh') }}';

             }, 20000);

          </script>

        @endif

<div class="server-head-information">

<div class="d-none d-md-inline">

<span class="avatar avatar-lg" style="background-image: url({{ asset( $os->getOsByKeyId( $serverInfo->$serverid->OSID )  == 'application' ? 'images/'.$app->getServerAppImage( $app->getAppByKeyId( $serverInfo->$serverid->APPID ) ) : 'images/'.$os->getServerOSImage($os->getOsByKeyId( $serverInfo->$serverid->OSID, 'family') )) }})">

    <span class="avatar-status {{ strtolower($serverInfo->$serverid->power_status) == 'running' ? 'bg-green' : 'bg-red' }}"></span>

</span>

<h2>Server Information {{ $serverInfo->$serverid->label == '' ? '' : '( '.$serverInfo->$serverid->label.' )'}}</h2>

</div>

<div class="d-md-none d-lg-none d-xl-none">

<span class="avatar avatar-md" style="background-image: url({{ asset( $os->getOsByKeyId( $serverInfo->$serverid->OSID )  == 'application' ? 'images/'.$app->getServerAppImage( $app->getAppByKeyId( $serverInfo->$serverid->APPID ) ) : 'images/'.$os->getServerOSImage($os->getOsByKeyId( $serverInfo->$serverid->OSID, 'family') )) }})">

  <span class="avatar-status {{ strtolower($serverInfo->$serverid->power_status) == 'running' ? 'bg-green' : 'bg-red' }}"></span>

</span>

<h2 style="font-size: 1.2em;">Server Information {{ $serverInfo->$serverid->label == '' ? '' : '( '.$serverInfo->$serverid->label.' )'}}</h2>

</div>

<ul class="server-action list-inline mb-0 mt-2 d-none d-lg-block">

  
<li class="list-inline-item">

  <form action="{{ strtolower( $serverInfo->$serverid->power_status ) == 'running' ? url('servers/halt') : url('servers/start') }}" method="post" accept-charset="utf-8">
      @csrf
      <input type="hidden" name="serverid" value="{{ $serverid }}">
      <a class="icon{{ strtolower($serverInfo->$serverid->power_status) == 'running' ? ' halt' : ' startserver'}}" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{{ strtolower($serverInfo->$serverid->power_status) == 'running' ? 'Stop Server' : 'Start Server' }}">
      <i class="fe fe-power"></i>
    </a>

  </form>

</li>

  <li class="list-inline-item">
      <form action="{{ url('servers/start') }}" method="post" accept-charset="utf-8">
        @csrf
        <input type="hidden" name="serverid" value="{{ $serverid }}"> 
        <a class="icon restart" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Restart Server">
        <i class="fe fe-refresh-cw"></i>
      </a>

    </form>
  </li>

  <li class="list-inline-item">

      <a href="javascript:void(0)" onclick="window.open('{{ $serverInfo->$serverid->kvm_url }}','','width=600,height=450')" class="icon" data-toggle="tooltip" data-original-title="View Console"><i class="fe fe-terminal"></i></a>

  </li>

  <li class="list-inline-item">

    <form action="{{ url('servers/reinstall') }}" method="post" accept-charset="utf-8">
        @csrf
        <input type="hidden" name="serverid" value="{{ $serverid }}"> 

    <a href="javascript:void(0)" class="icon reinstall" data-toggle="tooltip" data-original-title="Reinstall Server"><i class="fe fe-disc"></i></a>

  </form>

  </li>

  <li class="list-inline-item">

    <form action="{{ url('servers/destroy') }}" method="post" accept-charset="utf-8">
        @csrf
        <input type="hidden" name="serverid" value="{{ $serverid }}"> 

    <a href="javascript:void(0)" class="icon destroy" data-toggle="tooltip" data-original-title="Destroy Server"><i class="fe fe-trash-2"></i></a>

    </form>

  </li>

</ul>

<div class="server-action dropdown list-inline mb-0 mt-2 d-lg-none d-xl-none">

  <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>

  <div class="dropdown-menu dropdown-menu-right">

    <form action="{{ url('servers/start') }}" method="post" accept-charset="utf-8">
        @csrf
        <input type="hidden" name="serverid" value="{{ $serverid }}"> 

        <a href="javascript:void(0)" class="dropdown-item{{ strtolower($serverInfo->$serverid->power_status) == 'running' ? ' halt' : ''}}"><i class="dropdown-icon fe fe-power"></i>{{ strtolower($serverInfo->$serverid->power_status) == 'running' ? 'Stop Server' : 'Start Server' }} </a>
    </form>

    <form action="{{ url('servers/start') }}" method="post" accept-charset="utf-8">
        @csrf
        <input type="hidden" name="serverid" value="{{ $serverid }}"> 

        <a href="javascript:void(0)" class="dropdown-item restart"><i class="dropdown-icon fe fe-refresh-cw"></i>Restart Server</a>
      </form>

        <a href="javascript:void(0)" class="dropdown-item" onclick="window.open('{{ $serverInfo->$serverid->kvm_url }}','','width=600,height=450')"><i class="dropdown-icon fe fe-terminal"></i> View Console</a>

    <form action="{{ url('servers/reinstall') }}" method="post" accept-charset="utf-8">
        @csrf
        <input type="hidden" name="serverid" value="{{ $serverid }}"> 
    
        <a href="javascript:void(0)" class="dropdown-item reinstall"><i class="dropdown-icon fe fe-disc"></i> Reinstall Server</a>
    </form>

    <div class="dropdown-divider"></div>

    <form action="{{ url('servers/destroy') }}" method="post" accept-charset="utf-8">
        @csrf
        <input type="hidden" name="serverid" value="{{ $serverid }}"> 
    
        <a href="javascript:void(0)" class="dropdown-item red destroy"><i class="dropdown-icon red fe fe-trash-2"></i> Destroy Server</a>
  </form>

  </div>
</div>


<ul class="server-info-list">
  <li>{{ $serverInfo->$serverid->main_ip }}</li>
  <li>{{ $serverInfo->$serverid->location }}</li>
  <li>{{ $serverInfo->$serverid->os }}</li>
  <li>{{ $serverInfo->$serverid->vcpu_count }} vCPU</li>
  <li>{{ $serverInfo->$serverid->ram }}</li>
  <li>
    <div data-toggle="tooltip" data-placement="top" data-original-title="{{ $serverInfo->$serverid->date_created }}">{{ \Carbon\Carbon::parse($serverInfo->$serverid->date_created)->diffForHumans() }}</div>
  </li>
  
  <li class="list-inline-item">
  <a class="icon showpass" href="javascript:void(0)" data-container="body" data-toggle="popover" data-placement="top" data-content="<span><strong>Username:</strong> root</span></br><span><strong>Password:</strong> {{ $serverInfo->$serverid->default_password }}</span>">
  <i class="fa fa-key"></i>
  </a>

</li>
</ul>

</div>

    <div class="row server-information">

         <div class="col-md-12 col-xl-12" style="margin:auto;">

             @include('partials.view-server-nav', ['currentRouteName' => Route::currentRouteName(), 'serverid' => $serverid ])

             <div class="info-data overview">

              @yield('server-view-tab')
              
             </div>
           
         </div>

    </div>

  </div>

</div>

</div>

</div>


@endsection