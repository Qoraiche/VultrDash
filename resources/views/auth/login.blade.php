@include('partials.head')

<div id="vultr-wp-dashboard">

  <div class="container">

    <div class="row">
      <div class="col col-login mx-auto">
        <div class="card">
          <div class="card-body">

      <div class="authentication-form">

        <div class="d-flex justify-content-center mb-7">
          <img src="{{ asset('vultron-icon.png') }}" class="header-brand-img" style="height: 3rem;" alt="Vultr">
        </div>

        @if ( Session::has('message') )
 
            <div class="alert alert-info">{!! session( 'message' ) !!}</div>

        @endif

        <form method="POST" action="{{ url('/login') }}">
          @csrf

          <div class="form-group">
                <input type="email" id="email" name="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" autofocus required/>
                @if ($errors->has('email'))
                    <div class="invalid-feedback" style="margin-top: 10px;">{{ $errors->first('email') }}</div>

                @endif

          </div>

          <div class="form-group">
              <label class="form-label">
                
                <a href="{{ url('/password/reset') }}" class="float-right small">I forgot password</a>
                
              </label>

              <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" placeholder="Password" type="password" name="password">

              @if ($errors->has('password'))

                <div class="invalid-feedback" style="margin-top: 10px;">{{ $errors->first('password') }}</div>

              @endif


          </div>

          <div class="form-group">
          <div class="col-md-6 col-md-offset-4">
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="remember">
                    <span class="custom-control-label">Remember Me</span>
                </label>
            </div>
          </div>

          <div class="form-group">
          <input class="button btn-block" type="submit" value="Login"/>
        </div>
          
          {{-- <ul class="list-inline">
            <li class="list-inline-item">Forgot your passowrd ?</li>
            <li class="list-inline-item"><a href="{{ url('/password/reset') }}">Reset Password</a></li>
          </ul> --}}
          
        </form>

      </div>

  </div>
</div>

<div class="text-center text-muted">
  {{ __("Don't have account yet?") }} <a href="{{ url('/register') }}">Sign up</a>
</div>

</div>

</div>

</div>

</div>
