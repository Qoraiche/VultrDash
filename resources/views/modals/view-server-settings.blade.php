@extends('modals.view-server')

@section('title', 'Manage Server - Settings')

@section('server-view-tab')

{{-- {{ dd($appInfo) }} --}}


<div class="row">

    <div class="col-3">
      <div class="nav vertical-nav flex-column nav-pills" id="settings-tab" role="tablist" aria-orientation="vertical">

        <a class="nav-link primary-vertical-link home active" id="firewall-setting-tab" data-toggle="pill" href="#firewall-setting" role="tab" aria-controls="firewall-setting-tab" aria-selected="true">Firewall</a>

        <a class="nav-link primary-vertical-link home" id="iso-setting-tab" data-toggle="pill" href="#iso-setting" role="tab" aria-controls="iso-setting-tab" aria-selected="false">Custom ISO</a>

{{--         <a class="nav-link home" id="hostname-setting-tab" data-toggle="pill" href="#hostname-setting" role="tab" aria-controls="hostname-setting-tab" aria-selected="false">Change Hostname</a> --}}

        <a class="nav-link primary-vertical-link home" id="label-setting-tab" data-toggle="pill" href="#label-setting" role="tab" aria-controls="label-setting-tab" aria-selected="false">Change Label/Tag</a>

        <a class="nav-link primary-vertical-link home" id="plan-setting-tab" data-toggle="pill" href="#plan-setting" role="tab" aria-controls="plan-setting-tab" aria-selected="false">Change Plan</a>

        <a class="nav-link primary-vertical-link home" id="os-setting-tab" data-toggle="pill" href="#os-setting" role="tab" aria-controls="os-setting-tab" aria-selected="false">Change OS</a>

        <a class="nav-link primary-vertical-link home" id="application-setting-tab" data-toggle="pill" href="#application-setting" role="tab" aria-controls="application-setting-tab" aria-selected="false">Change Application</a>

      </div>
    </div>

    <div class="col-9">
      <div class="tab-content" id="v-pills-tabContent">
          <div class="tab-pane fade show active" id="firewall-setting" role="tabpanel" aria-labelledby="firewall-setting-tab">
            <div class="col-md-10 col-lg-9 col-xl-7" style="margin:auto;">
              <div class="card">
              <div class="card-status bg-blue"></div>

              <div class="card-header">
                    <h3 class="card-title">Firewall</h3>

                    <div class="card-options">
                      <a href="{{ route('firewall.index') }}" target="_blank" class="btn btn-secondary btn-sm ml-2">
                        Manage
                      </a>
                    </div>

              </div>
              <div class="card-body">

                @if ( Session::has('firewall_message') )

                          <div class="alert alert-info">{!! session( 'firewall_message' ) !!}</div>

                    @endif

                    @if ( Session::has('firewall_error') )

                          <div class="alert alert-warning">{!! session( 'firewall_error' ) !!}</div>

                    @endif

              <form action="{{ url('servers/firewallgroupset') }}" method="POST" accept-charset="utf-8">

                @csrf
                <input type="hidden" name="serverid" value="{{ $serverid }}"> 

                  <div class="form-group">

                      <select name="firewallgroup" class="form-control custom-select">
                        <option value="0">No Firewall</option>
                        @forelse ($firewallList as $firewall)
                            <option value="{{ $firewall['FIREWALLGROUPID'] }}" {{ $firewall['FIREWALLGROUPID']  == $serverInfo->FIREWALLGROUPID ? 'selected' : '' }}>{{ $firewall['FIREWALLGROUPID']. ': '.$firewall['description']  }}</option>
                        @empty
                            

                        @endforelse
                      </select>
                  </div>

                  <div class="form-group">
                      <input class="btn btn-primary btn-lg btn-block" value="Update Firewall Group" onclick="this.disabled = true;this.value = 'Please wait...'" type="submit">
                  </div>

              </form>

              </div>
            </div>
            </div>

          </div>

          <div class="tab-pane fade" id="iso-setting" role="tabpanel" aria-labelledby="iso-setting-tab">
            <div class="col-md-10 col-lg-9 col-xl-7" style="margin:auto;">
              <div class="card">
              <div class="card-status bg-blue"></div>
              <div class="card-header">
                    <h3 class="card-title">Custom ISO</h3>

                    <div class="card-options">
                      <a href="{{ route('iso.index') }}" target="_blank" class="btn btn-secondary btn-sm ml-2">Upload/Manage</a>
                    </div>


              </div>
              <div class="card-body">

                  @if ( Session::has('iso_message') )

                          <div class="alert alert-info">{!! session( 'iso_message' ) !!}</div>

                    @endif

                    @if ( Session::has('iso_error') )

                          <div class="alert alert-warning">{!! session( 'iso_error' ) !!}</div>

                    @endif

                    @if ( $isoStatus->state == 'isomounted' )

                      @if ( $isoStatus->ISOID != "0" )

                        <p>Current ISO: {{ $isoList[$isoStatus->ISOID]['filename']  }}</p>

                      @endif

                    <form action="{{ url('servers/isodetach') }}" method="POST" accept-charset="utf-8">

                      @csrf
                      <input type="hidden" name="serverid" value="{{ $serverid }}">

                        <div class="form-group">

                            <input class="btn btn-primary btn-lg btn-block" value="Remove ISO" onclick="this.disabled = true;this.value = 'Please wait...'" type="submit">
                        </div>

                    </form>

                      <p><strong>Note:</strong> Your server was originally deployed using one of our installers. If you reinstall the operating system via a custom ISO, the root password in your control panel will no longer be valid.</p>

                    @else

                    <form action="{{ url('servers/isoattach') }}" method="POST" accept-charset="utf-8">

                      @csrf
                      <input type="hidden" name="serverid" value="{{ $serverid }}">

                    <label class="form-label">Custom ISO</label>
                      <div class="form-group">
                            <select name="customiso" class="form-control custom-select">
                              @forelse ($isoList as $iso)
                                    <option value="{{ $iso['ISOID'] }}">{{ $iso['filename'] }}</option>
                                @empty
                                    <option disabled selected>No ISO's</option>
                                @endforelse
                            </select>
                        </div>

                        <div class="form-group">

                            <input class="btn btn-primary btn-lg btn-block" value="Attach ISO and Reboot" onclick="this.disabled = true;this.value = 'Please wait...'" type="submit">
                        </div>

                    </form>

                    <form action="{{ url('servers/isoattach') }}" method="POST" accept-charset="utf-8">

                      @csrf
                      <input type="hidden" name="serverid" value="{{ $serverid }}">

                    <label class="form-label">ISO Library</label>
                      <div class="form-group">
                          <select name="customiso" class="form-control custom-select">
                              @forelse ($isoLibrary as $iso)
                                  <option value="{{ $iso['ISOID'] }}">{{ $iso['name'] }}</option>
                              @empty
                                  <option disabled selected>No ISO Libraries</option>

                              @endforelse
                          </select>
                      </div>

                        <div class="form-group">
                            <input class="btn btn-primary btn-lg btn-block" value="Attach ISO and Reboot" onclick="this.disabled = true;this.value = 'Please wait...'" type="submit">
                        </div>

                    </form>

                    @endif

              </div>
            </div>
            </div>
        </div>

        {{-- <div class="tab-pane fade" id="hostname-setting" role="tabpanel" aria-labelledby="hostname-setting-tab">
          <div class="col-md-10 col-lg-9 col-xl-7" style="margin:auto;">
            <div class="card">
            <div class="card-status bg-blue"></div>

            <div class="card-header">
                  <h3 class="card-title">Change Default Hostname</h3>
            </div>

            <div class="card-body">

              <p><strong>Warning:</strong> Reinstalling the operating system will wipe all the data on your server. </p>

               <form action="" method="POST" accept-charset="utf-8">
                @csrf

                <label class="form-label">Hostname</label>
                  <div class="form-group">
                        <input type="text" name="hostname" class="form-control" value="">
                    </div>

                    <div class="form-group">
                        <input class="btn btn-primary btn-lg btn-block" value="Reinstall" onclick="this.disabled = true;this.value = 'Please wait...'" type="submit">
                    </div>

                </form>
                
            </div>
          </div>
          </div>
        </div> --}}

        <div class="tab-pane fade" id="label-setting" role="tabpanel" aria-labelledby="label-setting-tab">
          <div class="col-md-10 col-lg-9 col-xl-7" style="margin:auto;">
            <div class="card">
            <div class="card-status bg-blue"></div>

            <div class="card-header">
                  <h3 class="card-title">Change Label/Tag</h3>
            </div>

            <div class="card-body">

              @if ( Session::has('label_tag_message') )

                          <div class="alert alert-info">{!! session( 'label_tag_message' ) !!}</div>

                    @endif

                    @if ( Session::has('label_tag_error') )

                          <div class="alert alert-warning">{!! session( 'label_tag_error' ) !!}</div>

                    @endif
              
               <form action="{{ url('servers/labelset') }}" method="POST" accept-charset="utf-8">
                  @csrf
                  <input type="hidden" name="serverid" value="{{ $serverid }}">

                <label class="form-label">Label</label>
                  <div class="form-group">
                        <input type="text" name="label" class="form-control" value="{{ $serverInfo->label }}">
                    </div>

                    <div class="form-group">
                        <input class="btn btn-primary btn-lg btn-block" value="Update" onclick="this.disabled = true;this.value = 'Please wait...'" type="submit">
                    </div>

                </form>


                <form action="{{ url('servers/tagset') }}" method="POST" accept-charset="utf-8">
                  @csrf
                  <input type="hidden" name="serverid" value="{{ $serverid }}">

                <label class="form-label">Tag</label>
                  <div class="form-group">
                        <input type="text" name="tag" class="form-control" value="{{ $serverInfo->tag }}">
                    </div>

                    <div class="form-group">
                      <input class="btn btn-primary btn-lg btn-block" value="Update" onclick="this.disabled = true;this.value = 'Please wait...'" type="submit">
                    </div>

                </form>
                
            </div>
          </div>
          </div>
        </div>

        <div class="tab-pane fade" id="plan-setting" role="tabpanel" aria-labelledby="plan-setting-tab">
          <div class="col-md-10 col-lg-9 col-xl-7" style="margin:auto;">
              <div class="card">
              <div class="card-status bg-blue"></div>

              <div class="card-header">
                    <h3 class="card-title">Change Plan</h3>
              </div>
              <div class="card-body">

                @if ( Session::has('plan_message') )

                          <div class="alert alert-info">{!! session( 'message' ) !!}</div>

                    @endif

                    @if ( Session::has('plan_error') )

                          <div class="alert alert-warning">{!! session( 'error' ) !!}</div>

                    @endif

                <p><strong>Note:</strong> Downgrading is currently not supported. Shrinking the hard disk is not possible without risking data loss. </p>
              
              <form action="{{ url('servers/upgradeplan') }}" method="POST" accept-charset="utf-8">
                @csrf
                <input type="hidden" name="serverid" value="{{ $serverid }}">

                  <div class="form-group">
                      <select name="vpsplan" class="form-control custom-select">
                        @forelse ($serverUpgradelist as $plan)
                            <option value="{{ $plan['VPSPLANID'] }}">{{ $plan['name'] }}</option>
                        @empty
                            <option selected disabled>No Plans</option>
                        @endforelse

                      </select>
                  </div>

                  <div class="form-group">
                      <input class="btn btn-primary btn-lg btn-block" value="Upgrade" onclick="this.disabled = true;this.value = 'Please wait...'" type="submit">
                  </div>
              </form>

              </div>
            </div>
            </div>
        </div>

        <div class="tab-pane fade" id="os-setting" role="tabpanel" aria-labelledby="os-setting-tab">
          <div class="col-md-10 col-lg-9 col-xl-7" style="margin:auto;">
              <div class="card">
              <div class="card-status bg-blue"></div>

              <div class="card-header">
                    <h3 class="card-title">Change OS</h3>
              </div>
              <div class="card-body">


                @if ( Session::has('os_message') )

                          <div class="alert alert-info">{!! session( 'os_message' ) !!}</div>

                    @endif

                    @if ( Session::has('os_error') )

                          <div class="alert alert-warning">{!! session( 'os_error' ) !!}</div>

                    @endif

                <p><strong>Warning:</strong> Changing to a different operating system will wipe all the data on your server.</p>

              
              <form action="{{ url('servers/oschange') }}" method="POST" accept-charset="utf-8">
                @csrf
                <input type="hidden" name="serverid" value="{{ $serverid }}">

                  <div class="form-group">
                      <select name="osid" class="form-control custom-select">
                         @forelse ($osChangeList as $os)
                            <option value="{{ $os['OSID'] }}">{{ $os['name'] }}</option>
                        @empty
                            <option selected disabled>No OS</option>

                        @endforelse
                      </select>
                  </div>

                  <div class="form-group">
                      <input class="btn btn-danger btn-lg btn-block" value="Change OS" onclick="this.disabled = true;this.value = 'Please wait...'" type="submit">
                  </div>
              </form>
              
              </div>
            </div>
            </div>

        </div>

        <div class="tab-pane fade" id="application-setting" role="tabpanel" aria-labelledby="application-setting-tab"><div class="col-md-10 col-lg-9 col-xl-7" style="margin:auto;">
              <div class="card">
              <div class="card-status bg-blue"></div>

              <div class="card-header">
                    <h3 class="card-title">New Application</h3>
              </div>

              <div class="card-body">


                @if ( Session::has('application_message') )

                          <div class="alert alert-info">{!! session( 'application_message' ) !!}</div>

                    @endif

                    @if ( Session::has('application_error') )

                          <div class="alert alert-warning">{!! session( 'application_error' ) !!}</div>

                    @endif

              <p><strong>Warning:</strong> Changing to a different application will wipe all the data on your server.</p>
              
              <form action="{{ url('servers/appchange') }}" method="POST" accept-charset="utf-8">
                @csrf
                <input type="hidden" name="serverid" value="{{ $serverid }}">

                  <div class="form-group">
                      <select name="application" class="form-control custom-select">
                        @forelse ($appChangeList as $app)
                                  <option value="{{ $app['APPID'] }}">{{ $app['deploy_name'] }}</option>
                              @empty
                                  <option selected disabled>No Applications</option>
                              @endforelse
                      </select>
                  </div>

                  <div class="form-group">
                      <input class="btn btn-danger btn-lg btn-block" value="Change Application" onclick="this.disabled = true;this.value = 'Please wait...'" type="submit">
                  </div>
              </form>

              </div>
            </div>
            </div>
          </div>
          
      </div>
    </div>

  </div>
    </div>
  </div>

<script type="text/javascript">

        require([ 'jquery', 'bootstrap', 'selectize' ], function ($, selectize) {
            
            $(document).ready(function () {

              // $('#select').selectize({});

              let url = location.href.replace(/\/$/, "");
 
              if (location.hash) {

                const hash = url.split("#");

                $('#settings-tab a[href="#'+hash[1]+'"]').tab("show");

                url = location.href.replace(/\/#/, "#");
                history.replaceState(null, null, url);

                setTimeout(() => {

                  $(window).scrollTop(0);

                }, 400);

              } 
               
              $('a[data-toggle="pill"]').on("click", function() {

                let newUrl;

                const hash = $(this).attr("href");

                if(hash == "#firewall-setting") {
                  
                  newUrl = url.split("#")[0];

                } else {

                  newUrl = url.split("#")[0] + hash;
                }

                newUrl += "/";

                history.replaceState(null, null, newUrl);

              });

            });

        });

      </script>

@endsection