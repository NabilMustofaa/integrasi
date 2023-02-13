<?php

namespace App\Http\Controllers;

use App\Models\SurveyPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SurveyPlanApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans=DB::SELECT('
            SELECT 
                survey_plans.id,
                surveys.name AS survey_name,
                stores.name AS store_name,
                quality_assurance_teams.name AS qa_name,
                survey_plans.date
            FROM survey_plans
            JOIN surveys ON survey_plans.survey_id = surveys.id
            JOIN stores ON survey_plans.store_id = stores.id
            JOIN quality_assurance_teams ON survey_plans.quality_assurance_team_id = quality_assurance_teams.id
        ');
        return response()->json($plans);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'survey_id' => 'required',
            'store_ids' => 'array|required',
            'quality_assurance_team_id' => 'required',
            'date' => 'required',
        ]);
        $stores = $request->store_ids;

        foreach ($stores as $store) {
            $plan = [
                'survey_id' => $request->survey_id,
                'store_id' => $store,
                'quality_assurance_team_id' => $request->quality_assurance_team_id,
                'date' => $request->date,
            ];
            SurveyPlan::create($plan);
        }

        return response()->json([
            'message' => 'Survey plan created successfully',
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SurveyPlan  $surveyPlan
     * @return \Illuminate\Http\Response
     */
    public function show(SurveyPlan $surveyPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SurveyPlan  $surveyPlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SurveyPlan $surveyPlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SurveyPlan  $surveyPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(SurveyPlan $surveyPlan)
    {
        //
    }

    public function storeSnapshot(SurveyPlan $surveyPlan, Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);

        $img= $request['file'];
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
            
        $image_base64 = base64_decode($image_parts[1]);
        $current_date= date('YmdHis');
        $file = 'snapshot/'.$surveyPlan->id.'-'.$current_date.'.png';
        Storage::disk('public')->put($file, $image_base64);

        $surveyPlan->photo = $file;
        $surveyPlan->save();

        
        return response()->json([
            'message' => 'Snapshot saved successfully',
        ]);
    }
}
