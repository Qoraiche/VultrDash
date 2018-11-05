<div class="header py-4">
          <div class="container">
            <div class="d-flex">
              <a class="header-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/vultron.png') }}" class="header-brand-img" alt="Vultr">
              </a>
              <div class="d-flex order-lg-2 ml-auto">
                <div class="d-flex position-relative">
                  <a href="{{ route('account.index', '#messages') }}" class="nav-link icon">
                    <i class="fe fe-mail"></i>
                    @if ( Auth::user()::find( Auth::id() )->unreadMessagesCount() > 0 )
                      <span class="nav-unread"></span>
                    @endif
                  </a>
                </div>
                
                <div class="dropdown">
                  <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                    <span class="avatar" style="background-image: url({{ Gravatar::src( Auth::user()->email ) }})"></span>

                    <span class="ml-2 d-none d-lg-block">
                      <span class="text-default">
                        {{ Auth::user()->slug() }}
                      </span>

                      <small class="text-muted d-block mt-1">{{ Auth::user()->hasRole('super-admin') ? 'Administrator' : 'Editor' }}</small>

                    </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a class="dropdown-item" href="{{ url('/account') }}">
                      <i class="dropdown-icon fe fe-user"></i> Account
                    </a>

                    <a class="dropdown-item" href="{{ url('/account#messages') }}">
                      <span class="float-right">
                        <span class="badge badge-primary">
                        {{ Auth::user()::find( Auth::id() )->unreadMessagesCount() }}
                      </span>
                    </span>
                      <i class="dropdown-icon fe fe-mail"></i> Messages
                    </a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="https://github.com/Qoraiche/VultrOn/issues" target="_blank">
                      <i class="dropdown-icon fe fe-help-circle"></i> Need help?
                    </a>
                    <a class="dropdown-item" href="{{ url('/logout') }}">
                      <i class="dropdown-icon fe fe-log-out"></i> Sign out
                    </a>
                  </div>
                  
                </div>
              </div>

              <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
              </a>
            </div>
          </div>
        </div>
