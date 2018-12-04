@extends('dashboard')

@section('title', 'Activity')

@section('content')
        
        <div class="my-3 my-md-5" id="activity">
          <div class="container">

            @if ( Session::has('status_activitylog') )
              {{-- <div class="card-alert alert alert-success mb-0">
                  <i class="fe fe-check mr-2" aria-hidden="true"></i>{!! session( 'status_activitylog' ) !!}
              </div> --}}
              @alert([ 'type' => 'success', 'card', 'classes' => 'mb-0'])
                {!! session( 'status_activitylog' ) !!}
              @endalert
            @endif

            @if ( Session::has('error_activitylog') )
              {{-- <div class="card-alert alert alert-danger mb-0">
                  {!! session( 'error_activitylog' ) !!}
              </div> --}}

              @alert([ 'type' => 'danger', 'card', 'classes' => 'mb-0'])
                {!! session( 'error_activitylog' ) !!}
              @endalert

            @endif

            
            <div class="page-header">
              <h1 class="page-title">
                Activity log
              </h1>

            </div>

            @hasrole('super-admin')
            @if ( !$activities->isEmpty() )
            <div class="text-right mb-4">
              <div class="btn-group" role="group" aria-label="clear Activity log">
                <form action="{{ route('activity.clear') }}" method="POST">
                  @csrf
                  @method('DELETE')   
                  <a href="javascript:void(0)" class="btn btn-danger activity-log-clear" data-original-title="" title=""><i class="fe fe-trash-2 mr-2"></i>Clear log</a>
              </form>

              </div>
           </div>
           @endif
           @endhasrole
            
            <div class="row row-cards row-deck">
              <div class="col-12">
                <div class="card">
                  @if ( !$activity_chart_data->isEmpty() )
                  <div id="chart-users-activity" style="height: 12rem"></div>
                  @endif
                  <div class="table-responsive">
                    <table class="table card-table table-striped table-vcenter">
                      <thead>
                        <tr>
                          <th colspan="2">User</th>
                          <th>Activity</th>
                          <th>Date</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse( $activities as $activity )
                        <tr>
                          <td class="w-1"><span class="avatar" style="background-image: url({{ $activity->causer !== null ? Gravatar::src($activity->causer->email) : '' }})"></span></td>
                          <td class="text-nowrap">{!! $activity->causer !== null ? $activity->causer->slug() : '<small><i>User no longer exists</i></small>' !!}</td>
                          <td><span data-html="true" data-toggle="tooltip" data-placement="top" title="@foreach( $activity->properties->toArray() as $property => $value ) {{ '<b>'.str_replace('_', ' ', $property).'</b>: '.$value.'<br>' }} @endforeach">{{ ucwords($activity->description) }}</span></td>
                          <td class="text-nowrap">{{ $activity->created_at->diffForHumans() }}</td>
                          <td class="w-1">
                            @hasrole('super-admin')

                            <form action="{{ url('activity/'.$activity->id.'') }}" method="post" accept-charset="utf-8">
                                @csrf
                                @method('DELETE')
                                <a href="javascript:void(0)" class="icon delete-activity-log"><i class="fe fe-trash"></i></a>
                                
                                </form>
                            @endhasrole
                          </td>
                        </tr>

                        @empty
                        {{-- <div class="alert alert-info">
                          No activity log
                        </div> --}}

                        @alert([ 'type' => 'info'])
                          No activity log
                        @endalert

                      @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>

                {{ $activities->links() }}

              </div>

              @if ( !$activity_chart_data->isEmpty() )
              <script>
                  require(['c3', 'jquery'], function(c3, $) {
                    $(document).ready(function(){
                      var chart = c3.generate({
                        bindto: '#chart-users-activity', // id of chart wrapper
                        data: {
                          columns: [
                              // each columns data
                          ['data1', @foreach( $activity_chart_data->reverse() as $activity ) {{ $activity->data }},@endforeach ]

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
        </div>
      </div>


    </div>

@endsection