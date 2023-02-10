@extends('layouts.main')


@section('content')
<h1>Fill form</h1>

<video autoplay="true" class="w-full"></video>
<div id="error-placeholder" class="w-full bg-red-400 text-center text-white align-middle py-2 hidden"></div>
<div class="flex" >
  <select id="camera-select" class="border p-2 w-2/3 my-2 rounded-sm" ></select>
  <button id="snapshot-button" class=" bg-blue-500 w-1/3 my-2 text-white rounded-sm" disabled >Ambil Gambar</button>
</div>

<div id="snapshot" class="w-full" src="" alt="">
</div>

<div class="w-full" id="form">
  <input type="hidden" id="survey_id" value="{{ $survey->id }}">

  <div class=" w-full mx-auto my-8 px-20 py-12 max-md:px-4 max-md:py-2 border border-gray-100 rounded-md shadow-md flex flex-col" action="/api/survey/{{ $survey->id }}"  method="PUT" id="survey_form">
    <h1 class="p-2 border-b border-b-gray-300 my-4 focus:border-b focus:border-b-gray-600 focus:outline-none max-md:!text-lg max-md:!font-medium">{{ $survey->name }}</h1>
    <p class="p-2 border-b border-b-gray-300 my-4 focus:border-b focus:border-b-gray-600 focus:outline-none max-md:!text-sm max-md:!font-medium">
      {{ $survey->description }}
    </p>
    <p class="p-2 border-b border-b-gray-300 my-4 focus:border-b focus:border-b-gray-600 focus:outline-none max-md:!text-sm">
      {{ $category->name }}
    </p>
  </div>
  
  @foreach ($questions as $question)
    <form action="/api/question/{{ $question->id }}/answer"  method="PUT" id="survey_form_{{ $question->id }}">
      <div class=" w-full mx-auto my-8 px-20 py-12 border border-gray-100 rounded-md shadow-md flex flex-col max-md:px-4 max-md:py-2 max-md:text-sm" >
        <h1 class="p-2 max-md:!text-base max-md:!font-medium">{{ $question->question }}</h1>
        <div class="flex flex-col">
          @if ($question->type == 'radio' || $question->type == 'checkbox' || $question->type == 'select')
          @foreach ($question->options as $option)
            <div class="flex flex-row">
              <input type="{{ $question->type }}" name="option" value="{{ $option->id }}" class="my-auto">
              <p class="p-2 my-4 max-md:text-sm max-md:!my-2">
                {{ $option->option }}
              </p>
            </div>
          @endforeach
          @else
            <input type="{{ $question->type }}" name="option" class="p-2 border-b border-b-gray-300 my-4 focus:border-b focus:border-b-gray-600 focus:outline-none">
          @endif
        </div>
      </div>
    </form>
    
  @endforeach
</div>




@endsection

@section('scripts')
<script src="{{ asset('js/plan/show.js') }}"></script>
@endsection
