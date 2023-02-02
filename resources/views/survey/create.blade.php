@extends('layouts.main')
@section('content')
<h1 class=" text-3xl font-bold"> Survey</h1>

<form action="/survey" method="POST" class="flex flex-col" id="form_survey">
  <div class="flex flex-col">
    <label for="title">Title</label>
    <input type="text" name="name" id="name" class="border border-gray-500 rounded-md shadow-md">
  </div>
  <div class="flex flex-col">
    <label for="survey_category_id">Category</label>
    <select name="survey_category_id" id="survey_category_id" class="border border-gray-500 rounded-md shadow-md">
      @foreach ($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
        
      @endforeach
    </select>
  </div>
  <div class="flex flex-col">
    <label for="description">Description</label>
    <textarea name="description" id="description" cols="30" rows="10" class="border border-gray-500 rounded-md shadow-md"></textarea>
  </div>
  <button class=" flex justify-between bg-red-400 rounded-md h-8 hover:bg-red-300 w-40 my-2" id="survey_button">
    <div class=" h-12 border-r-2 border-r-white py-1 px-1">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 my-auto text-white" fill="white" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
      </svg>
    </div>
    <p class=" align-middle text-center my-auto px-2 text-white" >Create Survey</p>
  </button>

</form>

<div id="survey_question" class="hidden">
  <h1 class=" text-3xl font-bold"> Survey Question</h1>
  
  <form action="" method="POST" class="flex flex-col" id="form_survey_question">
    <div class="flex flex-col">
      <label for="title">Question</label>
      <input type="text" name="question" id="question" class="border border-gray-500 rounded-md shadow-md">
    </div>
    <div class="flex flex-col">
      <label for="type">Category</label>
      <select name="type" id="type" class="border border-gray-500 rounded-md shadow-md">
        @foreach ($types as $type)
          <option value="{{ $type }}">{{ $type }}</option>
        @endforeach
      </select>
    </div>
    <button class=" flex justify-between bg-red-400 rounded-md h-8 hover:bg-red-300 w-60 my-2" id="survey_question_button">
      <div class=" h-12 border-r-2 border-r-white py-1 px-1">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 my-auto text-white" fill="white" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
      </div>
      <p class=" align-middle text-center my-auto px-2 text-white" >Create Question</p>
    </button>
  </form>

</div>

<div id="preview_question">
  <h1 class=" text-3xl font-bold"> Preview Question</h1>
</div>



@section('scripts')
<script src="{{ asset('js/survey/survey.js') }}"> </script>
@endsection

@endsection