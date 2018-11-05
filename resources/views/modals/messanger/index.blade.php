@extends('modals.messanger.master')

@section('content')
    @include('modals.messanger.partials.flash')

    @each('modals.messanger.partials.thread', $threads, 'thread', 'modals.messanger.partials.no-threads')
@endsection