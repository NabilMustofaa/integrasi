<?php

namespace App\Http\Controllers;

use App\Models\SurveyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    public function index()
    {
        return view('survey.index');
    }

    public function create()
    {
        $categories = SurveyCategory::all();
        $types=['text', 'number', 'date', 'time', 'datetime', 'email', 'tel', 'url', 'radio', 'checkbox', 'select', 'textarea'];
        return view('survey.create', compact('categories', 'types'));
    }

    public function onePage()
    {
        $categories = SurveyCategory::all();
        $types=['text', 'number', 'date', 'time', 'datetime', 'email', 'tel', 'url', 'radio', 'checkbox', 'select', 'textarea'];
        return view('SurveyOnePage.index', compact('categories', 'types'));
    }
}
