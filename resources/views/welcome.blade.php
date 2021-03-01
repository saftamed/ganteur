<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Laravel</title>
    <!--    <link rel="stylesheet" href="{{asset('css/app.css') }}"> -->
        <link rel="stylesheet" href="{{asset('css/styles.css') }}">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="shortcut icon" href="f.ico" type="image/x-icon">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>


        
    </head>
    <body class="sb-nav-fixed">
        <div id="app">
          <div v-if="c">
            <navcomponent v-on:update="setc2"></navcomponent>
          </div>
          <div v-else> 
            <logincomponent v-on:update="setc" ></logincomponent>
          </div>
            
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
       <script src="{{ asset('js/app.js')}}"></script>
       <script src="{{ asset('js/scripts.js')}}"></script>
    </body>
</html>
