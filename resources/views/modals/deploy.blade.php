@extends('dashboard')

@section('title', 'Deploy server')

@section('content')

<style type="text/css" media="screen">
.form-label {
    display: block;
    margin-bottom: 0.875rem;
    font-weight: 600;
    font-size: 0.875rem;
}
</style>

<div class="page-header">
    <h1 class="page-title">
      <a class="icon back-previous" href="{{ url('/servers') }}"><i class="fe fe-arrow-left-circle"></i></a>
        Deploy
    </h1>
</div>

<div class="row">

    <div class="col-md-3 col-sm-12">

        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

            <a class="nav-link primary-vertical-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Vultr Cloud Compute (VC2)</a>

            {{-- <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a> --}}

        </div>
    </div>

    <div class="col-md-9 col-sm-12">

        <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                <div class="card deploy-form">
                    <div class="card-header">
                        <h3 class="card-title">Deploy SSD VC2 Instance</h3>
                        <div class="card-options"></div>
                    </div>
                    <div class="card-body">
                        <div class="dimmer deploy-vc2">
                            <div class="loader"></div>
                            <div class="dimmer-content">

                              <form action="{{route('servers.create')}}" method="POST" name="vc2_deploy" accept-charset="utf-8">

                               @csrf

                               {{-- <input type="hidden" name="deploy_quantity" value="3"> --}}

                                <div class="row">

                                  <div class="col-lg-12">

                                  @if (Session::has('message'))

                                      <div class="alert alert-warning">{!! session('message') !!}</div>

                                  @endif

                                 </div>
                                
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Server Location</label>
                                            <select name="dcid" id="regions" class="form-control custom-select">
                                              @forelse ( $regions->list() as $region )
                                        <option value="{{ $region['DCID'] }}" data-data='{"image": "{{ asset( 'images/flags/'.strtolower($region['country'].'.svg') ) }}"}'>{{ $region['country'] }} - {{ $region['name'] }}</option>
                                              @empty
                                                Regions not found
                                              @endforelse
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Server Type</label>
                                            <select name="servertype" id="server-type" class="form-control custom-select">
                                              @forelse ( $oss->list() as $os )
                                                @if ( strtolower($os['name']) == 'custom' || strtolower($os['name']) == 'backup' )

                                                  @continue

                                                @endif
                                                <option value="{{ $os['OSID'] }}" data-type-family='{{ strtolower($os['family']) }}' data-data='{"image":"{{ asset( 'images/'.$oss->getServerOSImage($os['family']) ) }}"}' {!! $loop->last ? 'selected="selected"' : null !!}>{{ $os['name'] }}</option>
                                              @empty
                                                OS not found
                                              @endforelse
                                            </select>
                                        </div>
                                    </div>


                                

                                <div class="col-lg-6 col-sm-12">
                                  <div class="form-group">
                                  <div class="form-label">Server Size</div>
                                  <div class="custom-controls-stacked">
                                    @forelse ( $plans->list('vc2') as $plan )
                                    <label class="custom-control custom-radio">
                                      <input type="radio" class="custom-control-input" name="serversize" value="{{ $plan['VPSPLANID'] }}" {{ $loop->first ? 'checked' : null}}>
                                      <span class="custom-control-label">${{ $plan['price_per_month'] }} - {{ $plan['name'] }}</span>
                                    </label>
                                    @empty
                                       No instances found !
                                    @endforelse
                                  </div>
                                </div>
                              </div>

                              <div class="col-lg-6 app-list" style="display:none;">
                                        <div class="form-group">
                                            <label class="form-label">Select Application</label>
                                            <select name="appid" id="server-app" class="form-control custom-select">
                                              @forelse ( array_reverse($apps->list()) as $app )
                                                <option value="{{ $app['APPID'] }}" data-data='{"image":"{{ asset( 'images/'.$apps->getServerAppImage($app['short_name']) ) }}"}' {!! $loop->last ? 'selected="selected"' : null !!}>{{ $app['deploy_name'] }}</option>
                                              @empty
                                                OS not found
                                              @endforelse
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 snapshot-list" style="display:none;">
                                        <div class="form-group">
                                            <label class="form-label">Select Snapshot</label>
                                            <select name="snapshotid" id="server-snapshot" class="form-control custom-select">

                                              <option>Select Snapshot</option>

                                              @forelse ( $snapshots->list() as $snapshot )
                                              
                                              @if ($snapshot['status'] != 'complete')
                                                  @continue
                                                @endif

                                                <option value="{{ $snapshot['SNAPSHOTID'] }}">{{ $snapshot['description'] }}</option>
                                              @empty
                                                <option disabled>No snapshots found</option>
                                              @endforelse
                                            </select>
                                        </div>
                                    </div>

{{--                                     <div class="col-lg-6 backup-list" style="display:none;">
                                        <div class="form-group">
                                            <label class="form-label">Select Backup</label>
                                            <select name="backupid" id="server-backup" class="form-control custom-select">

                                              <option>Select Backup</option>

                                              @forelse ( $backups->list() as $backup )

                                                @if ($backup['status'] != 'complete')
                                                  @continue
                                                @endif

                                                <option value="{{ $backup['BACKUPID'] }}">{{ $backup['description'] }}</option>
                                              @empty
                                                <option disabled>No backups found</option>
                                              @endforelse
                                            </select>
                                        </div>
                                    </div> --}}

                              <div class="col-lg-6 col-sm-12">

                              <div class="form-group">
                                <div class="form-label">Additional Features</div>
                                <div class="custom-controls-stacked">
                                  <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="enable_ipv6" value="yes" checked>
                                    <span class="custom-control-label">Enable IPv6</span>
                                  </label>
                                  <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="auto_backups" value="yes">
                                    <span class="custom-control-label">Enable Auto Backups <span class="tag tag-azure">$2.00/mo</span></span>
                                  </label>
                                  <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="ddos_protection" value="yes">
                                    <span class="custom-control-label">Enable DDOS Protection</span>
                                  </label>
                                  <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="enable_private_network" value="yes">
                                    <span class="custom-control-label">Enable Private Networking</span>
                                  </label>
                                </div>
                              </div>

                            

                              </div>

                              {{-- <div class="col-lg-6 col-sm-12">

                              <div class="form-group">
                                <label class="form-label">Startup Script</label>
                                    <select name="startupscript" id="select-startupscript" class="form-control custom-select">
                                      <option value="">Select Startup script</option>
                                      @forelse ( $startupscripts as $script )
                                        <option value="{{ $script['SCRIPTID'] }}">{{ $script['name'] }}</option>
                                        @empty
                                       <option disabled>No startup scripts found</option>
                                    @endforelse
                                    </select>
                                    <small class="d-block text-muted">Select startup script or leave it blank, <a href="{{ route('startup.add') }}" target="_blank">Add new startup script</a></small>
                              </div>

                              </div> --}}

                              <div class="col-lg-6 col-sm-12">

                              <div class="form-group">
                                    <label class="form-label">SSH Keys</label>
                                    <select name="sshkeys" id="select-sshkeys" class="form-control custom-select">
                                      <option value="">Select SSH key</option>
                                    @forelse ( $sshkeys as $sshkey )
                                        <option value="{{ $sshkey['SSHKEYID'] }}">{{ $sshkey['name'] }}</option>
                                    @empty
                                       <option disabled>No SSH keys found</option>
                                    @endforelse
                                    </select>
                                    <small class="d-block text-muted">Select SSH Key or leave it blank, <a href="{{ route('sshkeys.add') }}" target="_blank">Add new ssh key</a></small>
                                    
                                </div>

                              </div>

                              <div class="col-lg-6 col-sm-12">
                              <div class="form-group">
                                    <label class="form-label">Server Hostname</label>
                                    <input class="form-control" id="server-hostname" name="serverhostname" placeholder="Enter server hostname" type="text">
                                </div>
                              </div>


                              <div class="col-lg-6 col-sm-12">
                              <div class="form-group">
                                    <label class="form-label">Label</label>
                                    <input class="form-control" id="server-label" name="serverlabel" placeholder="Enter server label" type="text">
                                </div>
                              </div>

                              <div class="col-lg-6 col-sm-12">
                              <div class="form-group">
                                    <label class="form-label">Tag</label>
                                    <input class="form-control" id="server-label" name="servertag" placeholder="The tag to assign to this server" type="text">
                                </div>
                              </div>

                              <div class="col-lg-6 col-sm-12">
                              <div class="form-group">
                                    <label class="form-label">Firewall Group</label>
                                    <select name="firewallgroupid" id="select-sshkeys" class="form-control custom-select">
                                      <option>Select Firewall Group</option>
                                    @forelse ( $firewalls as $firewall )
                                        <option value="{{ $firewall['FIREWALLGROUPID'] }}">{{ $firewall['description'] }}</option>
                                    @empty
                                       <option disabled>No Firewall groups found</option>
                                    @endforelse
                                    </select>
                                </div>
                              </div>

                            </div>

                          </form>


                            
                            </div>
                        </div>
                    </div>

                  <div class="card-footer">

                  <button class="button float-right" onclick="document.forms['vc2_deploy'].submit();$(this).addClass('btn-loading');">Deploy</button>

                  </div>

                </div>
            </div>

           {{--  <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">...</div> --}}

        </div>
    </div>
</div>
<script type="text/javascript">
require(['jquery', 'selectize'], function($, selectize) {

    $(document).ready(function() {

      setServerType( $('select#server-type').val() );


      function setServerType( type ){

        if (type == 186) {

          $('.snapshot-list').fadeOut();
          $('.app-list').fadeIn();
          $('.backup-list').fadeOut();

        } else if( type == 180 ) {

          $('.snapshot-list').fadeOut();
          $('.app-list').fadeOut();
          $('.backup-list').fadeIn();

        } else if( type == 164 ) {

          $('.snapshot-list').fadeIn();
          $('.app-list').fadeOut();
          $('.backup-list').fadeOut();

        } else {

          $('.snapshot-list').fadeOut();
          $('.app-list').fadeOut();
          $('.backup-list').fadeOut();

        }

      }

      $('select#server-type').on('change', function(){

        var serverType = $( this );

        setServerType( serverType.val() );

       });

        var assetBase = "{{ asset('images/') }}";

        function loadDeploy(deployType = 'vc2', dcid = 1, type = 'all', listtype = '') {

          // $('.deploy-vc2').addClass('active');

        }

        $('#regions, #server-type, #server-app').selectize({
                            render: {
                                option: function (data, escape) {
                                    return '<div>' +
                                        '<span class="image"><img src="' + data.image + '" alt=""></span>' +
                                        '<span class="title">' + escape(data.text) + '</span>' +
                                        '</div>';
                                },
                                item: function (data, escape) {
                                    return '<div>' +
                                        '<span class="image"><img src="' + data.image + '" alt=""></span>' +
                                        escape(data.text) +
                                        '</div>';
                                }
                            }
          });

    });


});
</script>
@endsection