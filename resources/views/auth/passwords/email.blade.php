@include('partials.head')

<div id="vultr-wp-dashboard">
  
  <div class="container">

    <div class="row">
      <div class="col col-login mx-auto">
        <div class="card">
          <div class="card-body">

      <div class="authentication-form">

        @if (session('status'))
            {{-- <div class="alert alert-success">
                {{ session('status') }}
            </div> --}}

            @alert([ 'type' => 'success'])
              {!! session( 'status' ) !!}
            @endalert

        @endif

        <form method="POST" action="{{ url('/password/email') }}">

          @csrf

          <div class="form-group">
            <label class="form-label">

                {{ __("Your email address") }}

              </label>

                <input type="text" id="email" name="email" placeholder="Email" class="form-control" autofocus required/>
                @if ( $errors->has('email') )

            <div class="alert alert-warning" style="margin-top: 10px;">{{ $errors->first('email') }}</div>
          @endif
          </div>

          <div class="form-group">
          <input class="button btn-block" type="submit" value="Send Password Reset Link"/>

        </div>

          {{-- <ul class="list-inline">
            <li class="list-inline-item"><a href="{{ url('/login') }}">Login</a></li>
            <li class="list-inline-item"><a href="{{ url('/register') }}">Register</a></li>
          </ul> --}}
          
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
