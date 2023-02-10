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
    <div class=" mt-8 flex flex-col-reverse h-[80vh] gap-8">
        <form action="/api/plans" method="POST" id="list" class="flex w-full h-1/2 bg-white border border-gray-100 shadow-md rounded-md gap-8 p-4">
            <div class="w-1/2">
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
            <div class="w-1/2">
                <div id="dataGrid"></div>
            </div>
        </form>


        <div id="map" class="w-full h-1/2"></div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/plan/create.js') }}"></script>
@endsection
