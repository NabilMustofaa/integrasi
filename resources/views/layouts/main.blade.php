<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
</head>
<body class=" h-screen w-screen">
  
  @include('partials.nav')
  <div class=" flex w-screen">
    <div class="w-1/6">
      @include('partials.sidebar')
    </div>
    <div class="w-5/6 mt-16 p-12">
      @yield('content')
    </div>

  </div>
  
  

  @vite('resources/js/app.js')
  <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>

  @yield('scripts')
  
</body>
</html>