@extends('dashboard')

@section('title', 'SSH')

@section('content')

<div id="sshkeys">

<div class="page-header">
  <h1 class="page-title">
    SSH keys
  </h1>
</div>

      <div class="row">
  <div class="col-lg-3 order-lg-1 mb-4">

    <a href="{{ url('sshkeys/add') }}" class="btn btn-block btn-primary @if( !auth()->user()->can('manage sshkeys') ) btn-secondary disabled @endif mb-6">
Add SSH Key
</a>

   @include( 'partials.nav', [ 'currentRouteName' => Route::currentRouteName()])

  </div>
  <div class="col-lg-9">
    <div class="card">
      <div class="card-body">

        @if( !auth()->user()->can('manage sshkeys') )

          <div class="card-alert alert alert-warning mb-0">
              <i class="fe fe-lock" title="fe fe-lock"></i> <strong>Forbidden!</strong> You don't have permission to manage SSH Keys.
          </div>

      @endif

      @can('manage sshkeys')

      <div class="page-header">

        <div class="page-subtitle total-sshkeys">{{ count($sshkeys) <= 1 ? count($sshkeys).' '.str_singular('SSH key') : count($sshkeys).' SSH keys' }}</div>

              <div class="page-options d-flex">

              <div class="input-icon ml-2">

                      <span class="input-icon-addon">
                        <i class="fe fe-search"></i>
                      </span>

                      <input class="search form-control w-10" placeholder="Search SSH keys ..." type="text">
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
              <th>Name</th>
              <th>Date Created</th>
              <td></td>
            </tr>
          </thead>
          <tbody class="list">

            @forelse ( $sshkeys as $sshkey )


            <tr>
              <td class="name">{{ $sshkey['name'] }}</td>
              <td class="date-created">{{ \Carbon\Carbon::parse($sshkey['date_created'])->diffForHumans() }}</td>

              <td>
                <div class="item-action dropdown">
                    <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">Actions</button>

                    <div class="dropdown-menu dropdown-menu-right">

                      <a href="{{ url("/sshkeys/edit/".$sshkey['SSHKEYID']) }}" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i>Edit SSH Key</a>

                <form action="{{ route('sshkeys.destroy') }}" method="POST" name="deletesshkey-{{ $sshkey['SSHKEYID'] }}" accept-charset="utf-8">

                    @method('DELETE')
                    @csrf

                    <input type="hidden" name="sshkeyid" value="{{ $sshkey['SSHKEYID'] }}">

                    <a class="dropdown-item deletesshkey red" sshkeyid="{{ $sshkey['SSHKEYID'] }}" class="icon" href="#{{ $sshkey['SSHKEYID'] }}" {{--onclick="document.forms['destroysnapshot-{{ $snapshot['SNAPSHOTID'] }}'].submit();" --}}>
                      <i class="dropdown-icon fe fe-trash-2 red"></i>Delete SSH key
                    </a>

                </form>

                    </div>

                  </div>
                </td>

            </tr>

            @empty

                <div class="alert alert-info">{{ __('No SSH Keys') }}</div>

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

require([ 'core' ], function () {

  $(document).ready(function () {

    searchTable('sshkeys', true, 10, [ 'name', 'date-created' ], '.total-sshkeys', 'SSH key', 'SSH keys');

    //function searchTable( id ,pagination = true, page = 10 , values = [], countid, singularCount, pluralCount ){

  });

});

</script>

@endsection