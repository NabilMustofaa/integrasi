@extends('layouts.main')

@section('styles')
<!-- Map Box -->
<script src='https://api.mapbox.com/mapbox-gl-js/v2.12.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.12.0/mapbox-gl.css' rel='stylesheet' />
<script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.js'></script>
<link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.css' type='text/css' />

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
 
<!-- DevExtreme theme -->
<link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/22.2.4/css/dx.light.css">

<!-- DevExtreme library -->
<script type="text/javascript" src="https://cdn3.devexpress.com/jslib/22.2.4/js/dx.all.js"></script>

@endsection

@section('content')
<h1 class=" text-3xl font-bold"> Store</h1>

<div class=" flex">
  <button class="flex justify-between bg-red-400 rounded-md h-8 hover:bg-red-300" id="survey">
    <div class=" h-12 border-r-2 border-r-white py-1 px-1">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 my-auto text-white" fill="white" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
      </svg>
    </div>
    <a class=" align-middle text-center my-auto px-2 !text-white " href="/store/create  ">Create Survey</a>
  </button>

</div>
<div class="flex h-96">
  <div id="dataGrid" class="w-1/2"></div>
  <div id="map" class="w-1/2"></div>
</div>


@endsection

@section('scripts')
<script src="{{ asset('js/map/index.js') }}"></script>
@endsection