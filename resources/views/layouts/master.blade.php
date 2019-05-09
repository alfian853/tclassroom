<html>
  <head>
    <title>Tclassroom - @yield('title')</title>
    @section('add-script')
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.5.1/css/iziModal.min.css" />
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.5.1/js/iziModal.min.js"></script>

      @show
  </head>
  <body style="margin-top:56px;">

    @include('layouts.navbar')

    @if(!empty(Session::has('alert')))
      @if (Session::get('alert-type') == 'success')
        <div class="alert alert-success alert-dismissible fixed-top" style="margin-top:60px;">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success!</strong> {{ Session::get('alert') }}
        </div>
      @elseif (Session::get('alert-type') == 'failed')
        <div class="alert alert-danger alert-dismissible fixed-top" style="margin-top:60px;">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Error!</strong> {{ Session::get('alert') }}
        </div>
      @elseif (Session::get('alert-type') == 'warning')
        <div class="alert alert-warning alert-dismissible fixed-top" style="margin-top:60px;">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Warning!</strong> {{ Session::get('alert') }}
        </div>
      @endif
    @endif

    @yield('content')
    {{--<script src="{{asset('js/master.js')}}"></script>--}}

  </body>

</html>
