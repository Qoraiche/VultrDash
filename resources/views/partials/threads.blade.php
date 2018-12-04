{{-- {{ dd($threads->all()) }} --}}
<div class="clearfix">
	<div class="float-left mb-4">
		<h1>Threads</h1>
	</div>
	<div class="float-right mb-4">
		<div class="btn-group" role="group" aria-label="New Message">
		  <a href="javascript:void(0)" class="btn btn-secondary new-message"><i class="fe fe-plus mr-2"></i>New message</a>
		</div>
	</div>
</div>

@if ( Session::has('success') )
    {{-- <div class="alert alert-success">{!! session( 'success' ) !!}</div> --}}

    @alert([ 'type' => 'success'])
      {!! session( 'success' ) !!}
    @endalert

@endif

<div class="card">
  <div class="card-header send-form" style="display: none">

    <div class="col-md-12 p-0 pt-1 m-0">

    	<form method="POST" action="{{ route('account.thread.store') }}">
    		@csrf
            <!-- Subject Form Input -->
            <div class="form-group">
                <input type="text" class="form-control" name="subject" placeholder="Subject" value="" required>
            </div>

            <!-- Message Form Input -->
            <div class="form-group">
                <textarea name="message" class="form-control" placeholder="Message" rows="5" required></textarea>
            </div>

            <div class="form-group">
              <div class="form-label">Recipients</div>
              <div>
              @foreach( $users as $user )
                <label class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" class="custom-control-input" name="recipients[]" value="{{ $user->id }}">
                  <span class="custom-control-label">{{ $user->slug() }}</span>
                </label>
                @endforeach
              </div>
            </div>
                
            <!-- Submit Form Input -->
            <div class="form-group">
                <div class="btn-list mt-4 text-right">
                    <button type="button" class="btn btn-secondary btn-space" onclick="$('.send-form').slideToggle();">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-space">Send message</button>
                </div>
            </div>

        </form>
        </div>

  </div>
  <ul class="list-group card-list-group">
  	@forelse( $threads as $thread )

    <li class="list-group-item">
      <div class="media alert {{ $thread->isUnread(Auth::id()) ? ' alert-info' : '' }}">
        <div class="media-object avatar avatar-md mr-4" style="background-image: url({{ $thread->creator() !== null ? Gravatar::src( $thread->creator()->email ) : ''}})"></div>
        <div class="media-body">
          <div class="media-heading">
            <small class="float-right text-muted">{{ $thread->updated_at->diffForHumans() }}</small>
            <h5><a href="{{ route('account.thread.show', [ 'id' => $thread->id ]) }}">{{ $thread->subject }}</a>
            	@if( $thread->isUnread(Auth::id()) )
            	<small class="ml-2 text-muted">{{ $thread->userUnreadMessagesCount(Auth::id()) }} unread</small>
            	@endif
            </h5>
          </div>
          <div>
            {{ $thread->latestMessage->body }}
          </div>
          <div>
			<div class="mt-5 avatar-list">

        {{-- {{ dd($user->find(10))->email }} --}}

			@foreach( $thread->participants as $participant )

			  <span class="avatar avatar-sm" style="background-image: url({{ $user->find( $participant->user_id ) !== null ? Gravatar::src( $user->find($participant->user_id)->email) : '' }} )" data-toggle="tooltip" data-placement="top" title="{{ $user->find( $participant->user_id ) !== null ? $user->find($participant->user_id)->slug() : 'User no longer exists' }}">
        </span>

			 @endforeach

			</div>
      </div>

          @if( $thread->creator() !== null && $thread->creator()->is( auth()->user() ) || auth()->user()->hasRole('super-admin') )
          <small class="float-right text-muted d-inline">
          	<form action="{{ route('account.thread.delete', [ 'id' => $thread->id ]) }}" method="POST">
          		@csrf
          		@method('DELETE')
          		<a href="javascript:void(0)" class="icon delete-thread"><i class="fe fe-trash-2"></i></a>
          	</form>
          </small>
          @endif

        </div>
      </div>
    </li>

    @empty

	<li class="list-group-item">    

    {{-- <div class="alert alert-info">You have not received any messages at this time</div> --}}

      @alert([ 'type' => 'info'])
        {!! session( 'success' ) !!}
      @endalert

	</li>

    @endforelse
  </ul>
</div>

{{ $threads->fragment('messages')->links() }}
