@extends('dashboard')

@section('title', 'Firewall')

@section('content')


<div id="firewalls">

<div class="page-header">
  <h1 class="page-title">
    Firewall
  </h1>
</div>

      <div class="row">
              <div class="col-lg-3 order-lg-1 mb-4">

               @include( 'partials.nav', [ 'currentRouteName' => Route::currentRouteName()])

              </div>
              <div class="col-lg-9">
                <div class="card">
                  <div class="card-body">

          @if( !auth()->user()->can('manage firewalls') )

            <div class="card-alert alert alert-warning mb-0">
                <i class="fe fe-lock" title="fe fe-lock"></i> <strong>Forbidden!</strong> You don't have permission to manage Firewalls.
              </div>

          @endif

      @can('manage firewalls')

      <div class="page-header">

              <div class="page-subtitle total-firewalls">{{ count($firewalls) <= 1 ? count($firewalls).' '.str_singular('firewalls') : count($firewalls).' firewalls' }}</div>

              <div class="page-options d-flex">

              <div class="input-icon ml-2">

              <span class="input-icon-addon">
              <i class="fe fe-search"></i>
              </span>

              <input class="search form-control w-10" placeholder="Search Firewalls ..." type="text">
              </div>

              </div>

        </div>

      @if (Session::has('message'))

        <div class="alert alert-info">{!! session('message') !!}</div>

      @endif
      
      <div class="table-responsive">
        <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Description</th>
              <th>Date Created</th>
              <th>Rules</th>
              <th>Instances</th>
            </tr>
          </thead>
          <tbody class="list">

          @forelse ( $firewalls as $firewall )

            <tr>

              <td class="id">{{ $firewall['FIREWALLGROUPID'] }}</td>
              <td class="description">{{ $firewall['description'] }}</td>
              <td class="date-created">{{ \Carbon\Carbon::parse($firewall['date_created'])->diffForHumans() }}</td>
              <td class="rules">{{ $firewall['rule_count'] }}</td>
              <td class="instances">{{ $firewall['instance_count'] }}</td>
              <td>
                  <form action="{{ route('firewall.delete_group') }}" method="POST" name="deletefirewallgroup-{{ $firewall['FIREWALLGROUPID'] }}" accept-charset="utf-8">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="firewallgroupid" value="{{ $firewall['FIREWALLGROUPID'] }}">
                    <a class="icon deletefirewallgroup" firewallgroupid="{{ $firewall['FIREWALLGROUPID'] }}" class="icon" href="#{{ $firewall['FIREWALLGROUPID'] }}" {{--onclick="document.forms['destroysnapshot-{{ $snapshot['SNAPSHOTID'] }}'].submit();" --}}>
                      <i class="fe fe-trash"></i>
                    </a>
                  </form>
                </td>
            </tr>

          @empty

                <div class="alert alert-info">{{ __('No Firewall Groups') }}</div>

            @endforelse

        </tbody>
    </table>
</div>

<ul class="pagination"></ul>


@endcan

</div>

</div>

</div>

</div>

</div>

<script type="text/javascript">

      require(['core'], function () {

        $(document).ready(function () {

          searchTable('firewalls', true, 10, [ 'description', 'rules', 'instances' ], '.total-ips', 'firewall', 'firewalls');

        $('.deletefirewallgroup').popover(
            {
              html: true,
              trigger: 'click',
              content: '<div class="card-body vultr-notify">\
                  <h5>Delete Firewall Group? </h5>\
                  <p class="vu-notify-msg">Are you sure you want to delete this firewall group?</p>\
                </div>\
                <div class="card-footer">\
                  <button type="button" id="confirmbtn" class="btn btn-primary btn-block">Delete Firewall Group</button>\
                  <button type="button" id="canecelbtn" class="btn btn-secondary btn-block">Cancel</button>\
                </div>',
          }
        );

        $('.deletefirewallgroup').on('shown.bs.popover', function () {

            var that = this;

            $('#confirmbtn').click(function(){

                $(this).addClass('btn-loading');

                document.forms['deletefirewallgroup-' + $(that).attr('firewallgroupid') + ''].submit();

            });

            $('#canecelbtn').click(function(){
                $('.deletefirewallgroup').popover('hide');
            });

          });

          });
        });

      </script>

@endsection