@extends('layouts.main')
@section('content')
<input type="hidden" id="survey_id" value="{{ $survey->id }}">
<form class=" w-[60vw] mx-auto my-8 px-20 py-12 border border-gray-100 rounded-md shadow-md flex flex-col" action="/api/survey/{{ $survey->id }}"  method="PUT" id="survey_form">
  <input type="text" name="name" id="survey_name" class="p-2 border-b border-b-gray-300 my-4 focus:border-b focus:border-b-gray-600 focus:outline-none" value="{{ $survey->name }}">
  <input type="text" name="description" id="survey_description" class="p-2 border-b border-b-gray-300 my-4 focus:border-b focus:border-b-gray-600 focus:outline-none" value="{{ $survey->description }}">

  <select name="survey_category_id" id="survey_category_id" class="p-2 border border-gray-300 my-4 focus:border-b focus:border-b-gray-600 focus:outline-none">
    @foreach ($categories as $category)
      <option value="{{ $category->id }}" {{ $survey->survey_category_id == $category->id ? 'selected' : '' }} >{{ $category->name }}</option>
    @endforeach
  </select>

  <button type="button" id="question_add" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-4">Buat Pertanyaan</button>
</form>

@php
  $select=['text', 'radio', 'checkbox','select','textarea', 'number', 'date', 'time', 'datetime', 'email', 'url', 'tel'];

  $typeOptions= ['radio', 'checkbox', 'select'];
@endphp

@if ($survey->surveyQuestions->count() > 0)
  @foreach ($survey->surveyQuestions as $question)
    <form class=" w-[60vw] mx-auto my-8 px-20 py-12 border border-gray-100 rounded-md shadow-md flex flex-col question-form"  action="/api/survey/{{ $survey->id }}/question/{{ $question->id }}" method="PUT" id="question_form_{{ $question->id }}">
      <div class="flex">
        <input type="text" name="question" id="question_{{ $question->id }}" class="p-2 border-b border-b-gray-300 my-4 focus:border-b focus:border-b-gray-600 focus:outline-none w-4/5" value="{{ $question->question }}">
        <select name="type" id="type_{{ $question->id }}" class="p-2 border border-gray-300 my-4 focus:border-b focus:border-b-gray-600 focus:outline-none w-1/5" onchange="changeInput('{{ $question->id }}')">
          @foreach ($select as $item)
            <option value="{{ $item }}" {{ $question->type == $item ? 'selected' : '' }} >{{ $item }}</option>
          @endforeach
        </select>
      </div>
      <input type="{{ $question->type }}" name="answer_{{ $question->id }}" class="p-2 border-b border-b-gray-300 my-4 focus:border-b focus:border-b-gray-600 focus:outline-none {{ in_array($question->type, $typeOptions) ? 'hidden' : '' }}" placeholder="Type Jawaban" disabled>

      <div class="flex flex-col {{ in_array($question->type, $typeOptions) ? '' : 'hidden' }}" id="options_{{ $question->id }}">
        @php
          $count = 1;
        @endphp
        @foreach ($question->options as $option)
          <div class="flex" id="option_place_{{ $option->id }}">
            <input type="{{ $question->type == 'select' ? 'radio' : $question->type }}" name="option_{{ $question->id }}" class="p-2 border-b border-b-gray-300 my-4 focus:border-b focus:border-b-gray-600 focus:outline-none option_{{ $question->id }} w-8" disabled placeholder="{{ $count++ }}" value="{{ $option->id }}" onchange="saveExpected('{{ $question->id }}')" {{ $question->expected->pluck('question_option_id')->contains($option->id) ? 'checked' : '' }}>
            <input type="text" id="option_label_{{ $option->id }}" class="p-2 border-b border-b-gray-300 my-4 focus:border-b focus:border-b-gray-600 focus:outline-none " value="{{ $option->option }}" onchange="changeOption('{{ $option->id }}')">
            <button type="button" class="bg-red-400 hover:bg-red-500 text-white font-bold py-2 px-4 rounded my-4" onclick="deleteOption('{{ $option->id }}')">Hapus</button>
            

          </div>
        @endforeach
        <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-2" onclick="addOption('{{ $question->id }}')">Tambah Opsi</button>
        <button type="button" class="bg-red-400 hover:bg-red-500 text-white font-bold py-2 px-4 rounded my-2" onclick="deleteQuestion('{{ $survey->id }}','{{ $question->id }}')">Hapus Pertanyaan</button>
        <button type="button" class="bg-green-400 hover:bg-green-500 text-white font-bold py-2 px-4 rounded my-2" onclick="makeQuestion('{{ $question->id }}')">Buat Jawaban</button>

      </div>
      
    </form>
  @endforeach
@endif

@section('scripts')
<script src="{{ asset('js/survey/new/edit.js') }}"></script>
@endsection
@endsection