@extends('layouts.main')
@section('content')
<h1 class=" text-3xl font-bold"> Survey</h1>

<form action="/survey" method="POST" class="flex flex-col">
  @csrf
  <div class="flex flex-col">
    <label for="title">Title</label>
    <input type="text" name="title" id="title" class="border border-gray-500 rounded-md shadow-md">
  </div>
  <div class="flex flex-col">
    <label for="survey_category_id">Category</label>
    <select name="survey_category_id" id="survey_category_id" class="border border-gray-500 rounded-md shadow-md h-32">
      {{-- @foreach ($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
        
      @endforeach --}}
    </select>
  </div>
  <div class="flex flex-col">
    <label for="description">Description</label>
    <textarea name="description" id="description" cols="30" rows="10" class="border border-gray-500 rounded-md shadow-md"></textarea>
  </div>
  <button class=" flex bg-red-400 rounded-md h-8 hover:bg-red-300 w-20" id="survey">
    <div class=" h-12 border-r-2 border-r-white py-1 px-1">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 my-auto text-white" fill="white" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
      </svg>
    </div>
    <p class=" align-middle text-center my-auto px-2 text-white" >Create Survey</p>
  </button>

</form>





@endsection