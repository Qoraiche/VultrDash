@extends('dashboard')

@section('title', 'Add Block Storage')

@section('content')

<div class="page-header">
    <h1 class="page-title">
      <a class="icon back-previous" href="{{ url('/blockstorage') }}"><i class="fe fe-arrow-left-circle"></i></a>
        Add Blockstorage
    </h1>
</div>

      <div class="row">
          <div class="col-md-7 col-xl-6" style="margin:auto;">
              <div class="card">
              <div class="card-status bg-blue"></div>
              <div class="card-header">
                    <h3 class="card-title">Block storage</h3>
              </div>
              <div class="card-body">

              @if (Session::has('message'))

                     {{-- <div class="alert alert-info">{!! session('message') !!}</div> --}}

                     @alert([ 'type' => 'info'])
                        {!! session('message') !!}
                     @endalert

               @endif

               <form action="{{ route('blockstorage.create') }}" method="POST" accept-charset="utf-8">

                  @csrf

                  <div class="form-group">

                      <label class="form-label">Location</label>

                        <select name="regionid" id="select-countries" class="form-control custom-select">
                          @forelse ( $regions as $region )
                          @if ( !$region['block_storage'] ) @continue @endif

                            <option value="{{ $region['DCID'] }}" data-data='{"image": "{{ asset( 'images/flags/'.strtolower($region['country'].'.svg') ) }}"}'
                            >{{ $region['country'] }} - {{ $region['name'] }}</option>

                          @empty
                          {{-- <div class="alert alert-info">{{ __('No Block Storage') }}</div> --}}

                          @alert([ 'type' => 'info'])
                              No Block Storage
                          @endalert

                          @endforelse
                        </select>
                          
                  </div>

                  <div class="form-group">
                    <label class="form-label">Size GB</label>
                    <div class="col-md-12">
                        <input type="range" id="size_range" class="form-control-range" name="sizegb" min="10" max="10000">
                    </div>
                  </div>
                
                  <div class="form-group col-auto float-right">
                        
                        <div class="row align-items-center">
                          
                          <div class="col-auto">
                             <h4><span id="gbsize_text"></span><span style="font-size: 12px"> GB</span></h4>
                          </div>
                          <div class="col-auto">
                             <h4><span id="block_monthly"></span><span style="font-size: 12px"> /m</span></h4>
                          </div>
                          <div class="col-auto">
                             <h4><span id="block_hourly"></span><span style="font-size: 12px"> /h</span></h4>
                          </div>

                          <div class="col-auto">
                             <input type="number" id="gbsize_number" class="form-control w-8" min="10" max="10000" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                          </div>

                        </div>
                    </div>

                    <div class="form-group">
                          <input class="form-control" name="label" placeholder="Storage label" type="text">
                    </div>

                    <div class="form-group">
                      <input type="submit" class="btn btn-primary btn-lg btn-block" value="Add Block Storage" onclick="this.disabled = true;this.value = 'Please wait...'">
                    </div>
               </form>


               <script type="text/javascript">

                    require(['jquery', 'selectize'], function ($, selectize) {

                    $(document).ready(function () {

                      var minRange = 10, 
                      block_per_gb_month = 0.1,
                      size_range = $( "#size_range");             
                      size_range.val(minRange);
                      var monthly = size_range.val() * block_per_gb_month;
                      var hourly = monthly / 672;

                      $('#gbsize_text').text( $( "#size_range").val() );
                      $('#gbsize_number').val( $( "#size_range").val() );
                      $('#block_monthly').text('$' + monthly.toFixed(2).toString() );
                      $('#block_hourly').text('$' + hourly.toFixed(4));
                      $("#size_range, #gbsize_number").on('change keydown', function(){

                        var monthly = $(this).val() * block_per_gb_month;
                        var hourly = monthly / 672;
                        var newv= $(this).val();
                        
                        $('#gbsize_text').text(newv);
                        $('#gbsize_number').val(newv);
                        $('#size_range').val(newv);
                        $('#block_monthly').text('$' + monthly.toFixed(2).toString());
                        $('#block_hourly').text('$' + hourly.toFixed(4));

                      });

                
                        $('#select-countries').selectize({
                            render: {
                                option: function (data, escape) {
                                    return '<div>' +
                                        '<span class="image"><img src="' + data.image + '" alt=""></span>' +
                                        '<span class="title">' + escape(data.text) + '</span>' +
                                        '</div>';
                                },
                                item: function (data, escape) {
                                    return '<div>' +
                                        '<span class="image"><img src="' + data.image + '" alt=""></span>' +
                                        escape(data.text) +
                                        '</div>';
                                }
                            }
                        });
                    });
                });

                  </script>


              </div>
            </div>
         </div>
      </div>

@endsection