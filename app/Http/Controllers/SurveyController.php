<?php

namespace App\Http\Controllers;

use App\Models\SurveyCategory;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index()
    {
        return view('survey.index');
    }

    public function create()
    {
        $categories = SurveyCategory::all();
        return view('survey.create', compact('categories'));
    }
}
