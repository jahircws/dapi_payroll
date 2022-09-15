<!DOCTYPE html>
<html lang="en">


<!-- index.html  21 Nov 2019 03:44:50 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="{{asset('assets/css/app.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/components.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
  <link rel='shortcut icon' type='image/x-icon' href='{{asset('assets/img/favicon.ico')}}' />
  <script>var baseURL = '{{url('')}}';</script>
  @yield('pageStyles')
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      @include('includes.header')
      @include('includes.sidebar')
	  
      <div class="main-content">
        @yield('content')
      </div>
      @include('includes.footer')
    </div>
  </div>
  <script src="{{asset('assets/js/app.min.js')}}"></script>
  <script src="{{asset('assets/bundles/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('assets/js/page/index.js')}}"></script>
  <script src="{{asset('assets/js/scripts.js')}}"></script>
  <script src="{{asset('assets/js/custom.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.33/dist/sweetalert2.all.min.js"></script>
  @yield('pageScripts')
</body>
</html>