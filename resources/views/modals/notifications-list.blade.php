<div class="card">

      <div class="card-status bg-blue"></div>

      <div class="card-header">
        <div class="card-title">Notifications</div>  

        <div class="card-options">
    	@if ( $user::find( Auth::id() )->unreadNotifications->count() > 0 || $user::find( Auth::id() )->notifications->count() > 0 )

	    <div class="server-action dropdown">
	      <h3 href="javascript:void(0)" style="cursor: pointer" data-toggle="dropdown" class="icon mt-4"><i class="fe fe-more-vertical"></i></h3>

	      <div class="dropdown-menu dropdown-menu-right">
	      	@if ( $user::find( Auth::id() )->unreadNotifications->count() > 0 )

	        <form action="{{ url('settings/notif/markallasread') }}#notifications" method="post" accept-charset="utf-8">
	            @method('PATCH')
	            @csrf
	        
	            <a href="javascript:void(0)" class="dropdown-item mark-notifications"><i class="dropdown-icon fe fe-eye"></i> Mark all as read</a>
	        
	        </form>

	        @endif
	        @if ( $user::find( Auth::id() )->notifications->count() > 0 )

	        <div class="dropdown-divider"></div>
	        <form action="{{ url('settings/notif/deleteall') }}#notifications" method="post" accept-charset="utf-8">
	            @method('DELETE')
	            @csrf
	        
	            <a href="javascript:void(0)" class="dropdown-item red delete-notifications"><i class="dropdown-icon red fe fe-trash-2"></i> Clear all</a>

	      </form>

	      @endif

	      </div>
	    </div>

	    @endif

        </div>

      </div>

    <div class="card-body">

	<ul class="nav nav-pills flex-nowrap mb-4" id="myTab" role="tablist">

	  <li class="nav-item">
	    <a class="nav-link active p-2" id="unreadnotifications-tab" data-toggle="tab" href="#unreadnotifications" role="tab" aria-controls="unreadnotifications" aria-selected="true">Unread notifications</a>
	  </li>

	  <li class="nav-item">
	    <a class="nav-link p-2" id="allnotifications-tab" data-toggle="tab" href="#allnotifications" role="tab" aria-controls="allnotifications" aria-selected="false">All notifications</a>
	  </li>

	</ul>

	<div class="tab-content" id="myTabContent">
	  <div class="tab-pane fade show active" id="unreadnotifications" role="tabpanel" aria-labelledby="unreadnotifications-tab">

	  	@if ( Session::has('success_message') )
        
            <div class="alert alert-success mb-4"><i class="fe fe-check mr-2" aria-hidden="true"></i> {!! session('success_message') !!}</div>

       @endif

    	@if ( $user::find( Auth::id() )->unreadNotifications->count() > 0 )

	    	<div class="alert alert-info">
	        	<i class="fe fe-bell mr-2" aria-hidden="true"></i> {{ __('You have '.$user::find( Auth::id() )->unreadNotifications->count().' unread notifications. ') }}
	        </div>

        @endif

    	@forelse( $user::find( Auth::id() )->unreadNotifications as $notification )

    	<div class="accordion" id="accordionExample">

		  <div class="card mb-2">

		    <div class="card-header" id="{{ $notification->id }}-header">
		      
		        <a class="d-flex show-notification" data-toggle="collapse" data-target="#{{ $notification->id }}-unread" aria-expanded="true" aria-controls="{{ $notification->id }}-unread" style="cursor: pointer;">

        		<span class="avatar mr-3 align-self-center" style="background-image: url({{ Gravatar::src( $user::find( $notification->notifiable_id )->email ) }})"></span>
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
			                {{ __('added a new domain name server') }}
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
			                {{ __('has destroyed server') }}
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

		    </div>

		    <div id="{{ $notification->id }}-unread" class="collapse" aria-labelledby="{{ $notification->id }}-header" data-parent="#accordionExample">

		      <div class="card-body">
		      	<ul class="list-group">
			      	@foreach ( $notification->data as $key => $val )

			      		@if ( is_array( $val ) )

			      			@continue

			      		@endif

			      		<li class="list-group-item d-flex justify-content-between align-items-center">
						    <strong>{{ ucfirst(str_replace( '_', ' ', $key )) }}</strong>

						    <h4><span class="badge badge-secondary">{{ $val }}</span></h4>
						</li>
			      		
			      	@endforeach
		      	</ul>

		      </div>
		    </div>
		  </div>

		</div>

		 @empty

        <div class="alert alert-info">
        	<i class="fe fe-bell mr-2" aria-hidden="true"></i> {{ __('You have not received any notifications at this time') }}
        </div>

		@endforelse

		{{-- END UNREAD NOTIFICATIONS --}}

	</div>

	 <div class="tab-pane fade" id="allnotifications" role="tabpanel" aria-labelledby="allnotifications-tab">
	  	@if ( $user::find( Auth::id() )->notifications->count() > 0 )

	    	<div class="alert alert-info">
	        	<i class="fe fe-bell mr-2" aria-hidden="true"></i> {{ __('You have '.$user::find( Auth::id() )->notifications->count().' notifications. ') }}
	        </div>

        @endif

    	@forelse( $user::find( Auth::id() )->notifications as $notification )

    	<div class="accordion" id="accordionExample">

		  <div class="card mb-2">

		  	@if ( $notification->unread() )
		  		<div class="card-status bg-green"></div>
		  	@endif

		    <div class="card-header" id="{{ $notification->id }}-header">
		      
		        <a class="d-flex show-notification" data-toggle="collapse" data-target="#{{ $notification->id }}" aria-expanded="true" aria-controls="{{ $notification->id }}" style="cursor: pointer;">

        		<span class="avatar mr-3 align-self-center" style="background-image: url({{ Gravatar::src( $user::find( $notification->notifiable_id )->email ) }})"></span>
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
			                {{ __('added a new domain name server') }}
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
			                {{ __('has destroyed server') }}
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

		    </div>

		    <div id="{{ $notification->id }}" class="collapse" aria-labelledby="{{ $notification->id }}-header" data-parent="#accordionExample">

		      <div class="card-body">
		      	<ul class="list-group ">
		      	@foreach ( $notification->data as $key => $val )


		      		{{-- {!! $val !!} --}}

		      		@if ( is_array( $val ) )

		      			@continue

		      		@endif

		      		<li class="list-group-item d-flex justify-content-between align-items-center">
					    <strong>{{ ucfirst(str_replace( '_', ' ', $key )) }}</strong>
					    {{-- <span class="badge badge-primary badge-pill">{{ $val }}</span> --}}
					    <h4><span class="badge badge-secondary">{{ $val }}</span></h4>
					</li>
		      		
		      	@endforeach

		      	</ul>

		      </div>

		    </div>
		  </div>

		</div>

		 @empty

        <div class="alert alert-info">
        	<i class="fe fe-bell mr-2" aria-hidden="true"></i> {{ __('You have not received any notifications at this time') }}
        </div>

		@endforelse

		{{-- END ALL NOTIFICATIONS --}}
	  </div>

	</div>


 

    </div>

  </div>


<script type="text/javascript">

      require([ 'core' ], function () {

        $(document).ready(function () {

        function markAsRead(id ){
            $.ajax({
               type: 'POST',
               url: 'settings/notif/markasread/' + id,
               data: { _method: 'PATCH', _token: '<?php echo csrf_token() ?>', notification_id: id },
            });

         }

        	$('.show-notification').one('click', function () {
			  	
        		var id = $(this).attr('data-target');

        		var notification_id = id.replace('#', '');

        		markAsRead(notification_id.replace('-unread', ''));

			})

        });

});

</script>
