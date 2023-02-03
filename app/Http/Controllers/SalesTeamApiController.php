<?php

namespace App\Http\Controllers;

use App\Models\SalesTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesTeamApiController extends Controller
{
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales=DB::SELECT('
        SELECT 
            sales_teams.id,
            sales_teams.name,
            sales_teams.address,
            sales_teams.phone
        FROM sales_teams');
        return response()->json($sales);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->name == null) {
            return response()->json(['message' => 'Name is required'], 400);
        }
        else if ($request->address == null) {
            return response()->json(['message' => 'Address is required'], 400);
        }
        else if ($request->phone == null) {
            return response()->json(['message' => 'Phone is required'], 400);
        }
        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);
        $validated['created_by'] = 1;
        $sales = SalesTeam::create($validated);

        return response()->json([
            'message' => 'Sales Team created successfully',
            'data' => $sales
        ], 201);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SalesTeam  $salesTeam
     * @return \Illuminate\Http\Response
     */
    public function show(SalesTeam $salesTeam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SalesTeam  $salesTeam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalesTeam $salesTeam)
    {
        if ($request->name == null) {
            return response()->json(['message' => 'Name is required'], 400);
        }
        else if ($request->address == null) {
            return response()->json(['message' => 'Address is required'], 400);
        }
        else if ($request->phone == null) {
            return response()->json(['message' => 'Phone is required'], 400);
        }

        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        $validated['created_by'] = 1;
        $sales=$salesTeam->update($validated);

        return response()->json([
            'message' => 'Updated successfully',
            'data' => $sales
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SalesTeam  $salesTeam
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesTeam $salesTeam)
    {

        $salesTeam->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}

