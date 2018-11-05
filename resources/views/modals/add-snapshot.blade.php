@extends('dashboard')

@section('title', 'Add Snapshot')

@section('content')

    <div class="page-header">
        <h1 class="page-title">
          <a class="icon back-previous" href="{{ url('/snapshots') }}"><i class="fe fe-arrow-left-circle"></i></a>
            Add Snapshot
        </h1>
    </div>

      <div class="row">
          <div class="col-md-7 col-xl-6" style="margin:auto;">
              <div class="card">
              <div class="card-status bg-blue"></div>
              <div class="card-header">
                    <h3 class="card-title">Take a snapshot of an active server</h3>

                    <div class="card-options">
                      <button type="button" class="btn btn-primary btn-sm" onclick="javascript:window.location.href='{{ url('/snapshots/upload') }}'">Upload Snapshot</button>
                    </div>


              </div>

              <div class="card-body">

               @if (Session::has('message'))

                     <div class="alert alert-info">{!! session('message') !!}</div>

               @endif

                <form action="{{ url('snapshots/create') }}" method="POST" accept-charset="utf-8">

                @csrf

                  <div class="form-group">
                        <label class="form-label">Server</label>
                        <select name="subid" id="select-beast" class="form-control custom-select">

                          @forelse ( $servers as $server)

                              <option value="{{ $server['SUBID'] }}">{{ $server['ram'] }} - {{ $server['main_ip'] }}</option>

                          @empty

                            <div class="alert alert-info">No servers</div>

                          @endforelse

                        </select>
                      </div>
                      <div class="form-group">
                      <label class="form-label">Label</label>
                      <input type="text" name="snapshot_label" class="form-control" placeholder="Snapshot Label">
                    </div>
                    <div class="form-group">
                      <input type="submit" class="btn btn-primary btn-lg btn-block" value="Take Snapshot" onclick="this.disabled = true;this.value = 'Please wait...'">
                    </div>

                </form>
              </div>
            </div>
         </div>
      </div>

@endsection