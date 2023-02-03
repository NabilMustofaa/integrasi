<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QualityAssuranceTeamController extends Controller
{
    public function index()
    {
        return view('qa.index');
    }
}
