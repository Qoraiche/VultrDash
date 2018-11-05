<div class="list-group list-group-transparent mb-0">

  <a href="{{ route('servers.index') }}" class="list-group-item list-group-item-action {{ $currentRouteName === 'servers.index' || $currentRouteName === 'dashboard' ? 'active' : '' }} @if( !auth()->user()->can('manage servers') ) disabled @endif"><span class="icon mr-3"></span>Instances</a>

  <a href="{{ route('snapshots.index') }}" class="list-group-item list-group-item-action {{ $currentRouteName === 'snapshots.index' ? 'active' : '' }} @if( !auth()->user()->can('manage snapshots') ) disabled @endif"><span class="icon mr-3"></span>Snapshots</a>

  <a href="{{ route('iso.index') }}" class="list-group-item list-group-item-action {{ $currentRouteName === 'iso.index' ? 'active' : '' }} @if( !auth()->user()->can('manage iso') ) disabled @endif"><span class="icon mr-3"></span>ISO</a>

  <a href="{{ route('startup.index') }}" class="list-group-item list-group-item-action {{ $currentRouteName === 'startup.index' ? 'active' : '' }} @if( !auth()->user()->can('manage startupscripts') ) disabled @endif"><span class="icon mr-3"></span>Startup Scripts</a>

  <a href="{{ route('sshkeys.index') }}" class="list-group-item list-group-item-action {{ $currentRouteName === 'sshkeys.index' ? 'active' : '' }} @if( !auth()->user()->can('manage sshkeys') ) disabled @endif"><span class="icon mr-3"></span>SSH Keys</a>
  
  <a href="{{ route('dns.index') }}" class="list-group-item list-group-item-action {{ $currentRouteName === 'dns.index' ? 'active' : '' }} @if( !auth()->user()->can('manage dns') ) disabled @endif"><span class="icon mr-3"></span>DNS</a>

  <a href="{{ route('ips') }}" class="list-group-item list-group-item-action {{ $currentRouteName === 'ips' ? 'active' : '' }} @if( !auth()->user()->can('manage ips') ) disabled @endif"><span class="icon mr-3"></span>Reserved IPs</a>

  <a href="{{ route('backups.index') }}" class="list-group-item list-group-item-action {{ $currentRouteName === 'backups.index' ? 'active' : '' }} @if( !auth()->user()->can('manage backups') ) disabled @endif"><span class="icon mr-3"></span>Backups</a>

  <a href="{{ route('blockstorage.index') }}" class="list-group-item list-group-item-action {{ $currentRouteName === 'blockstorage.index' ? 'active' : '' }} @if( !auth()->user()->can('manage blockstorage') ) disabled @endif"><span class="icon mr-3"></span>Block Storage</a>

{{--   <a href="{{ route('ips') }}" class="list-group-item list-group-item-action {{ $currentRouteName === 'ips' ? 'active' : '' }} @if( !auth()->user()->can('manage ips') ) disabled @endif"><span class="icon mr-3"></span>Reserved IPs</a> --}}

  <a href="{{ route('firewall.index') }}" class="list-group-item list-group-item-action {{ $currentRouteName === 'firewall.index' ? 'active' : '' }} @if( !auth()->user()->can('manage firewalls') ) disabled @endif"><span class="icon mr-3"></span>Firewall</a>

  <a href="{{ route('networks.index') }}" class="list-group-item list-group-item-action {{ $currentRouteName === 'networks.index' ? 'active' : '' }} @if( !auth()->user()->can('manage networks') ) disabled @endif"><span class="icon mr-3"></span>Networks</a>

</div>