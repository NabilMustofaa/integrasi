<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>

  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
 
  <!-- DevExtreme theme -->
  <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/22.2.4/css/dx.light.css">

  <!-- DevExtreme library -->
  <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/22.2.4/js/dx.all.js"></script>

  @yield('styles')
</head>
<body class=" h-screen w-screen dx-viewport">
  
  @include('partials.nav')
  <div class=" flex w-screen">
    <div class="w-1/6">
      @include('partials.sidebar')
    </div>
    <div class="w-5/6 mt-16 p-12">
      @yield('content')
    </div>

  </div>
  
  <div class="text-red-400 underline gap-2 text-green-400"></div>

  @vite('resources/js/app.js')


  @yield('scripts')
  
</body>
</html>