@extends('layouts.main')
@section('content')


<div class=" flex justify-between">
  <h1 class=" text-3xl font-bold"> Survey</h1>
  <button class="flex justify-between bg-red-400 rounded-md h-8 hover:bg-red-300" id="survey">
    <div class=" h-12 border-r-2 border-r-white py-1 px-1">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 my-auto text-white" fill="white" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
      </svg>
    </div>
    <a class=" align-middle text-center my-auto px-2 !text-white" href="/survey/create">Create Survey</a>
  </button>

</div>
<div id="dataGrid"></div>

<div id="popup"></div>

<script src="{{ asset('js/survey/new/index.js') }}"></script>

@endsection