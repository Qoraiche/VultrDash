@extends('dashboard')

@section('title', 'Thread ('.$thread->subject.')')

@section('content')

{{-- {{ $thread }} --}}

<div class="page-header">
    <h1 class="page-title">
      <a class="icon back-previous" href="{{ url('/account#messages') }}"><i class="fe fe-arrow-left-circle"></i></a>
        {{ $thread->subject }}
    </h1>
</div>

@if( $thread->creator() !== null && $thread->creator()->is( auth()->user() ) || auth()->user()->hasRole('super-admin') )
  <div class="text-right mb-4">
      <div class="btn-group" role="group" aria-label="Delete Thread">
        <form action="{{ route('account.thread.delete', [ 'id' => $thread->id ]) }}" method="POST">
                @csrf
                @method('DELETE')
        <a href="javascript:void(0)" class="btn btn-danger delete-thread"><i class="fe fe-trash-2 mr-2"></i>Delete Thread</a>
      </form>
      </div>
  </div>
@endif


<div class="container">

  <div class="row">
    <div class="card">
      <div class="card-header">
        <form method="POST" class="w-100" action="{{ route('account.thread.update', $thread->id) }}">
          @csrf
          @method('PUT')
        <div class="input-group">
          <textarea class="form-control" name="message" rows="2" placeholder="Reply.."></textarea>
          <div class="input-group-append">
            <button type="submit" class="btn btn-secondary">
              <i class="fe fe-send"></i>
            </button>
          </div>
        </div>
        </form>
      </div>

      <ul class="list-group card-list-group">
        @foreach ( $thread->messages as $message )
        <li class="list-group-item" id="{{ $message->id }}">
          <div class="media alert ">
            <div class="media-object avatar avatar-md mr-4" style="background-image: url({{ $message->user !== null ? Gravatar::src( $message->user->email ) : '' }})"></div>
            <div class="media-body">
              <div class="media-heading">
                <small class="float-right text-muted">{{ $message->updated_at->diffForHumans() }}</small>
                <h5 class="d-inline">{{ $message->user !== null ? $message->user->slug() : 'User' }}</h5>
                @if( $message->user !== null && $message->user->hasRole('super-admin') )
                <span class="tag tag-green ml-2">Administrator</span>
                @endif
                @if( $message->user === null )
                <span class="tag tag-secondary ml-2">User no longer exists</span>
                @endif
              </div>
              <div class="mt-2">
                {{ $message->body }}
              </div>
            </div>
          </div>
        </li>
        @endforeach
      </ul>

    </div>

  </div>

</div>



@endsection
