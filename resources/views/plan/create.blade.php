@extends('layouts.main')

@section('styles')
    <!-- Map Box -->
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.12.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.12.0/mapbox-gl.css' rel='stylesheet' />
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.js'></script>
    <link rel='stylesheet'
        href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.css'
        type='text/css' />
    <script src='https://npmcdn.com/@turf/turf/turf.min.js'></script>

    <style>
        .store-marker {
            background-color: #3FB1CE;

            width: 20px;
            height: 20px;
            border-radius: 50%;
            cursor: pointer;
        }
        .branch-marker {
            background-color: #F6A623;

            width: 20px;
            height: 20px;
            border-radius: 50%;
            cursor: pointer;
        }

        .clicked {
            opacity: 0 !important;
        }
    </style>
@endsection

@section('content')
    <div class=" flex justify-between">
        <h1 class=" text-3xl font-bold"> Plan</h1>
        <div id="notification"></div>
    </div>
    <div class=" flex flex-col mt-12 h-[80vh] max-md:h-full gap-8">
        <div id="map" class="w-full h-1/2"></div>
        <form action="/api/plans" method="POST" id="list" class="flex flex-row-reverse w-full bg-white border max-md:h-1/2 border-gray-100 shadow-md rounded-md gap-8 p-4 max-md:flex-col overflow-auto">
            <div class="w-1/2 max-md:w-full">
                <div id="dataGrid"></div>
            </div>
            <div class="w-1/2 max-md:w-full">
                <label for="survey_id" class="block font-medium mb-4 text-gray-700">Survey</label>
                <select name="survey_id" id="survey_id" class="border p-2 w-full my-2">
                    <option value="0">Select Survey</option>
                    @foreach ($surveys as $survey)
                        <option value="{{ $survey->id }}">{{ $survey->name }}</option>
                    @endforeach
                </select>
                <label for="quality_assurance_team_id" class="block font-medium mb-4 text-gray-700">Quality Assurance
                    Team</label>
                <select name="quality_assurance_team_id" id="quality_assurance_team_id" class="border p-2 w-full my-2">
                    <option value="0">Select Quality Assurance Team</option>
                    @foreach ($qualityAssuranceTeams as $qualityAssuranceTeam)
                        <option value="{{ $qualityAssuranceTeam->id }}">{{ $qualityAssuranceTeam->name }}</option>
                    @endforeach
                </select>

                <label for="date" class="block font-medium mb-4 text-gray-700">Date</label>

                <input type="date" name="date" id="date" class="border p-2 w-full my-2" placeholder="Date">
    
                <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    onclick="sendForm()">Submit</button>
            </div>
           
        </form>


        
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/plan/create.js') }}"></script>
@endsection
