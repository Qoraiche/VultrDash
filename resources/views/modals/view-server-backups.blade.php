@extends('modals.view-server')

@section('title', 'Manage Server - Backups')

@section('server-view-tab')

@if ( $serverInfo->auto_backups === 'yes' )

<div class="page-header">
  <h2 class="page-title">
    Backups
  </h2>
</div>

@endif

<div class="row">

  @if ( $serverInfo->auto_backups === 'yes' )

  <div class="col-3">

    <div class="nav vertical-nav flex-column nav-pills" id="backups-tab" role="tablist" aria-orientation="vertical">
      <a class="nav-link primary-vertical-link home active" id="backup-history-tab" data-toggle="pill" href="#backup-history" role="tab" aria-controls="backup-history" aria-selected="true">Backup History</a>
      <a class="nav-link primary-vertical-link home" id="backup-schedule-tab" data-toggle="pill" href="#backup-schedule" role="tab" aria-controls="backup-schedule" aria-selected="false">Backup Schedule</a>
      <a class="nav-link primary-vertical-link home" id="backup-status-tab" data-toggle="pill" href="#backup-status" role="tab" aria-controls="backup-status" aria-selected="false">Backup Status</a>
    </div>

  </div>

  <div class="col-9">

    <div class="tab-content" id="v-pills-tabContent">
      <div class="tab-pane fade show active" id="backup-history" role="tabpanel" aria-labelledby="backup-history-tab">
        <div class="table-responsive instances-table backups-table">

@if ( Session::has('message') )

            {{-- <div class="alert alert-info">{!! session( 'message' ) !!}</div> --}}

            @alert([ 'type' => 'info'])
                {!! session( 'message' ) !!}
            @endalert

            @endif

            @if ( Session::has('error') )

                  {{-- <div class="alert alert-warning">{!! session( 'error' ) !!}</div> --}}

            @alert([ 'type' => 'warning'])
                {!! session( 'error' ) !!}
            @endalert

            @endif

        <table class="table table-hover table-borderless">
          <thead>
            <tr>
              <th id="id">Name</th>
              <th id="description">Description</th>
              <th id="size">Size</th>
              <th id="date-created">Date</th>
              <th id="status">Status</th>
            </tr>
          </thead>
          <tbody>

            @forelse ( $backuplist as $backup )

            <tr>
                <td id="server">{{ $backup['BACKUPID'] }}</td>
                <td id="description">{{ $backup['description'] }}</td>
                <td id="size">{{ formatBytes($backup['size']) }}</td>
                <td id="date">{{ \Carbon\Carbon::parse($backup['date_created'])->diffForHumans() }}</td>
                <td class="active" id="status">{{ $backup['status'] }}</td>
            </tr>

            @empty

                {{-- <div class="alert alert-info">{{ __('No backups') }}</div> --}}

                @alert([ 'type' => 'info'])
                   No backups
                @endalert

            @endforelse

        </tbody>
    </table>
</div>
      </div>

<div class="tab-pane fade" id="backup-schedule" role="tabpanel" aria-labelledby="backup-schedule-tab">
        
        <div class="col-md-8 col-xl-7" style="margin:auto;">
  <div class="card">
  <div class="card-status bg-blue"></div>
  <div class="card-header">
        <h3 class="card-title">Backup Schedule</h3>
  </div>
  <div class="card-body">

    {{-- {{ dd($backupSchedule) }} --}}

    <p>Next scheduled backup: {{ $backupSchedule->next_scheduled_time_utc }} UTC</p>

    <form action="{{ route('servers.backupsetschedule') }}" method="POST" accept-charset="utf-8">
        @csrf
        <input type="hidden" name="subid" value="{{ $serverInfo->SUBID }}">

    <div class="row">

      <div class="col-md-12">
        <div class="form-group">
          <label class="form-label">Schedule backups</label>
          <select name="cron_type" class="form-control custom-select">
              <option value="daily"{{ $backupSchedule->cron_type === 'daily' ? " selected": '' }}>Daily</option>
              <option value="daily_alt_even"{{ $backupSchedule->cron_type === 'daily_alt_even' ? " selected": '' }}>Every Other Day</option>
              <option value="weekly"{{ $backupSchedule->cron_type === 'weekly' ? " selected": '' }}>Weekly</option>
              <option value="monthly"{{ $backupSchedule->cron_type === 'monthly' ? " selected": '' }}>Monthly</option>
          </select>
        </div>
      </div>

      <div class="col-sm-6 col-md-6">
        <div class="form-group">
          <label class="form-label">On</label>
          <select name="dow" class="form-control custom-select">
              <option value="0"{{ $backupSchedule->dow === 0 ? " selected": '' }}>Sunday</option>
              <option value="1"{{ $backupSchedule->dow === 1 ? " selected": '' }}>Monday</option>
              <option value="2"{{ $backupSchedule->dow === 2 ? " selected": '' }}>Tuesday</option>
              <option value="3"{{ $backupSchedule->dow === 3 ? " selected": '' }}>Wednesday</option>
              <option value="4"{{ $backupSchedule->dow === 4 ? " selected": '' }}>Thursday</option>
              <option value="5"{{ $backupSchedule->dow === 5 ? " selected": '' }}>Friday</option>
              <option value="6"{{ $backupSchedule->dow === 6 ? " selected": '' }}>Saturday</option>
          </select>
        </div>
      </div>

      <div class="col-sm-6 col-md-6">
        <div class="form-group">
          <label class="form-label">At</label>
          <select name="hour" class="form-control custom-select">
            <option value="0"{{ $backupSchedule->hour === 0 ? " selected": '' }}>0:00 UTC</option>
              <option value="1"{{ $backupSchedule->hour === 1 ? " selected": '' }}>1:00 UTC</option>
              <option value="2"{{ $backupSchedule->hour === 2 ? " selected": '' }}>2:00 UTC</option>
              <option value="3"{{ $backupSchedule->hour === 3 ? " selected": '' }}>3:00 UTC</option>
              <option value="4"{{ $backupSchedule->hour === 4 ? " selected": '' }}>4:00 UTC</option>
              <option value="5"{{ $backupSchedule->hour === 5 ? " selected": '' }}>5:00 UTC</option>
              <option value="6"{{ $backupSchedule->hour === 6 ? " selected": '' }}>6:00 UTC</option>
              <option value="7"{{ $backupSchedule->hour === 7 ? " selected": '' }}>7:00 UTC</option>
              <option value="8"{{ $backupSchedule->hour === 8 ? " selected": '' }}>8:00 UTC</option>
              <option value="9"{{ $backupSchedule->hour === 9 ? " selected": '' }}>9:00 UTC</option>
              <option value="10"{{ $backupSchedule->hour === 10 ? " selected": '' }}>10:00 UTC</option>
              <option value="11"{{ $backupSchedule->hour === 11 ? " selected": '' }}>11:00 UTC</option>
              <option value="12"{{ $backupSchedule->hour === 12 ? " selected": '' }}>12:00 UTC</option>
              <option value="13"{{ $backupSchedule->hour === 13 ? " selected": '' }}>13:00 UTC</option>
              <option value="14"{{ $backupSchedule->hour === 14 ? " selected": '' }}>14:00 UTC</option>
              <option value="15"{{ $backupSchedule->hour === 15 ? " selected": '' }}>15:00 UTC</option>
              <option value="16"{{ $backupSchedule->hour === 16 ? " selected": '' }}>16:00 UTC</option>
              <option value="17"{{ $backupSchedule->hour === 17 ? " selected": '' }}>17:00 UTC</option>
              <option value="18"{{ $backupSchedule->hour === 18 ? " selected": '' }}>18:00 UTC</option>
              <option value="19"{{ $backupSchedule->hour === 19 ? " selected": '' }}>19:00 UTC</option>
              <option value="20"{{ $backupSchedule->hour === 20 ? " selected": '' }}>20:00 UTC</option>
              <option value="21"{{ $backupSchedule->hour === 21 ? " selected": '' }}>21:00 UTC</option>
              <option value="22"{{ $backupSchedule->hour === 22 ? " selected": '' }}>22:00 UTC</option>
              <option value="23"{{ $backupSchedule->hour === 23 ? " selected": '' }}>23:00 UTC</option>
          </select>
        </div>
      </div>

    </div>

        <div class="form-group">
            <input class="btn btn-primary btn-lg btn-block" value="Update" onclick="this.disabled = true;this.value = 'Please wait...'" type="submit">
        </div>

  

  </div>

  </form>


</div>
</div>

</div>



      <div class="tab-pane fade" id="backup-status" role="tabpanel" aria-labelledby="backup-status-tab">
        <div class="col-md-8 col-xl-7" style="margin:auto;">
          <div class="card">
          <div class="card-status bg-blue"></div>
          <div class="card-header">
                <h3 class="card-title">Backup Status</h3>
          </div>
          <div class="card-body">

            <p>Automatic backups are currently enabled for this server.</p>
          
           <form action="{{ route('servers.backupdisable') }}" method="POST" accept-charset="utf-8">
            @csrf
            <input type="hidden" name="subid" value="{{ $serverInfo->SUBID }}">
                <div class="form-group">
                    <input class="btn btn-primary btn-lg btn-block" value="Disable Automatic Backups" onclick="this.disabled = true;this.value = 'Please wait...'" type="submit">
                </div>

           </form>

          </div>
        </div>

        </div>
      </div>

    </div>

  </div>

  @else



<div class="col-md-7 col-xl-6" style="margin:auto;">
  <div class="card">
  <div class="card-status bg-blue"></div>
  <div class="card-header">
        <h3 class="card-title">Backups</h3>
  </div>
  <div class="card-body">

    @if ( Session::has('message') )

            <div class="alert alert-info">{!! session( 'message' ) !!}</div>

            @endif

            @if ( Session::has('error') )

                  <div class="alert alert-warning">{!! session( 'error' ) !!}</div>

            @endif

    <p style="margin-bottom: 2.2em;">Enabling backups is an additional <strong>$1.00</strong>/month. Individual files cannot be restored (only the entire server). </p>
  
   <form action="{{ route('servers.backupenable') }}" method="POST" accept-charset="utf-8">
    @csrf
    <input type="hidden" name="serverid" value="{{ $serverInfo->SUBID }}">
        <div class="form-group">
            <input class="btn btn-primary btn-lg btn-block" value="Enable Backups" onclick="this.disabled = true;this.value = 'Please wait...'" type="submit">
        </div>

   </form>

  </div>
</div>

</div>

@endif

  </div>

<script type="text/javascript">


      setpillsHash('#backups-tab', '#backup-history');


    </script>

@endsection