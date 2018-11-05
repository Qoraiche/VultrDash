@extends('dashboard')

@section('title', 'Users')

@section('content')

<div id="users">

<div class="page-header">
    <h1 class="page-title">
      Users
    </h1>
</div>

  
<div class="row">

  <div class="col-lg-3 order-lg-1 mb-4">

    @hasrole('super-admin')
      <a href="{{ url('users/create') }}" class="btn btn-block btn-primary mb-6">
              New User
      </a>
    @endhasrole

  </div>

  <div class="col-lg-9">
    <div class="card">
      <div class="card-body">

  <div class="page-header">

    <div class="page-subtitle total-users">{{ count($usersList) <= 1 ? count($usersList).' '.str_singular('users') : count($usersList).' users' }}</div>

          <div class="page-options d-flex">

          <div class="input-icon ml-2">

                  <span class="input-icon-addon">
                    <i class="fe fe-search"></i>
                  </span>

                  <input class="search form-control w-10" placeholder="Search Users ..." type="text">
          </div>

          </div>

      </div>

  <div class="table-responsive">

    @if ( Session::has('status') )

            <div class="alert alert-success"><i class="fe fe-check mr-2" aria-hidden="true"></i> {!! session( 'status' ) !!}</div>

      @endif

      @if ( Session::has('warning') )

            <div class="alert alert-warning"><i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i> {!! session( 'warning' ) !!}</div>

      @endif


    <table class="table card-table table-striped table-vcenter">
      <thead>
        <tr>
          <th colspan="2">User</th>
          <th>Registration date</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody class="list">

      	@foreach( $usersList as $user )

        <tr>
          <td class="w-1 fullname">

                <span class="avatar" style="background-image: url({{ Gravatar::src( $user->email ) }})"></span>

        </td>
          <td class="name">

            <span class="ml-2">
                      <span class="text-default">
                        {{ $user->slug() }}
                      </span>
                      <small class="text-muted d-block mt-1">{{ $user->email }}</small>
                    </span>

          </td>
          
          <td class="text-nowrap">{{ $user->created_at->diffForHumans() }}</td>

          <td class="text-nowrap">
            @if ( $user->hasRole( 'super-admin' ) )

              <span class="tag tag-blue">{{ __('Administrator') }}</span>

            @endif

          </td>

          {{-- <td class="role">{{ $user->permissions }}</td> --}}
          <td>

            @hasrole('super-admin')

            <div class="user-action dropdown">

              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>

              <div class="dropdown-menu dropdown-menu-right">

                    <a href="{{ url('users/'. $user->id.'/edit') }}" class="dropdown-item"><i class="dropdown-icon fe fe-edit"></i>Edit User</a>

                <div class="dropdown-divider"></div>

                <form action="{{ url('users/'. $user->id) }}" method="post" accept-charset="utf-8">

                  @method('DELETE')
                  @csrf

                    <input type="hidden" name="userid" value="{{ $user->id }}">
                
                    <a href="javascript:void(0)" class="dropdown-item red delete-user"><i class="dropdown-icon red fe fe-trash-2"></i> Delete User</a>

              </form>
 
              </div>
            </div>

            @endhasrole

        </td>
        </tr>

        @endforeach
      </tbody>
    </table>
  </div>

  <ul class="pagination"></ul>

  {{-- {{ $usersList->links() }} --}}

</div>

</div>

</div>

</div>

</div>

<script type="text/javascript">

require([ 'core' ], function () {

  $(document).ready(function () {

    searchTable('users', true, 15, ['name' , 'email', 'role' ], '.total-users', 'user', 'users');

  });

});

</script>

@endsection
