<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyCategory;
use Illuminate\Http\Request;

class SurveyNewController extends Controller
{
    public function index()
    {
        return view('survey-new.index');
    }

    public function edit(Survey $survey)
    {
        $categories=SurveyCategory::all();
        return view('survey-new.edit', compact('survey','categories'));
    }
}
