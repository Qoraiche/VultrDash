@extends('dashboard')

@section('title', 'Upload snapshot')

@section('content')

<div class="page-header">
    <h1 class="page-title">
      <a class="icon back-previous" href="{{ url('/snapshots') }}"><i class="fe fe-arrow-left-circle"></i></a>
        Upload Snapshot
    </h1>
</div>

      <div class="row">
          <div class="col-md-7 col-xl-6" style="margin:auto;">
              <div class="card">
              <div class="card-status bg-blue"></div>
              <div class="card-header">
                    <h3 class="card-title">Upload snapshot from remote machine </h3>
                    <div class="card-options">
                      <button type="button" class="btn btn-primary btn-sm" onclick="javascript:window.location.href='{{ route('snapshots.add') }}'">Take Snapshot</button>
                    </div>
              </div>
              <div class="card-body">
                @if (Session::has('message'))

                     <div class="alert alert-info">{!! session('message') !!}</div>

               @endif
                <form action="{{ url('snapshots/createfromurl') }}" method="POST" accept-charset="utf-8">
                @csrf
                      <div class="form-group">
                      <label class="form-label">Remote URL</label>
                      <input type="text" name="url" class="form-control" placeholder="Remote URL (http and https URLs are permitted, up to 150GB)">
                    </div>
                    <div class="form-group">
                      <input type="submit" class="btn btn-primary btn-lg btn-block" value="Upload" onclick="this.disabled = true;this.value = 'Please wait...'">
                    </div>
                </form>
              </div>
            </div>
         </div>
      </div>

@endsection