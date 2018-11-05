@include('partials.head')

<div id="vultr-wp-dashboard">
  
  <div class="container">

    <div class="row">
      <div class="col col-login mx-auto">
        <div class="card">
          <div class="card-body">

      <div class="authentication-form">

        <div class="d-flex justify-content-center mb-5">
          <img src="{{ asset('vultron-icon.png') }}" class="header-brand-img" style="height: 3rem;" alt="Vultr">
        </div>
          
        </div>

        <!--<div class="message warning">Access Granted Successfully !</div>-->

        <form method="POST" action="{{ url('/register') }}">

          @csrf

          {{-- <div class="form-group">
                <input type="text" id="username" name="username" placeholder="Username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" value="{{ old('name') }}" autofocus required/>
                @if ($errors->has('username'))

                  <div class="invalid-feedback" style="margin-top: 10px;">{{ $errors->first('username') }}</div>

                @endif
          </div> --}}
          <div class="form-group">

            <label class="form-label">

                Email

              </label>

                <input type="email" id="email" name="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" required/>
                @if ($errors->has('email'))

                  <div class="invalid-feedback" style="margin-top: 10px;">{{ $errors->first('email') }}</div>
                @endif
          </div>
          <div class="form-group">

            <label class="form-label">

                Password

              </label>


                <input type="password" id="password" name="password" placeholder="Password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required/>
                @if ($errors->has('password'))

                  <div class="invalid-feedback" style="margin-top: 10px;">{{ $errors->first('password') }}</div>
                @endif
          </div>
          <div class="form-group">

            <label class="form-label">

                Confirm Password

              </label>


                <input type="password" id="password_confirm" name="password_confirmation" placeholder="Confirm Password" class="form-control{{ $errors->has('password_confirm') ? ' is-invalid' : '' }}" required/>
                @if ($errors->has('password_confirmation'))

                  <div class="invalid-feedback" style="margin-top: 10px;">{{ $errors->first('password_confirmation') }}</div>
                @endif
          </div>

          <div class="form-group">
          <input class="button btn-block" type="submit" value="Register"/>
        </div>
          
          {{-- <ul class="list-inline">
            <li class="list-inline-item">Already has an account?</li>
            <li class="list-inline-item"><a href="{{ url('/login') }}">Login</a></li>
          </ul> --}}

        </form>

      </div>

      </div>

      <div class="text-center text-muted">
        {{ __('Already have an account?') }} <a href="{{ url('/login') }}">Log In</a>
      </div>

  </div>
</div>

</div>

</div>

{{-- @include('partials.footer') --}}
