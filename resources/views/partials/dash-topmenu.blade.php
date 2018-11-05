<div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg order-lg-first">
          <ul class="nav nav-tabs border-0 flex-column flex-lg-row">

            <li class="nav-item">
              <a href="{{ url('/') }}" class="nav-link {!! \Route::currentRouteName() == 'home' ? 'active' : '' !!}"><i class="fe fe-home"></i> {{ __('Dashboard') }}</a>
            </li>

            <li class="nav-item">
              <a href="{{ url('/servers') }}" class="nav-link {!! \Route::currentRouteName() == 'servers.index' ? 'active' : '' !!}"><i class="fe fe-server"></i> {{ __('Servers') }}</a>
            </li>

            @hasrole('super-admin')

            <li class="nav-item">
              <a href="{{ url('/users') }}" class="nav-link {!! \Route::currentRouteName() == 'users.index' ? 'active' : '' !!}"><i class="fe fe-users"></i> {{ __('Users') }}</a>
            </li>

            @endhasrole

            <li class="nav-item dropdown">
              <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-plus"></i> {{ __('New') }}</a>
              
              <div class="dropdown-menu dropdown-menu-arrow">
                <a href="{{ url('/servers/add') }}" class="dropdown-item">Instance</a>
                <a href="{{ url('/snapshots/add') }}" class="dropdown-item">Snapshot</a>
                <a href="{{ url('/blockstorage/add') }}" class="dropdown-item">Block Storage</a>
                <a href="{{ url('/dns/add') }}" class="dropdown-item">Domain</a>
                <a href="{{ url('/sshkeys/add') }}" class="dropdown-item">SSH Key</a>
                <a href="{{ url('/networks/add') }}" class="dropdown-item">Network</a>
                @hasrole('super-admin')
                <a href="{{ url('/users/create') }}" class="dropdown-item">User</a>
                @endhasrole
              </div>
            </li>

            <li class="nav-item">
              <a href="{{ url('/activity') }}" class="nav-link {!! \Route::currentRouteName() == 'activity' ? 'active' : '' !!}"><i class="fe fe-activity"></i> {{ __('Activity log') }}</a>
            </li>

            {{-- <li class="nav-item dropdown">
              <a href="javascript:void(0)" class="nav-link {!! \Route::currentRouteName() == 'settings.profile' ? 'active' : '' !!}" data-toggle="dropdown"><i class="fe fe-settings"></i> {{ __('Settings') }}</a>
              <div class="dropdown-menu dropdown-menu-arrow">
                <a href="./profile.html" class="dropdown-item">Profile</a>
              </div>
            </li> --}}

          </ul>
        </div>
      </div>
    </div>
  </div>