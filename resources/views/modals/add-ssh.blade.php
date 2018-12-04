@extends('dashboard')

@section('title', 'Add SSH')

@section('content')

<div class="page-header">
    <h1 class="page-title">
      <a class="icon back-previous" href="{{ url('/sshkeys') }}"><i class="fe fe-arrow-left-circle"></i></a>
        Add SSH
    </h1>
</div>

      <div class="row">
          <div class="col-md-7 col-xl-6" style="margin:auto;">
              <div class="card">
              <div class="card-status bg-blue"></div>
              <div class="card-header">
                    <h3 class="card-title">SSH Key</h3>
              </div>
              <div class="card-body">

              @if (Session::has('message'))

                    {{-- <div class="alert alert-info">{!! session('message') !!}</div> --}}

                    @alert([ 'type' => 'info'])
                        {!! session('message') !!}
                     @endalert

              @endif

                <form action="{{ isset($sshkeyid) ? route('sshkeys.update') : route('sshkeys.create') }}" method="POST" accept-charset="utf-8">
                    @csrf

                    @if ( isset ($sshkeyid) )
                    <input type="hidden" name="sshkeyid" value="{{ $sshkeyid }}">
                    @endif

                    <div class="form-group">
                              <label class="form-label">Name</label>
                              <input class="form-control" name="name" placeholder="SSH Key name" type="text" value="{{ isset( $sshkeyid ) ? trim($sshkey[$sshkeyid]['name']) : '' }}">
                    </div>
                    
                    <div class="form-group">
                        <textarea rows="5" class="form-control" name="ssh_key" placeholder="ssh-rsa AAAA.... you@example.com">
                          {{ isset( $sshkeyid ) ? trim($sshkey[$sshkeyid]['ssh_key']) : '' }}
                        </textarea>
                    </div>

                    <div class="form-group">
                      <input type="submit" class="btn btn-primary btn-lg btn-block" value="{{ isset( $sshkeyid ) ? 'Update SSH Key' : 'Add SSH Key' }}" onclick="this.disabled = true;this.value = 'Please wait...'">
                    </div>

                </form>
              </div>
            </div>
         </div>
      </div>

@endsection