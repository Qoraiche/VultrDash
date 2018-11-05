@extends('dashboard')

@section('title', 'Add Domain')

@section('content')

<div class="page-header">
    <h1 class="page-title">
      <a class="icon back-previous" href="{{ url('/dns') }}"><i class="fe fe-arrow-left-circle"></i></a>
        Add Domain
    </h1>
</div>

      <div class="row">
          <div class="col-md-7 col-xl-6" style="margin:auto;">
              <div class="card">
              <div class="card-status bg-blue"></div>
              <div class="card-header">
                    <h3 class="card-title">Add Domain</h3>
              </div>
              <div class="card-body">

              @if (Session::has('message'))

                     <div class="alert alert-info">{!! session('message') !!}</div>

               @endif

               <form action="{{ route('dns.create') }}" method="POST" accept-charset="utf-8">
                @csrf
                    <div class="form-group">
                          <label class="form-label">Domain</label>
                          <input class="form-control" name="domain" placeholder="Domain Address" type="text">
                    </div>
                    <div class="form-group">
                          <label class="form-label">IP Address</label>
                          <input class="form-control" name="serverip" placeholder="Default IP Address" type="text">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Add Domain" onclick="this.disabled = true;this.value = 'Please wait...'">
                    </div>

               </form>

              </div>
            </div>
         </div>
      </div>

@endsection