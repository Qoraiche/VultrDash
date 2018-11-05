/**
 * App
 */

  let hexToRgba = function(hex, opacity) {
  let result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
  let rgb = result ? {
    r: parseInt(result[1], 16),
    g: parseInt(result[2], 16),
    b: parseInt(result[3], 16)
  } : null;

  return 'rgba(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ', ' + opacity + ')';
};

function startCountdown(duration, display) {

      var timer = duration, seconds;
      setInterval(function () {

          seconds = parseInt(timer % 60, 10);
          seconds = seconds < 10 ? + seconds : seconds;
          display.text(seconds);

          if (--timer < 0) {
              timer = duration;
          }

      }, 1000);
    }

function searchTable( id ,pagination = true, page = 10 , values = [], countid, singularCount, pluralCount ){

    var options = {

            valueNames: values,
            page: page,
            pagination: pagination

          };

          var list = new List(id, options);

        //https://stackoverflow.com/questions/43883215/listjs-count-item-after-search
          list.on('searchComplete', function(){

            // console.log(instances_list.update().matchingItems.length)
            count_text = list.update().matchingItems.length <= 1 ? list.update().matchingItems.length + ' ' + singularCount : list.update().matchingItems.length +  ' ' + pluralCount;
            $(countid).text(count_text);

          });

  }


$(document).ready(function() {


  $('.table-responsive').on('show.bs.dropdown', function () {
     $('.table-responsive').css( "overflow", "inherit" );
});

$('.table-responsive').on('hide.bs.dropdown', function () {
     $('.table-responsive').css( "overflow", "auto" );
})


  var ub_details_ = $(".user-balance-details");
  var ub_btn_ = $(".user-details_mid-view .icon#icon-payment-info");

  ub_btn_.click(function() {

    ub_details_.slideToggle();
    $(this).toggleClass("active-icon");

  });

  $('.activity-log-clear').popover(
    {
      html: true,
      trigger: 'click',
      content: '<div class="card-body vultr-notify">\
          <h5>Clear activity log?</h5>\
          <p class="vu-notify-msg">Are you sure you want to clear activity log?</p>\
        </div>\
        <div class="card-footer">\
          <button type="button" id="confirmbtn" class="btn btn-danger btn-block">Clear</button>\
          <button type="button" id="canecelbtn" class="btn btn-secondary btn-block">Cancel</button>\
        </div>',
    }
  );


  $('.delete-activity-log').popover(
    {
      html: true,
      trigger: 'click',
      content: '<div class="card-body vultr-notify">\
          <h5>Delete activity log?</h5>\
          <p class="vu-notify-msg">Are you sure you want to delete this log?</p>\
        </div>\
        <div class="card-footer">\
          <button type="button" id="confirmbtn" class="btn btn-danger btn-block">Delete</button>\
          <button type="button" id="canecelbtn" class="btn btn-secondary btn-block">Cancel</button>\
        </div>',
    }
    );

    $('.delete-thread').popover(
      {
        html: true,
        trigger: 'click',
        content: '<div class="card-body vultr-notify">\
            <h5>Delete Thread?</h5>\
            <p class="vu-notify-msg">Are you sure you want to delete this thread?, this action cannot be undone.</p>\
          </div>\
          <div class="card-footer">\
            <button type="button" id="confirmbtn" class="btn btn-danger btn-block">Delete</button>\
            <button type="button" id="canecelbtn" class="btn btn-secondary btn-block">Cancel</button>\
          </div>',
      }
      );


  $('.delete-notifications').popover(
    {
      html: true,
      trigger: 'click',
      content: '<div class="card-body vultr-notify">\
          <h5>Remove snapshot?</h5>\
          <p class="vu-notify-msg">Are you sure you want to delete all notifications</p>\
        </div>\
        <div class="card-footer">\
          <button type="button" id="confirmbtn" class="btn btn-danger btn-block">Clear</button>\
          <button type="button" id="canecelbtn" class="btn btn-secondary btn-block">Cancel</button>\
        </div>',
    }
    );


  $('.mark-notifications').popover(
    {
      html: true,
      trigger: 'click',
      content: '<div class="card-body vultr-notify">\
          <h5>Mark all notifications as read?</h5>\
        </div>\
        <div class="card-footer">\
          <button type="button" id="confirmbtn" class="btn btn-primary btn-block">Mark All as Read</button>\
          <button type="button" id="canecelbtn" class="btn btn-secondary btn-block">Cancel</button>\
        </div>',
    }
    );

  $('.removesnapshot').popover(
    {
      html: true,
      trigger: 'click',
      content: '<div class="card-body vultr-notify">\
          <h5>Remove Snapshot?</h5>\
          <p class="vu-notify-msg">Are you sure you want to delete this snapshot? This action cannot be undone.</p>\
        </div>\
        <div class="card-footer">\
          <button type="button" id="confirmbtn" class="btn btn-danger btn-block">Remove Snapshot</button>\
          <button type="button" id="canecelbtn" class="btn btn-secondary btn-block">Cancel</button>\
        </div>',
    }
    );

  $('.destroy').popover(
      {
        html: true,
        trigger: 'click',
        content: '<div class="card-body vultr-notify">\
            <h5>Destroy Server?</h5>\
            <p class="vu-notify-msg">Are you sure you want to destroy this server? Any data on your server will be permanently lost!</p>\
          </div>\
          <div class="card-footer">\
            <button type="button" id="confirmbtn" class="btn btn-danger btn-block">Destroy Server</button>\
            <button type="button" id="canecelbtn" class="btn btn-secondary btn-block">Cancel</button>\
          </div>',
          placement: 'left'
    }
  );


  $('.restoresnapshot').popover(
      {
        html: true,
        trigger: 'click',
        content: '<div class="card-body vultr-notify">\
            <h5>Restore Snapshot?</h5>\
            <p class="vu-notify-msg">Are you sure you want to restore this snapshot? Any data currently on your machine will be overwritten.</p>\
          </div>\
          <div class="card-footer">\
            <button type="button" id="confirmbtn" class="btn btn-danger btn-block">Restore snapshot</button>\
            <button type="button" id="canecelbtn" class="btn btn-secondary btn-block">Cancel</button>\
          </div>',
          placement: 'left'
    }
  );


  $('.halt').popover(
    {
        html: true,
        trigger: 'click',
        content: '<div class="card-body vultr-notify">\
            <h5>Stop Server?</h5>\
            <p class="vu-notify-msg">Are you sure you want to stop your server? This will hard power off the server. You will need to start the server again via the restart button.</p>\
          </div>\
          <div class="card-footer">\
            <button type="button" id="confirmbtn" class="btn btn-primary btn-block">Stop Server</button>\
            <button type="button" id="canecelbtn" class="btn btn-secondary btn-block">Cancel</button>\
          </div>',
          placement: 'left'
    }
  );

  $('.startserver').popover(
    {
        html: true,
        trigger: 'click',
        content: '<div class="card-body vultr-notify">\
            <h5>Start Server?</h5>\
            <p class="vu-notify-msg">Are you sure you want to start your server?</p>\
          </div>\
          <div class="card-footer">\
            <button type="button" id="confirmbtn" class="btn btn-primary btn-block">Start Server</button>\
            <button type="button" id="canecelbtn" class="btn btn-secondary btn-block">Cancel</button>\
          </div>',
          placement: 'left'
    }
  );

  $('.restart').popover(
    {
        html: true,
        trigger: 'click',
        content: '<div class="card-body vultr-notify">\
            <h5>Restart Server?</h5>\
            <p class="vu-notify-msg">Are you sure you want to restart your server? This is a hard restart.</p>\
          </div>\
          <div class="card-footer">\
            <button type="button" id="confirmbtn" class="btn btn-primary btn-block">Restart Server</button>\
            <button type="button" id="canecelbtn" class="btn btn-secondary btn-block">Cancel</button>\
          </div>',
          placement: 'left'
    }
  );


  $('.reinstall').popover(
    {
        html: true,
        trigger: 'click',
        content: '<div class="card-body vultr-notify">\
            <h5>Reinstall Server?</h5>\
            <p class="vu-notify-msg">Are you sure you want to reinstall your server? Any data on your server will be permanently lost!</p>\
          </div>\
          <div class="card-footer">\
            <button type="button" id="confirmbtn" class="btn btn-danger btn-block">Reinstall Server</button>\
            <button type="button" id="canecelbtn" class="btn btn-secondary btn-block">Cancel</button>\
          </div>',
          placement: 'left'
    }
  );

  $('.removescript').popover(
            {
              html: true,
              trigger: 'click',
              content: '<div class="card-body vultr-notify">\
                  <h5>Delete Startup Script?</h5>\
                  <p class="vu-notify-msg">Are you sure you want to delete this script?</p>\
                </div>\
                <div class="card-footer">\
                  <button type="button" id="confirmbtn" class="btn btn-primary btn-block">Delete Startup Script</button>\
                  <button type="button" id="canecelbtn" class="btn btn-secondary btn-block">Cancel</button>\
                </div>',
            }
  );


  $('.deletesshkey').popover(
        {
          html: true,
          trigger: 'click',
          content: '<div class="card-body vultr-notify">\
              <h5>Delete SSH Key?</h5>\
              <p class="vu-notify-msg">Are you sure you want to delete this key? This will not remove the key from any machines that already have it.</p>\
            </div>\
            <div class="card-footer">\
              <button type="button" id="confirmbtn" class="btn btn-primary btn-block">Delete SSH Key</button>\
              <button type="button" id="canecelbtn" class="btn btn-secondary btn-block">Cancel</button>\
            </div>',
      }
  );

  $('.delete-user').popover(
        {
          html: true,
          trigger: 'click',
          content: '<div class="card-body vultr-notify">\
              <h5>Delete User?</h5>\
              <p class="vu-notify-msg">Are you sure you want to delete this user?</p>\
            </div>\
            <div class="card-footer">\
              <button type="button" id="confirmbtn" class="btn btn-danger btn-block">Delete User</button>\
              <button type="button" id="canecelbtn" class="btn btn-secondary btn-block">Cancel</button>\
            </div>',
      }
  );

  $('.activity-log-clear, .delete-thread, .delete-activity-log, .mark-notifications, .delete-notifications, .destroy, .halt, .startserver, .restart, .reinstall, .removesnapshot, .removescript, .deletesshkey, .restoresnapshot, .delete-user').on('shown.bs.popover', function () {

      var that = this;

      $('#confirmbtn').click(function(){

          $(this).addClass('btn-loading');

          that.closest( 'form' ).submit();

      });

          $('#canecelbtn').click( function() {
            
              $(that).popover('hide');

          });

          $(document).mouseup(function(e)
            {
                var container = $('.popover');

                // if the target of the click isn't the container nor a descendant of the container
                if ( !container.is(e.target) && container.has(e.target).length === 0 ) 
                {
                    $(that).popover('hide');
                }

            });

      });


  /** Constant div card */
  const DIV_CARD = 'div.card';

  /** Initialize tooltips */
  $('[data-toggle="tooltip"]').tooltip();

  /** Initialize popovers */
  $('[data-toggle="popover"]').popover({
    html: true
  });

  /** Function for remove card */
  $('[data-toggle="card-remove"]').on('click', function(e) {
    let $card = $(this).closest(DIV_CARD);

    $card.remove();

    e.preventDefault();
    return false;
  });

  /** Function for collapse card */
  $('[data-toggle="card-collapse"]').on('click', function(e) {
    let $card = $(this).closest(DIV_CARD);

    $card.toggleClass('card-collapsed');

    e.preventDefault();
    return false;
  });

  /** Function for fullscreen card */
  $('[data-toggle="card-fullscreen"]').on('click', function(e) {
    let $card = $(this).closest(DIV_CARD);

    $card.toggleClass('card-fullscreen').removeClass('card-collapsed');

    e.preventDefault();
    return false;
  });

  /**  */
  if ($('[data-sparkline]').length) {
    let generateSparkline = function($elem, data, params) {
      $elem.sparkline(data, {
        type: $elem.attr('data-sparkline-type'),
        height: '100%',
        barColor: params.color,
        lineColor: params.color,
        fillColor: 'transparent',
        spotColor: params.color,
        spotRadius: 0,
        lineWidth: 2,
        highlightColor: hexToRgba(params.color, .6),
        highlightLineColor: '#666',
        defaultPixelsPerValue: 5
      });
    };

    require(['sparkline'], function() {
      $('[data-sparkline]').each(function() {
        let $chart = $(this);

        generateSparkline($chart, JSON.parse($chart.attr('data-sparkline')), {
          color: $chart.attr('data-sparkline-color')
        });
      });
    });
  }

  /**  */
  if ($('.chart-circle').length) {
    require(['circle-progress'], function() {
      $('.chart-circle').each(function() {
        let $this = $(this);

        $this.circleProgress({
          fill: {
            color: tabler.colors[$this.attr('data-color')] || tabler.colors.blue
          },
          size: $this.height(),
          startAngle: -Math.PI / 4 * 2,
          emptyFill: '#F4F4F4',
          lineCap: 'round'
        });
      });
    });
  }
});


$(window).resize(function() {
  var $window = $(window);

  var windowsize = $window.width();

  if (
    windowsize > 1056 &&
    $(".user-balance-details").css("display") === "none"
  ) {
    $(".user-balance-details").css("display", "block");
  }
});