<div class="dropdown d-flex">
  <a class="nav-link icon" data-toggle="dropdown">
    <i class="fe fe-mail"></i>

    @if ( Auth::user()::find( Auth::id() )->unreadMessagesCount() > 0 )

      <span class="nav-unread"></span>

    @endif

  </a>
  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">

    @forelse( $user::find( Auth::id() )->unreadNotifications->take(6) as $notification )

      <a href="{{ url('/settings#notifications') }}" class="dropdown-item d-flex">

        <span class="avatar mr-3 align-self-center" style="background-image: url({{ Gravatar::src( $user::find( $notification->notifiable_id )->email ) }})">
            
        </span>
        <div>
          
          <strong>{{ $user::find( Auth::id() )->slug() }}</strong> 

           @switch( $notification->type )

            @case('vultrui\Notifications\BlockStorageAdded')
                {{ __('added a new block storage') }}
                @break

            @case('vultrui\Notifications\BlockStorageDeleted')
                {{ __('deleted block storage') }}
                @break

            @case('vultrui\Notifications\DnsAdded')
                {{ __('added a new Domain name server') }}
                @break

            @case('vultrui\Notifications\DnsDeleted')
                {{ __('deleted domain name') }}
                @break

            @case('vultrui\Notifications\IsoAdded')
                {{ __('added a new ISO') }}
                @break

            @case('vultrui\Notifications\KeyAdded')
                {{ __('added a new SSH key') }}
                @break

            @case('vultrui\Notifications\KeyDeleted')
                {{ __('deleted SSH key') }}
                @break

            @case('vultrui\Notifications\PrivateNetworkAdded')
                {{ __('added a new private network') }}
                @break

            @case('vultrui\Notifications\PrivateNetworkDeleted')
                {{ __('deleted a private network') }}
                @break

            @case('vultrui\Notifications\ServerDeployed')
                {{ __('deployed a new server') }}
                @break

            @case('vultrui\Notifications\ServerDestroyed')
                {{ __('destroyed server') }}
                @break

            @case('vultrui\Notifications\SnapshotAdded')
                {{ __('take a new snapshot') }}
                @break

            @case('vultrui\Notifications\SnapshotDeleted')
                {{ __('deleted snapshot') }}
                @break

            @case('vultrui\Notifications\StartupScriptAdded')
                {{ __('added a new startup script') }}
                @break

            @case('vultrui\Notifications\StartupScriptDeleted')
                {{ __('deleted startup script') }}
                @break

            @default
                {{ __('performed new action') }}
        @endswitch
          
          <div class="small text-muted">

            {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}

          </div>

        </div>
      </a>

    @empty

        <div class="text-center text-nowrap p-3">
            You have not received any notifications at this time
          <div class="small text-muted"></div>

        </div>

    @endforelse

    <div class="dropdown-divider"></div>
    <a href="{{ url('/settings#notifications') }}" class="dropdown-item text-center text-muted-dark">{{ __('View Notifications') }}</a>
  </div>
</div>