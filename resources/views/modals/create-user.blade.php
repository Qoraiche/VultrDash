@extends('dashboard')

@section('title', 'Create user')

@section('content')

<div class="page-header">
    <h1 class="page-title">
      <a class="icon back-previous" href="{{ url('/users') }}"><i class="fe fe-arrow-left-circle"></i></a>
        Add User
    </h1>
</div>


<div class="container">

  <div class="row">

    <div class="col-md-6 mx-auto">

    <form class="card create-user" method="POST" action="{{ route('users.store') }}">

      @csrf

      <div class="card-status bg-blue"></div>

    <div class="card-header">
        <h3 class="card-title">Add New User</h3>
    </div>

    <div class="card-body">
      <div class="row">

        <div class="col-md-12">
          <div class="form-group">
            <label class="form-label">First Name</label>
            <input class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}" name="firstname" type="text" value="{{ old('firstname') }}">

            @if ($errors->has('firstname'))

              <div class="invalid-feedback" style="margin-top: 10px;">{{ $errors->first('firstname') }}</div>
              
            @endif

          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
            <label class="form-label">Last Name</label>
            <input class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" type="text" value="{{ old('lastname') }}">

            @if ($errors->has('lastname'))

              <div class="invalid-feedback" style="margin-top: 10px;">{{ $errors->first('lastname') }}</div>
              
            @endif

          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
            <label class="form-label">Email</label>
            <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" type="email" value="{{ old('email') }}">
            
            @if ($errors->has('email'))

              <div class="invalid-feedback" style="margin-top: 10px;">{{ $errors->first('email') }}</div>
              
            @endif

          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
            <label class="form-label">Role</label>
            <select name="role" id="select-role" class="form-control custom-select">

              {{-- @if ( auth()->user()->hasRole('super-admin') )

              <option value="super-admin"@if ( old('role') === 'super-admin' ){!! ' selected=""'!!} @endif>Super Admin</option>

              @endif --}}

              <option value="super-admin"@if ( old('role') === 'super-admin' ){!! ' selected=""'!!} @endif>Super Admin</option>

              <option value="assign-permission"@if ( old('role') !== 'super-admin' ){!! ' selected=""'!!} @endif>Custom Permissions</option>
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
                  <input type="checkbox" name="permissions[{{ $permission->name }}]" class="selectgroup-input">
                  <span class="selectgroup-button">{{ ucwords( $permission->name ) }}</span>
                </label>

              @endforeach

            </div>
            
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

        {{-- <div class="col-md-12">
          <div class="form-group">
            <div class="custom-controls-stacked">
              <label class="custom-control custom-checkbox">
                <input class="custom-control-input" name="notify-user" type="checkbox">
                <span class="custom-control-label">Send the new user an email about their account</span>
              </label>
            </div>
          </div>
        </div> --}}

      </div>
    </div>
    <div class="card-footer text-right">
      <input type="submit" class="btn btn-primary" value="Create User">
    </div>

  </form>

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

  </div>

</div>

</div>



@endsection
