<div class="row">

    <div class="col-md-6">

    <form class="card create-user" method="POST" action="{{ url('/users/'. $user->id) }}">
      @method('PUT')
      @csrf
      <input name="edit_account" value="true" type="hidden">

      <div class="card-status bg-blue"></div>

      <div class="card-header">
          <h3 class="card-title">Edit infos</h3>
      </div>

    <div class="card-body">

      @if ( Session::has('status') )

            <div class="alert alert-success"><i class="fe fe-check mr-2" aria-hidden="true"></i> {!! session( 'status' ) !!}</div>

      @endif

      @if ( Session::has('warning') )

            <div class="alert alert-warning"><i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i> {!! session( 'warning' ) !!}</div>

      @endif
      
      <div class="row">

        <div class="col-auto">
          <span class="avatar avatar-xl" style="background-image: url({{ Gravatar::src( $user->email ) }})"></span>
          <p class="mt-2"><a href="//gravatar.com/" target="_blank">{{ __('Edit avatar') }}</a></p>
        </div>

        <div class="col">
          <div class="form-group">
            <label class="form-label">Role</label>
            <div class="form-control-plaintext d-inline badge badge-{{ $user->hasRole('super-admin') ? 'primary' : 'secondary' }}">{{ $user->hasRole('super-admin') ? 'Administrator' : 'Editor' }}</div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
            <label class="form-label">First Name</label>
            <input class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}" name="firstname" type="text" value="{{ $user->firstname }}">

            @if ($errors->has('firstname'))

              <div class="invalid-feedback" style="margin-top: 10px;">{{ $errors->first('firstname') }}</div>
              
            @endif

          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
            <label class="form-label">Last Name</label>
            <input class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" type="text" value="{{ $user->lastname }}">

            @if ($errors->has('lastname'))

              <div class="invalid-feedback" style="margin-top: 10px;">{{ $errors->first('lastname') }}</div>
              
            @endif

          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
            <label class="form-label">Country</label>
            <input class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}" name="country" type="text" value="{{ $user->country }}">

            @if ( $errors->has('country') )

              <div class="invalid-feedback" style="margin-top: 10px;">{{ $errors->first('country') }}</div>
              
            @endif

          </div>
        </div>

        <div class="col">
          <div class="form-group">
            <label class="form-label">Permissions 
              {{-- @hasrole('super-admin')
              <small><a href="{{ url("users/{$user->id}/edit") }}"><i class="fe fe-edit"></i> edit</a></small>
              @endhasrole --}}
            </label>

            @foreach( $user->getAllPermissions() as $permission )
            
            <span class="tag mb-2">{{ ucwords($permission->name) }}</span>

            @endforeach

          </div>
        </div>

      </div>
    </div>

    <div class="card-footer text-right">
      <input class="btn btn-primary" value="Update" type="submit">
    </div>

  </form>

  </div>


  <div class="col-md-6">

    <form class="card create-user" method="POST" action="{{ url('/users/'. $user->id) }}">
      @method('PUT')
      @csrf

      <input name="edit_account" value="true" type="hidden">
      <input type="hidden" name="pass_email" value="true">

      <div class="card-status bg-blue"></div>

      <div class="card-header">
          <h3 class="card-title">Edit Email/Password</h3>
      </div>

    <div class="card-body">

      @if ( Session::has('passemail_status') )

            <div class="alert alert-success"><i class="fe fe-check mr-2" aria-hidden="true"></i> {!! session( 'passemail_status' ) !!}</div>

      @endif

      @if ( Session::has('passemail_status_error') )

            <div class="alert alert-warning"><i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i> {!! session( 'passemail_status_error' ) !!}</div>

      @endif


      <div class="row">

        <div class="col-md-12">
          <div class="form-group">
            <label class="form-label">Email</label>
            <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" type="email" value="{{ $user->email }}">
            
            @if ($errors->has('email'))

              <div class="invalid-feedback" style="margin-top: 10px;">{{ $errors->first('email') }}</div>
              
            @endif

          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
            <label class="form-label">Password</label>
            <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" type="password">

            @if ($errors->has('password'))

              <div class="invalid-feedback" style="margin-top: 10px;">{{ $errors->first('password') }}</div>
              
            @endif

          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
            <label class="form-label">Confirm Password</label>
            <input class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" type="password">

            @if ($errors->has('password_confirmation'))

              <div class="invalid-feedback" style="margin-top: 10px;">{{ $errors->first('password_confirmation') }}</div>

            @endif

          </div>
        </div>

      </div>
    </div>
    <div class="card-footer text-right">
      <input type="submit" class="btn btn-primary" value="Update">
    </div>

  </form>

  </div>

</div>