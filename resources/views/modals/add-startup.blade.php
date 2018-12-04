@extends('dashboard')

@section('title', 'Add Startup Script')

@section('content')

<div class="page-header">
    <h1 class="page-title">
      <a class="icon back-previous" href="{{ url('/startup') }}"><i class="fe fe-arrow-left-circle"></i></a>
        Add Startup Script 
    </h1>
</div>

<div class="row">
    <div class="col-md-7 col-xl-6 mx-auto">
        <div class="card">
            <div class="card-status bg-blue"></div>
            <div class="card-header">
                <h3 class="card-title">Startup Script</h3>
            </div>
            <div class="card-body">

                @if (Session::has('message'))

                     {{-- <div class="alert alert-info">{!! session('message') !!}</div> --}}

                     @alert([ 'type' => 'info'])
                        {!! session('message') !!}
                     @endalert

               @endif

                <form action="{{ route('startup.create') }}" method="POST" accept-charset="utf-8">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Script name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Type</label>
                        <select name="type" id="select-beast" class="form-control custom-select">
                              <option value="boot">Boot</option>
                              <option value="pxe">Pxe</option>
                            </select>
                    </div>
                    <div class="form-group">
                        <textarea rows="6" name="script" class="form-control" placeholder="Here can be your description" value="Mike">Oh so, your #!/bin/sh # NOTE: This is an example that sets up SSH authorization. To use it, you'd need to replace "ssh-rsa AA... youremail@example.com" with your SSH public. # You can replace this entire script with anything you'd like, there is no need to keep it mkdir -p /root/.ssh chmod 600 /root/.ssh echo ssh-rsa AA... youremail@example.com > /root/.ssh/authorized_keys chmod 700 /root/.ssh/authorized_keys</textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Add Script" onclick="this.disabled = true;this.value = 'Please wait...'">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection