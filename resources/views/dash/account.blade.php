@extends('dashboard')

@section('title', 'Account')

@section('content')

<div class="page-header">
    <h1 class="display-3">
      Account
    </h1>
    
</div>

  <div class="row">

    <div class="col-md-3 col-sm-12">

        <div class="nav flex-column nav-pills" id="settings-tab" role="tablist" aria-orientation="vertical">

            <a class="nav-link primary-vertical-link active" id="account-tab" data-toggle="pill" href="#account" role="tab" aria-controls="account" aria-selected="true">Account</a>

            <a class="nav-link primary-vertical-link" id="messages-tab" data-toggle="pill" href="#messages" role="tab" aria-controls="messages" aria-selected="false">Messages</a>

             <a class="nav-link primary-vertical-link" id="Activity-tab" data-toggle="pill" href="#activity" role="tab" aria-controls="messages" aria-selected="false">Activity</a>
{{-- 
            @hasrole('super-admin')

            <a class="nav-link primary-vertical-link" id="application-tab" data-toggle="pill" href="#application" role="tab" aria-controls="application" aria-selected="false">Application</a>

            @endhasrole --}}

        </div>
        
    </div>

  <div class="col-md-9 col-sm-12">

    <div class="tab-content" id="tabContent">

      <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="home-tab">

        @include('modals.edit-account', [ 'user' => $user ])

      </div>

      <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab">

        @include('partials.threads', [ 'threads' => $threads, 'user' => new vultrui\User, 'users' => $users ])

      </div>

      <div class="tab-pane" id="activity" role="tabpanel" aria-labelledby="activity-tab">

        @include('partials.user-activity', [ 'activities' => $user_activities ])

      </div>

  </div>

  </div>

</div>

<script type="text/javascript">

require([ 'jquery', 'bootstrap', 'selectize' ], function ($, selectize) {
    
    $(document).ready(function () {



      $('.new-message').click(function(){
        $('.send-form').slideToggle();
      });

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
