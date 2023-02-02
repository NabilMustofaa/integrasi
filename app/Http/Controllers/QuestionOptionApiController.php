<?php

namespace App\Http\Controllers;

use App\Models\QuestionOption;
use App\Models\SurveyQuestion;
use Illuminate\Http\Request;

class QuestionOptionApiController extends Controller
{
    function index (SurveyQuestion $surveyQuestion) {
        $options = $surveyQuestion->options;
        return response()->json($options, 200);
    }
    function store (SurveyQuestion $surveyQuestion, Request $request) {
        
        if ($request->option == null) {
            return response()->json([
                'message' => 'option label is required',
            ], 400);
        }

        $option = QuestionOption::create([
            'survey_question_id' => $surveyQuestion->id,
            'option' => $request->option,
            'created_by' => 1,
        ]);

        return response()->json($option, 201);
    }

    function update (QuestionOption $questionOption, Request $request) {
        $questionOption->update([
            'option' => $request->option,
        ]);
        return response()->json($questionOption, 200);
    }

    function destroy (QuestionOption $questionOption) {
        $questionOption->delete();
        return response()->json(null, 204);
        
    }

}
