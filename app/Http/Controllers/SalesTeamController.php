<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesTeamController extends Controller
{
    public function index()
    {
        return view('sales.index');
    }
}
