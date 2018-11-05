<nav class="nav nav-pills nav-justified instance-nav-list">
	<a class="nav-link secondary-link home {{ $currentRouteName === 'servers.view' ? 'active' : '' }}" href="{{ route('servers.view', $serverid) }}"><i class="fe fe-bar-chart-2 mr-1"></i>Overview</a>
	<a class="nav-link secondary-link home {{ $currentRouteName === 'servers.view.settings' ? 'active' : '' }}" href="{{ route('servers.view.settings', $serverid) }}"><i class="fe fe-settings mr-1"></i>Settings</a>
	<a class="nav-link secondary-link home {{ $currentRouteName === 'servers.view.snapshots' ? 'active' : '' }}" href="{{ route('servers.view.snapshots', $serverid) }}"><i class="fe fe-camera mr-1"></i>Snapshots</a>
	<a class="nav-link secondary-link home {{ $currentRouteName === 'servers.view.backups' ? 'active' : '' }}" href="{{ route('servers.view.backups', $serverid) }}"><i class="fe fe-hard-drive mr-1"></i>Backups</a>
	<a class="nav-link secondary-link home {{ $currentRouteName === 'servers.view.activity' ? 'active' : '' }}" href="{{ route('servers.view.activity', $serverid) }}"><i class="fe fe-activity mr-1"></i>Activity</a>

{{-- 	<a class="nav-link home {{ $currentRouteName === 'servers.view.ddos' ? 'active' : '' }}" href="{{ route('servers.view.ddos', $serverid) }}"><i class="fe fe-shield"></i>&nbsp;DDOS</a> --}}
</nav>