@extends('dashboard')

@section('title', 'Add ISO')

@section('content')

<div class="page-header">
    <h1 class="page-title">
      <a class="icon back-previous" href="{{ url('/iso') }}"><i class="fe fe-arrow-left-circle"></i></a>
        Add ISO
    </h1>
</div>

      <div class="row">
          <div class="col-md-7 col-xl-6" style="margin:auto;">
              <div class="card">
              <div class="card-status bg-blue"></div>
              <div class="card-header">
                    <h3 class="card-title">Upload ISO from remote machine </h3>
              </div>
              <div class="card-body">

                @if (Session::has('message'))

                     {{-- <div class="alert alert-info">{!! session('message') !!}</div> --}}

                     @alert([ 'type' => 'info'])
                        {!! session('message') !!}
                    @endalert

               @endif


                <form action="{{ route('iso.create') }}" method="POST" accept-charset="utf-8">
                  @csrf
                  <div class="form-group">
                          <label class="form-label">Remote URL</label>
                          <input class="form-control" name="iso_url" placeholder="Remote URL (http and https URLs are permitted, up to 8192MB)" type="text" value="{{ old('iso_url') }}">
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