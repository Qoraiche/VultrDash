@extends('modals.view-server')

@section('title', 'Manage server - DDOS')

@section('server-view-tab')

<div class="col-md-7 col-xl-6" style="margin:auto;">
  <div class="card">
  <div class="card-status bg-blue"></div>
  <div class="card-header">
        <h3 class="card-title">DDOS Protection</h3>
  </div>
  <div class="card-body">

  	<p>Enabling DDOS protection is an additional <strong>$10/month</strong>. This can take up to 5 minutes to take effect.</p>

  	<p style="margin-bottom: 2.2em;">DDOS Protection may interfere with custom DNS settings. Ensure your server is configured to use 108.61.10.10 for recursive DNS.</p>
  
   <form action="http://127.0.0.1:8000/dns/create" method="POST" accept-charset="utf-8">
        <div class="form-group">
            <input class="btn btn-primary btn-lg btn-block" value="Enable DDOS Protection" onclick="this.disabled = true;this.value = 'Please wait...'" type="submit">
        </div>

   </form>

  </div>
</div>
</div>

@endsection