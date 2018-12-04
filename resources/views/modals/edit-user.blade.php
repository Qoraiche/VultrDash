@extends('dashboard')

@section('title', 'Edit user')

@section('content')


<div class="page-header">
    <h1 class="page-title">
      <a class="icon back-previous" href="{{ url('/users') }}"><i class="fe fe-arrow-left-circle"></i></a>
        Edit User
    </h1>
</div>

<div class="container">

  <div class="row">

    <div class="col-md-6">

    <form class="card create-user" method="POST" action="{{ url('/users/'. $user->id) }}">
      @method('PUT')
      @csrf

      <div class="card-status bg-blue"></div>
        <div class="card-header">
            <h3 class="card-title">Edit infos</h3>
        </div>

    <div class="card-body">

      @if ( Session::has('status') )
            {{-- <div class="alert alert-success"><i class="fe fe-check mr-2" aria-hidden="true"></i> {!! session( 'status' ) !!}</div> --}}

            @alert([ 'type' => 'success'])
              {!! session('status') !!}
            @endalert

      @endif

      @if ( Session::has('warning') )
           {{--  <div class="alert alert-warning"><i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i> {!! session( 'warning' ) !!}</div> --}}

            @alert([ 'type' => 'warning'])
              {!! session('warning') !!}
            @endalert

      @endif


      <div class="row">

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

        <div class="col-md-12">

          <div class="form-group">
            <label class="form-label">Role</label>
            <select name="role" id="select-role" class="form-control custom-select">

                  <option value="super-admin"@if ( $user->hasRole('super-admin') ){!! ' selected=""'!!} @endif>Super Admin</option>

                  @if ( !Auth::user()->is($user) )

                  <option value="assign-permission" @if ( !$user->hasRole('super-admin') ){!!' selected=""'!!}@endif>Custom Permissions</option>

                  @endif
      
            </select>
          </div>

        </div>

        <div class="col-md-12 permissions" style="display: none;">
          <div class="form-group">
            <label class="form-label">Permissions</label>

            <div class="invalid-feedback invalid-permission" style="margin-top: 10px;"></div>
            <div class="selectgroup selectgroup-pills permissions-list">

              @foreach( $permissionsList as $permission )

              <label class="selectgroup-item">

              <input type="checkbox" name="permissions[{{ $permission->name }}]" class="selectgroup-input" {{ $user->hasPermissionTo($permission->name) ? 'checked=""' : ''}}>
                      <span class="selectgroup-button">{{ ucwords( $permission->name ) }}</span>

              </label>

                
              @endforeach

            </div>
          </div>
        </div>

      </div>
    </div>
    
    <div class="card-footer text-right">
      <input type="submit" class="btn btn-primary" value="Update">
    </div>

  </form>

  </div>


  <div class="col-md-6">

    <form class="card create-user" method="POST" action="{{ url('/users/'. $user->id) }}">
      @method('PUT')
      @csrf

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

        <div class="col-md-12">
          <div class="form-group">
            <div class="custom-controls-stacked">
              <label class="custom-control custom-checkbox">
                <input class="custom-control-input" name="notify-user" type="checkbox">
                <span class="custom-control-label">Send the user an email about their their account</span>
              </label>
            </div>
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

</div>

<script>

      require(['jquery', 'selectize'], function ($, selectize) {
          $(document).ready(function () {

            $('.create-user').submit(function(e){

              if ( $('select[name="role"]').val() == 'assign-permission' && $('input:checked[name^="permissions"]').length < 1 ) {
                          e.preventDefault();

                          $('.invalid-permission').text('Select at least one permission');
                          $('.invalid-permission').show();
                      }
            });



            if ( $('#select-role').val() == 'assign-permission' ){
              $('.permissions').show();
            }

            $('#select-role').selectize( {} );

            $('#select-role').on('change', function(){

               if ( $(this).val() == 'assign-permission' ){

                  return $('.permissions').slideDown();

               }

                return $('.permissions').slideUp();

            });

          });
      });

</script>


@endsection
