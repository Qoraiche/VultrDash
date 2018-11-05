@include('partials.head')

<div class="page">
      <div class="page-main">

        @include('partials.dash-header')
        @include('partials.dash-topmenu')
        
        <div class="my-3 my-md-5">
          <div class="container">

            @if ( Session::has('status') )

            <div class="card-alert alert alert-success mb-0">
                {!! session( 'status' ) !!}
            </div>

            @endif

            @if ( Session::has('error') )

                  <div class="card-alert alert alert-danger mb-0">
                      {!! session( 'error' ) !!}
                  </div>

            @endif

            
            <div class="page-header">
              <h1 class="page-title">
                Dashboard
              </h1>
            </div>
            
            <div class="row row-cards row-deck">

              <div class="col-sm-6 col-lg-2">
                    <div class="card">
                      <div class="card-body">
                        <div class="h2 mb-2">{{ count($servers) }}</div>
                        <div class="text-muted">Servers</div>
                      </div>
                    </div>
                    
                  </div>

                  <div class="col-sm-6 col-lg-2">
                    <div class="card">
                      <div class="card-body">
                        <div class="h2 mb-2">{{ $users->count() }}</div>
                        <div class="text-muted">Users</div>
                      </div>
                    </div>
                  </div>

                <div class="col-sm-6 col-lg-2">
                  <div class="card">
                    <div class="card-body">
                      <div class="h2 mb-2">{{ $activity_today->count() }}</div>
                      <div class="text-muted">Daily Activity</div>
                    </div>
                  </div>
                </div>

               <div class="col-sm-6 col-lg-2">
                    <div class="card">
                      <div class="card-body">
                        <div class="h2 mb-2">
                          @hasrole('super-admin')
                            <i class="fe fe-dollar-sign"></i>{{ $account->balance }}
                          @else
                          --  
                          @endhasrole
                        </div>
                        <div class="text-muted">Balance</div>
                      </div>

                    </div>
                </div>

                <div class="col-sm-6 col-lg-2">
                    <div class="card">
                      <div class="card-body">
                        <div class="h2 mb-2 text-red">
                          @hasrole('super-admin')
                            <i class="fe fe-dollar-sign"></i>{{ $account->pending_charges }}
                          @else
                          --  
                          @endhasrole
                        </div>
                        <div class="text-muted">Charges This Month</div>
                      </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-2">
                  <div class="card">
                    <div class="card-body">
                      <div class="h2 mb-2">
                        @hasrole('super-admin')
                        <i class="fe fe-dollar-sign"></i>{{ $account->last_payment_amount }}
                        @else
                        --
                        @endhasrole
                      </div>
                      <div class="text-muted">Last Payment Amount</div>
                    </div>
                  </div>
                </div>

              @include('partials.dash-servers')

              @include('partials.dash-activity-log')

              @include('partials.dash-users')

          </div>
        </div>
      </div>


    </div>

@include('partials.footer')