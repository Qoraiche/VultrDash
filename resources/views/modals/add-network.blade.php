@extends('dashboard')

@section('title', 'Add Private Network')

@section('content')

<div class="page-header">
          <h1 class="page-title">
            <a class="icon back-previous" href="{{ url('/networks') }}"><i class="fe fe-arrow-left-circle"></i></a>
              Add Private Network
          </h1>
      </div>

      <div class="row">
          <div class="col-md-7 col-xl-6" style="margin:auto;">
              <div class="card">
              <div class="card-status bg-blue"></div>
              <div class="card-header">
                    <h3 class="card-title">Private Network</h3>
              </div>
              <div class="card-body">

              @if (Session::has('message'))

                     <div class="alert alert-info">{!! session('message') !!}</div>

               @endif

               <form action="{{ route('networks.create') }}" method="POST" accept-charset="utf-8">
                @csrf
                    <div class="form-group">
                          <label class="form-label">Location</label>
                          <select name="dcid" id="select-countries" id="select-beast" class="form-control custom-select">
                            @forelse ( $regions as $region )
                      <option value="{{ $region['DCID'] }}" data-data='{"image": "{{ asset( 'images/flags/'.strtolower($region['country'].'.svg') ) }}"}'>{{ $region['country'] }} - {{ $region['name'] }}</option>
                            @empty
                              Regions not found
                            @endforelse
                          </select>
                    </div>
                    <div class="form-group">
                          <label class="form-label">Description</label>
                          <input class="form-control" name="description" placeholder="Network description" type="text">
                    </div>

                    <div class="form-group">
                          <label class="form-label">v4 Subnet</label>
                          <input class="form-control" name="v4subnet" placeholder="Network V4 subnet" type="text">
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Add Private Network " onclick="this.disabled = true;this.value = 'Please wait...'">
                    </div>

               </form>

              </div>
            </div>
         </div>
      </div>

      <script type="text/javascript">

                    require(['jquery', 'selectize'], function ($, selectize) {

                    $(document).ready(function () {

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

@endsection