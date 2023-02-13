<?php

namespace App\Http\Controllers;

use App\Models\ExpectedAnswer;
use App\Models\SurveyQuestion;
use Illuminate\Http\Request;

class ExpectedAnswerApiController extends Controller
{
    function index (SurveyQuestion $surveyQuestion) {
        $expected=$surveyQuestion->expected;
        return response()->json($expected, 200);
    }

    function store (SurveyQuestion $surveyQuestion, Request $request) {
        


        if ($request->question_option_id == null && $request->expected == null) {
            return response()->json(['error' => 'Either question_option_id or expected must be provided'], 400);
        }

        if ($request->question_option_id == null ) {
            $expected = ExpectedAnswer::create([
                'survey_question_id' => $surveyQuestion->id,
                'answer' => $request->expected,
                'created_by' => 1
            ]);
        }
        
        else if ($request->expected == null ) {
            $expected = ExpectedAnswer::create([
                'survey_question_id' => $surveyQuestion->id,
                'question_option_id' => $request->question_option_id,
                'created_by' => 1
            ]);
        }
       
        return response()->json($expected, 201);
    }

    function update (SurveyQuestion $surveyQuestion,ExpectedAnswer $expectedAnswer, Request $request) {
        $expected = [
            'survey_question_id' => $surveyQuestion->id,
            'question_option_id' => $request->question_option_id,
            'answer' => $request->expected,
            'created_by' => 1
        ];

        $expectedAnswer->update($expected);
        return response()->json($expectedAnswer, 200);
        

    }

    function destroy (SurveyQuestion $surveyQuestion,ExpectedAnswer $expectedAnswer) {
        $expectedAnswer->delete();
        return response()->json(null, 204);
    }
}
