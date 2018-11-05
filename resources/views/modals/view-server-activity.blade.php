@extends('modals.view-server')

@section('title', 'Manage Server - Activity')

@section('server-view-tab')

<div class="table-responsive">

  @if ( Session::has('message') )

            <div class="alert alert-info">{!! session( 'message' ) !!}</div>

      @endif

      @if ( Session::has('error') )

            <div class="alert alert-warning">{!! session( 'error' ) !!}</div>

      @endif

        <table class="table table-hover table-borderless">
          <thead>
            <tr>
              <th colspan="2">User</th>
              <th>Activity log</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>

                            
              @forelse( $activities as $activity )

                  <tr>
                    <td class="w-1">
                      <span class="avatar" style="background-image: url({{ Gravatar::src( $activity->causer->email ) }})"></span>
                    </td>
                    <td class="text-nowrap">{{ $activity->causer->slug() }}</td>
                    <td>{{ $activity->description }}</td>
                    <td class="text-nowrap">{{ $activity->created_at->diffForHumans() }}</td>
                  </tr>

                  @empty

                    <div class="alert alert-info">
                      No activity log
                    </div>

                  @endforelse
              
          </tbody>
        </table>

      </div>

      {{ $activities->links() }}

@endsection