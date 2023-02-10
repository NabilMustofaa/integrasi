<?php

namespace App\Http\Controllers;

use App\Models\QualityAssuranceTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QualityAssuranceTeamApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $qa=DB::SELECT('
        SELECT 
            quality_assurance_teams.id,
            quality_assurance_teams.name,
            quality_assurance_teams.address,
            quality_assurance_teams.phone,
            branches.name AS branch_name
        FROM quality_assurance_teams
        JOIN branches ON quality_assurance_teams.branch_id = branches.id');
        return response()->json($qa);
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
            'branch_id' => 'required',
        ]);
        $validated['created_by'] = 1;
        $qa = QualityAssuranceTeam::create($validated);

        return response()->json([
            'message' => 'Quality Assurance Team created successfully',
            'data' => $qa
        ], 201);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QualityAssuranceTeam  $qualityAssuranceTeam
     * @return \Illuminate\Http\Response
     */
    public function show(QualityAssuranceTeam $qualityAssuranceTeam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QualityAssuranceTeam  $qualityAssuranceTeam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QualityAssuranceTeam $qualityAssuranceTeam)
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
        $qa=$qualityAssuranceTeam->update($validated);

        return response()->json([
            'message' => 'Updated successfully',
            'data' => $qa
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QualityAssuranceTeam  $qualityAssuranceTeam
     * @return \Illuminate\Http\Response
     */
    public function destroy(QualityAssuranceTeam $qualityAssuranceTeam)
    {

        $qualityAssuranceTeam->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
