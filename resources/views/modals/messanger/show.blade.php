@extends('modals.messanger.master')

@section('content')
    <div class="col-md-6">
        <h1>{{ $thread->subject }}</h1>
        @each('modals.messanger.partials.messages', $thread->messages, 'message')

        @include('modals.messanger.partials.form-message')
    </div>
@stop