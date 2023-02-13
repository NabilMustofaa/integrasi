<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyApiController extends Controller
{
    public function index ()
    {
        $surveys = DB::SELECT(
            'SELECT 
                surveys.id,
                surveys.name, 
                surveys.description, 
                survey_questions.question,
                survey_questions.type,
                survey_questions.id as question_id
            FROM surveys 
            LEFT JOIN survey_questions ON survey_questions.survey_id = surveys.id
            '
        );
        return response()->json($surveys, 200);
    }

    public function indexHierarchy ()
    {
        $surveys = DB::SELECT(
            'SELECT 
                surveys.id,
                surveys.name as name
            FROM surveys'
        );

        foreach ($surveys as $survey) {
            $survey->questions = DB::SELECT(
                'SELECT 
                    survey_questions.id,
                    survey_questions.question as name
                FROM survey_questions
                WHERE survey_questions.survey_id = :survey_id',
                ['survey_id' => $survey->id]
            );
        }

        return response()->json($surveys, 200);
    }

    public function store(Request $request)
    {
        if ($request->name == null) {
            return response()->json([
                'message' => 'name is required',
            ], 400);
        }
        else if ($request->description == null) {
            return response()->json([
                'message' => 'description is required',
            ], 400);
        }
        $survey = Survey::create([
            'name' => $request->name,
            'description' => $request->description,
            'survey_category_id' => $request->survey_category_id,
            'created_by' => 1,
        ]);

        return response()->json($survey, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey)
    {;
        return response()->json($survey, 200); 
    }
    public function update(Request $request, Survey $survey)
    {   
        if ($request->name == null) {
            return response()->json([
                'message' => 'name is required',
            ], 400);
        }
        else if ($request->description == null) {
            return response()->json([
                'message' => 'description is required',
            ], 400);
        }
        $survey->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return response()->json($survey, 200);
    }


    public function destroy(Survey $survey)
    {
        $survey->delete();
        return response()->json([
            'message' => 'Survey deleted successfully',
        ], 204);
    }
}
