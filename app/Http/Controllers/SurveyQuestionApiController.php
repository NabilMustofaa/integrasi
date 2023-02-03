<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyQuestion;
use Illuminate\Http\Request;

class SurveyQuestionApiController extends Controller
{
    function index (Survey $survey) {
        $questions = $survey->questions;
        return response()->json($questions, 200);
    }
    function store (Survey $survey, Request $request) {
        if ($request->type == null) {
            return response()->json([
                'message' => 'type is required',
            ], 400);
        }
        else if ($request->question == null) {
            return response()->json([
                'message' => 'question is required',
            ], 400);
        }
        $question = SurveyQuestion::create([
            'question' => $request->question,
            'survey_id' => $survey->id,
            'type' => $request->type,
            'created_by' => 1,
        ]);

        return response()->json($question, 201);
    }
    function show (Survey $survey, SurveyQuestion $surveyQuestion){
        $option = $surveyQuestion->options;
        $expected = $surveyQuestion->expected;
        $surveyQuestion["options"]=$option;
        $surveyQuestion["expected"]=$expected;
        return response()->json($surveyQuestion, 201);


    }
    function update (SurveyQuestion $surveyQuestion, Request $request) {
        if ($request->type == null) {
            return response()->json([
                'message' => 'type is required',
            ], 400);
        }
        else if ($request->question == null) {
            return response()->json([
                'message' => 'question is required',
            ], 400);
        }
        $surveyQuestion->update([
            'type' => $request->type,
            'question' => $request->question,
        ]);
        return response()->json($surveyQuestion, 200);
    }

    function destroy (Survey $survey,SurveyQuestion $surveyQuestion) {
        $surveyQuestion->delete();
        return response()->json([
            'message' => 'Question deleted successfully',
        ], 204);  
    }
}
