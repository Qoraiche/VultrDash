<div class="col-lg-6" id="activity">
              <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Activity log</h3>
                    <div class="card-options">
                      <div class="btn-group">
                      <a href="{{ url('/activity') }}" class="btn btn-secondary btn-sm">View activity log</a>
                      @hasrole('super-admin')
                      <form action="{{ route('activity.clear') }}" method="post">
                        @csrf
                        @method('DELETE')
                        @if ( !$activities->isEmpty() )
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm activity-log-clear"><i class="fe fe-trash-2 mr-1"></i>Clear log</a>
                        @endif
                      </form>
                      @endhasrole
                    </div>
                    </div>
                  </div>

                  @if ( Session::has('status_activitylog') )
                    <div class="card-alert alert alert-success mb-0">
                        <i class="fe fe-check mr-2" aria-hidden="true"></i>{!! session( 'status_activitylog' ) !!}
                    </div>
                  @endif

                  @if ( Session::has('error_activitylog') )
                    <div class="card-alert alert alert-danger mb-0">
                        {!! session( 'error_activitylog' ) !!}
                    </div>
                  @endif

                  @if ( !$activity_chart_data->isEmpty() )
                  <div id="chart-user-activity" style="height: 10rem"></div>
                  @endif

                  <div class="table-responsive">
                    <table class="table card-table table-striped table-vcenter">
                      <thead>
                        <tr>
                          <th colspan="2">User</th>
                          <th>Activity log</th>
                          <th>Date</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse( $activities as $activity )
                        <tr>
                          <td class="w-1"><span class="avatar" style="background-image: url({{ Gravatar::src( $activity->causer->email ) }})"></span></td>
                          <td>{{ $activity->causer->slug() }}</td>
                          <td><span data-toggle="tooltip" data-placement="top" title="@foreach( $activity->properties->toArray() as $property => $value ) {{ $property.': '.$value }} @endforeach">{{ $activity->description }}</span></td>
                          <td class="text-nowrap">{{ $activity->created_at ->diffForHumans() }}</td>
                          @hasrole('super-admin')
                          <td class="w-1">
                            <form action="{{ url('activity/'.$activity->id.'') }}" method="post" accept-charset="utf-8">
                                
                                @csrf
                                @method('DELETE')
                                
                                <a href="javascript:void(0)" class="icon delete-activity-log"><i class="fe fe-trash"></i></a>
                                
                                </form>
                          </td>
                          @endhasrole
                        </tr>
                        @empty
                          <div class="alert alert-info">
                            No activity log
                          </div>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
          @if ( !$activity_chart_data->isEmpty() )
              <script>
                  require(['c3', 'jquery'], function(c3, $) {
                    $(document).ready(function(){
                      var chart = c3.generate({
                        bindto: '#chart-user-activity', // id of chart wrapper
                        data: {
                          columns: [
                              // each columns data
                          ['data1', @foreach( $activity_chart_data->reverse() as $activity ) {{ $activity->data }}, @endforeach]
                          ],
                          type: 'area', // default type of chart
                          groups: [
                            [ 'data1' ]
                          ],
                          colors: {
                            'data1': tabler.colors["blue"]
                          },
                          names: {
                              // name of each serie
                            'data1': 'Activity'
                          }
                        },
                        axis: {
                          y: {
                            padding: {
                              bottom: 0,
                            },
                            show: true,
                              tick: {
                              outer: true
                            }
                          },
                          x: {
                            type: 'category',

                            categories: [@foreach( $activity_chart_data->reverse() as $activity ) '{{ dateHelper( $activity->date, 'j M') }}', @endforeach],
                            padding: {
                              left: 0,
                              right: 0
                            },

                            show: true
                          }
                        },
                        legend: {
                          position: 'inset',
                          padding: 0,
                          inset: {
                            anchor: 'top-left',
                            x: 20,
                            y: 8,
                            step: 10
                          }
                        },
                        tooltip: {
                          format: {
                            title: function (x) {
                              return '';
                            }
                          }
                        },
                        padding: {
                          bottom: 0,
                          left: -1,
                          right: -1
                        },
                        point: {
                          show: false
                        }
                      });
                    });
                  });
                </script>

                @endif