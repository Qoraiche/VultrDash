<div class="col-12">
                <div class="card">

                  <div class="card-header">
                    <div class="card-title">
                      Servers
                    </div>
                    <div class="card-options">
                      <div class="btn-group">
                        @can('manage servers')
                          <a href="{{ url('/servers') }}" class="btn btn-secondary btn-sm">View servers</a>
                        @endcan
                        @can('deploy servers')
                          <a href="{{ url('/servers/add') }}" class="btn btn-secondary btn-sm">Deploy server</a>
                        @endcan
                      </div>
                    </div>
                  </div>

                  @if( !auth()->user()->can('manage servers') )
                      {{-- <div class="alert alert-warning mb-0">
                        You cannot manage servers
                      </div> --}}

                      @alert([ 'type' => 'warning', 'classes' => 'mb-0'])
                        You cannot manage servers
                      @endalert
                    @endif

                @can('manage servers')
                  <div class="table-responsive">

                    <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
                      <thead>
                        <tr>
                          <th class="text-center w-1"></th>
                          <th>Server</th>
                          <th>Bandwidth usage</th>
                          <th class="text-center">Location</th>
                          <th class="text-center">Disk</th>
                          <th class="text-center">Date created</th>
                          <th class="text-center">Status</th>
                          <th class="text-center"><i class="icon-settings"></i></th>
                        </tr>
                      </thead>
                      <tbody>

                        @forelse ( $servers as $server )

                        @if ( $loop->index === 8 )

                          @break

                        @endif

                        <tr>
                          <td class="type">
                            <div class="avatar d-block" server-type='{{ $os->getOsByKeyId( $server['OSID'], 'family') }}' style="background-image: url( {{ asset( $os->getOsByKeyId( $server['OSID'])  == 'application' ? 'images/'.$app->getServerAppImage( $app->getAppByKeyId( $server['APPID']) ) : 'images/'.$os->getServerOSImage($os->getOsByKeyId( $server['OSID'], 'family') )) }} );
                                background-size:contain;background-color: #fff;">
                                  <span class="avatar-status {{ strtolower($server['power_status']) == 'running' ? 'bg-green' : 'bg-red' }}"></span>
                                </div>
                            </td>
                          <td>
                            <div><a class="text-inherit" href="{{ route('servers.view', $server['SUBID']) }}">{{ $server['label'] == '' ? 'Cloud Instance' : ucwords($server['label']) }}</a></div>
                            <div class="small text-muted">
                              {{ $server['ram'] }} Server - {{ $server['main_ip'] }}
                            </div>
                          </td>
                          <td>
                            <div class="clearfix">
                              <div class="float-left">
                                <strong>{{ round(getPercent( $server['current_bandwidth_gb'], $server['allowed_bandwidth_gb'] ), 2) }}%</strong>
                              </div>
                              <div class="float-right">
                                <small class="text-muted">{{ round($server['current_bandwidth_gb']) }} GB - {{ $server['allowed_bandwidth_gb'] }} GB</small>
                              </div>
                            </div>

                            <div class="progress progress-xs">
                              <div class="progress-bar bg-{{ $server['current_bandwidth_gb'] < 500 ? 'green' : 'yellow' }}" role="progressbar" style="width: {{ round(getPercent($server['current_bandwidth_gb'], $server['allowed_bandwidth_gb'])) }}%" aria-valuenow="{{ round(getPercent($server['current_bandwidth_gb'], $server['allowed_bandwidth_gb'])) }}" aria-valuemin="0" aria-valuemax="100">
                              </div>
                            </div>

                          </td>

                          <td class="text-center">
                            {{ $server['location'] }}
                          </td>

                          <td class="text-center">
                            {{ $server['disk'] }}
                          </td>

                          <td class="text-center">
                            <div data-toggle="tooltip" data-placement="top" data-original-title="{{ $server['date_created'] }}">{{ \Carbon\Carbon::parse($server['date_created'])->diffForHumans() }}</div>
                          </td>

                          <td class="text-center">
                            <span class="status-icon bg-{{ strtolower($server['status']) == 'active' ? 'success' : 'warning' }}"></span> {{ ucfirst($server['status']) }}
                          </td>

                          <td>
                            <div class="server-action dropdown">
                              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>

                              <div class="dropdown-menu dropdown-menu-right">

                                <a href="{{ route('servers.view', $server['SUBID']) }}" class="dropdown-item"><i class="dropdown-icon fe fe-eye"></i> View Server</a>

                                <form action="{{ strtolower( $server['power_status'] ) == 'running' ? url('servers/halt') : url('servers/start') }}" method="post" accept-charset="utf-8">
                                    @csrf
                                    <input type="hidden" name="serverid" value="{{ $server['SUBID'] }}">

                                    <a href="javascript:void(0)" class="dropdown-item{{ strtolower($server['power_status']) == 'running' ? ' halt' : ' startserver'}}"><i class="dropdown-icon fe fe-power"></i>{{ strtolower($server['power_status']) == 'running' ? 'Stop Server' : 'Start Server' }}</a>

                                </form>

                                <form action="{{ url('servers/start') }}" method="post" accept-charset="utf-8">
                                    @csrf
                                    <input type="hidden" name="serverid" value="{{ $server['SUBID'] }}"> 

                                    <a href="javascript:void(0)" class="dropdown-item restart"><i class="dropdown-icon fe fe-refresh-cw"></i>Restart Server</a>

                                  </form>

                                    <a href="javascript:void(0)" class="dropdown-item" onclick="window.open('{{ $server['kvm_url'] }}','','width=600,height=450')"><i class="dropdown-icon fe fe-terminal"></i> View Console</a>

                                <form action="{{ url('servers/reinstall') }}" method="post" accept-charset="utf-8">
                                    @csrf
                                    <input type="hidden" name="serverid" value="{{ $server['SUBID'] }}"> 
                                
                                    <a href="javascript:void(0)" class="dropdown-item reinstall"><i class="dropdown-icon fe fe-disc"></i> Reinstall Server</a>
                                
                                </form>

                                <div class="dropdown-divider"></div>

                                <form action="{{ url('servers/destroy') }}" method="post" accept-charset="utf-8">
                                    @csrf
                                    <input type="hidden" name="serverid" value="{{ $server['SUBID'] }}"> 
                                
                                    <a href="javascript:void(0)" class="dropdown-item destroy"><i class="dropdown-icon fe fe-trash-2"></i> Destroy Server</a>

                              </form>

                              </div>
                            </div>
                            </td>

                        </tr>

                        @empty
                          @alert([ 'type' => 'info' ])
                                No Servers found
                          @endalert
                        @endforelse

                      </tbody>
                    </table>
                    
                  </div>
                  @endcan
                </div>
              </div>