@include('partials.head')

<div id="vultr-wp-dashboard">
  
  <div class="container">

    <div class="row">
      <div class="col col-login mx-auto">
        <div class="card">
          <div class="card-body">

      <div class="authentication-form">

        <form method="POST" action="{{ url('/password/reset') }}">

          @csrf

          <input type="hidden" name="token" value="{{ $token }}">

          <div class="form-group">
            <label class="form-label">

                Email

              </label>

                <input type="email" id="email" name="email" placeholder="Email" class="form-control" value="{{ old('email') }}" required/>
                @if ($errors->has('email'))

                  {{-- <div class="alert alert-warning" style="margin-top: 10px;">{{ $errors->first('email') }}</div> --}}

                  @alert([ 'type' => 'warning'])
                    {{ $errors->first('email') }}
                  @endalert

                @endif
          </div>
          <div class="form-group">
            <label class="form-label">

                Password

              </label>

                <input type="password" id="password" name="password" placeholder="Password" class="form-control" required/>
                @if ($errors->has('password'))

                  {{-- <div class="alert alert-warning" style="margin-top: 10px;">{{ $errors->first('password') }}</div> --}}

                  @alert([ 'type' => 'warning'])
                    {{ $errors->first('password') }}
                  @endalert

                @endif
          </div>
          <div class="form-group">
            <label class="form-label">

                Confirm password

              </label>

                <input type="password" id="password_confirm" name="password_confirmation" placeholder="Confirm Password" class="form-control" required/>
                @if ($errors->has('password_confirmation'))

                  {{-- <div class="alert alert-warning" style="margin-top: 10px;">{{ $errors->first('password_confirmation') }}</div> --}}

                  @alert([ 'type' => 'warning'])
                    {{ $errors->first('password_confirmation') }}
                  @endalert

                @endif
          </div>

          <div class="form-group">
          <input class="button btn-block" type="submit" value="Recover Password"/>
        </div>
          
        </form>

      </div>

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
