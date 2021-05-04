<!DOCTYPE html>
<html lang="en">

<head>
  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--Import materialize.css-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> --}}
  <script src="https://www.google.com/recaptcha/api.js"></script>
  <link rel="stylesheet" href="{{secure_asset('css/style.css')}}">
  <title> {{ config('app.name') }}</title>
  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://services.webchin.org/web-fonts/web-font?font=UniQAIDAR_DARA" rel="stylesheet" type="text/css">
  <style>
    html,
    body,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      font-family: "UniQAIDAR_DARA" !important;
    }

    .carousel .carousel-item {
      opacity: 1 !important;
    }

    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
    }

    /* Always set the map height explicitly to define the size of the div
 * element that contains the map. */
    #map {
      height: 100%;
    }
  </style>
</head>

<body style="background-color: #FAFAFA">
  @include('website.layout.navbar')
  @if (isset($b_title))
  <div class="banner light-grey">
    <h5 id="b_title">{{$b_title ?? ''}}</h5>
    <p id="b_disc">{{$b_disc ?? ''}}</p>
  </div>
  <br>
  @endif
  @yield('content')
  @include('website.layout.footer')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script>
    $(document).ready(function () {
      
        $(".dropdown-trigger").dropdown();
        $('.sidenav').sidenav();
        $('.tabs').tabs();
        $('.slider').slider();
        $('.parallax').parallax();
        $('.collapsible').collapsible();
        $('.carousel').carousel();
        $('.select').formSelect();
        $('.timepicker').timepicker();
        $('.datepicker').datepicker();
        $('.tooltipped').tooltip();
        $('.carousel').carousel({

          dist: 0
          ,
          padding: 30,
          numVisible: 8,

        });
        var time = new Date();
        $('.datepicker').datepicker({
                minDate: new Date(time.getFullYear(),time.getMonth(),time.getDate()),
            });
      });
      $('.modal').modal();
      function toastShow(el){
        M.toast({html: el, classes: 'rounded'});
      }
  </script>
  @isset($footer_visible)
  @if ($footer_visible)
  <script>
    var footer = document.getElementById('footer');
   footer.remove();
  </script>
  @endif
  @endisset


  @include('website.layout.messages')
</body>

</html>