@hasrole('super-admin')
@if ( !$activities->isEmpty() )
<div class="text-right mb-4">
  <div class="btn-group" role="group" aria-label="clear your activity log">
    <form action="{{ url('useractivity') }}" method="POST">
      @csrf
      @method('DELETE')   
      <a href="javascript:void(0)" class="btn btn-danger activity-log-clear" data-original-title="" title=""><i class="fe fe-trash-2 mr-2"></i>Clear log</a>
  </form>
  </div>
</div>
@endif
@endhasrole

<div class="card">
	@if ( Session::has('status_activitylog') )

	   {{--  <div class="card-alert alert alert-success mb-0">
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

        @alert([ 'type' => 'alert', 'card', 'classes' => 'mb-0'])
        {!! session( 'error_activitylog' ) !!}
      @endalert

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
          <td class="w-1"><span class="avatar" style="background-image: url({{ Gravatar::src( $activity->causer->email ) }})"></span></td>
          <td class="text-nowrap">{{ $activity->causer->slug() }}</td>
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
        
        @alert([ 'type' => 'info', 'classes' => 'mb-0'])
          No activity log
        @endalert

      @endforelse
      </tbody>
    </table>
  </div>
</div>
{{-- {{ $threads->fragment('messages')->links() }} --}}
{{ $activities->fragment('activity')->links() }}