<?php

namespace App\Http\Controllers;

use App\Models\SurveyAnswer;
use App\Models\SurveyPlan;
use App\Models\SurveyQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyAnswerApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SurveyPlan $surveyPlan,SurveyQuestion $surveyQuestion)  
    {
        $query = DB::SELECT("
        SELECT  survey_answers.id,
                survey_answers.survey_plan_id,
                survey_answers.survey_question_id,
                survey_answers.answer,
                survey_answers.question_option_id
        FROM survey_answers 
        WHERE   survey_plan_id = $surveyPlan->id 
                AND survey_question_id = $surveyQuestion->id");

        return response()->json($query, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SurveyPlan $surveyPlan, SurveyQuestion $surveyQuestion, Request $request)
    {
       
        $surveyAnswer=[
            'survey_plan_id' => $surveyPlan->id,
            'survey_question_id' => $surveyQuestion->id,
            'answer' => $request->answer,
            'question_option_id' => $request->question_option_id,
            'created_by' => '1'
        ];

        $answer = SurveyAnswer::create($surveyAnswer);

        return response()->json($answer, 201);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SurveyAnswer  $surveyAnswer
     * @return \Illuminate\Http\Response
     */
    public function show(SurveyAnswer $surveyAnswer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SurveyAnswer  $surveyAnswer
     * @return \Illuminate\Http\Response
     */
    public function update(SurveyPlan $surveyPlan, SurveyQuestion $surveyQuestion, SurveyAnswer $surveyAnswer, Request $request)
    {
        $answer = [
            'survey_plan_id' => $surveyPlan->id,
            'survey_question_id' => $surveyQuestion->id,
            'answer' => $request->answer,
            'question_option_id' => $request->question_option_id,
            'updated_by' => '1'
        ];

        $surveyAnswer->update($answer);

        return response()->json($surveyAnswer, 200);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SurveyPlan  $surveyPlan
     * @param  \App\Models\SurveyQuestion  $surveyQuestion
     * @param  \App\Models\SurveyAnswer  $surveyAnswer
     * @return \Illuminate\Http\Response
     */
    public function destroy( SurveyPlan $surveyPlan, SurveyQuestion $surveyQuestion ,SurveyAnswer $surveyAnswer)
    {
        $surveyAnswer->delete();

        return response()->json(null, 204);
    }
}
