<?php

namespace App\Http\Controllers;

use App\Models\SurveyPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyPlanController extends Controller
{
    public function index()
    {
        return view('plan.index');
    }

    public function create()
    {
        $surveys=DB::SELECT('
            SELECT 
                surveys.id,
                surveys.name
            FROM surveys
        ');

        $qualityAssuranceTeams=DB::SELECT('
            SELECT 
                quality_assurance_teams.id,
                quality_assurance_teams.name
            FROM quality_assurance_teams
        ');
        return view('plan.create', compact('surveys','qualityAssuranceTeams'));
    }

    public function show (SurveyPlan $plan)
    {
        $survey = $plan->survey;
        $category = $survey->surveyCategory;
        $questions = $survey->surveyQuestions;
        return view('plan.show', compact('plan','survey','category','questions'));
    }
}
