<?php

namespace App\Http\Controllers;

use App\Models\SalesTeam;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        return view('store.index');
    }

    public function create()
    {
        $salesTeams = SalesTeam::all();
        return view('store.create', compact('salesTeams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'sales_team_id' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);

        Store::create([
            'name' => $request->name,
            'sales_team_id' => $request->sales_team_id,
            'phone' => $request->phone,
            'address' => $request->address,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'created_by' => 1,
        ]);

        return redirect()->route('store.index');
    }
}
