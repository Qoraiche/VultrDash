<div class="col-md-6 col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Users</h3>
                    <div class="card-options">
                      <div class="btn-group">
                        <a href="{{ url('/users') }}" class="btn btn-secondary btn-sm">View users</a>
                        @hasrole('super-admin')
                        <a href="{{ url('users/create') }}" class="btn btn-secondary btn-sm">Add user</a>
                        @endhasrole
                      </div>
                    </div>
                  </div>
                  <div class="card-body o-auto" style="height: 15rem">
                  
                    <ul class="list-unstyled list-separated">

                    @foreach( $users as $user )

                      <li class="list-separated-item">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="avatar avatar-md d-block" style="background-image: url({{ Gravatar::src( $user->email ) }})"></span>
                          </div>
                          <div class="col">
                            <div>
                              <div class="text-inherit">{{ $user->slug() }}</div>
                            </div>
                            <small class="d-block item-except text-sm text-muted h-1x">{{ $user->email }}</small>
                          </div>
                          <div class="col-auto">

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

                          </div>
                        </div>
                      </li>

                    @endforeach

                    </ul>
                  </div>
                </div>
              </div>