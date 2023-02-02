@extends('layouts.main')

@section('styles')
<!-- Map Box -->
<script src='https://api.mapbox.com/mapbox-gl-js/v2.12.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.12.0/mapbox-gl.css' rel='stylesheet' />
<script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.js'></script>
<link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.css' type='text/css' />


@endsection

@section('content')
<h1 class=" text-3xl font-bold"> Store</h1>

<div class="flex justify-between">
  <form action="/store" method="POST" class="w-1/2">
    @csrf
    <label for="name" class="block">Name</label>
    <input type="text" name="name" placeholder="Name" class="border p-2 w-full my-2">
    <label for="address" class="block">Address</label>
    <input type="text" name="address" placeholder="Address" class="border p-2 w-full my-2">
    <label for="phone" class="block">Phone</label>
    <input type="text" name="phone" placeholder="Phone" class="border p-2 w-full my-2">
    <label for="email" class="block">Sales</label>
    <select name="sales_team_id" id="sales_team_id" class="border p-2 w-full my-2"
      <option value="">Select Sales Team</option>
      @foreach ($salesTeams as $salesTeam)
      <option value="{{ $salesTeam->id }}">{{ $salesTeam->name }}</option>
      @endforeach
    </select>
    <label for="email" class="block">Position></label>
    <div class="flex">
      <input type="text" name="longitude" placeholder="Longitude" class="border p-2 w-2/5 my-2">
      <input type="text" name="latitude" placeholder="Latitude" class="border p-2 w-2/5 my-2">
      <button type="button" class="bg-blue-500 text-white px-4 rounded font-medium w-1/5" id="get-location">Get Location</button>
    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded font-medium">Submit</button>

  </form>
  <div style="w-full h-full">
    <div id='map' class=" h-96 w-[40rem] mx-12 my-4"></div>
  </div>
</div>

@endsection

@section('scripts')
<script src='https://unpkg.com/@turf/turf@6/turf.min.js'></script>
<script src="{{ asset('js/map/map.js') }}"></script>
@endsection