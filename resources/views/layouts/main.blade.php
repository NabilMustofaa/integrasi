<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')  
  
  <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>

  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
 
  <!-- DevExtreme theme -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/22.2.4/css/dx.light.compact.css" rel="stylesheet">

  <!-- DevExtreme library -->
  <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/22.2.4/js/dx.all.js"></script>

  @yield('styles')
  

</head>
<body class=" h-screen w-screen dx-viewport">
  
  @include('partials.nav')
  <div class=" flex w-screen">
    <div class="w-1/6 max-md:w-1/2 max-md:absolute z-10 bg-white shadow-md max-md:-translate-x-full transition-all duration-500 ease-in-out transform" id="sidebar-placeholder">
      @include('partials.sidebar')
    </div>
    <div class="w-5/6 max-md:w-full p-12 pt-20 max-md:p-4 max-md:pt-20 h-screen overflow-auto" id="main_content">
      @yield('content')
    </div>

  </div>
  
  
  @vite('resources/js/app.js')



  @yield('scripts')

  <script src="{{ asset('js/dashboard.js') }}"></script>
  
</body>
</html>