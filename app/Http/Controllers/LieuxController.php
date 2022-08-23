<?php

namespace App\Http\Controllers;

use App\Models\Lieux;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class LieuxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lieux = Lieux::all();
        return response()->json($lieux);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lieuValidation = $request->validate([
            "enseigne" => ["required", "string", "max:100"],
            "adresse" => ["required", "string", "max:100"],
            "description"=> ["required", "string", "max:100"],
            "latitude" => ["required", "string", "max:100"],
            "longitude" => ["required", "string", "max:100"],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lieux  $lieux
     * @return \Illuminate\Http\Response
     */
    public function show(Lieux $lieux)
    {
        return response()->json($lieux);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lieux  $lieux
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lieux $lieux)
    {
        $lieux->update([
            "enseigne" => $request->enseigne,
            "adresse" => $request->adresse,
            "description"=>$request->description, 
            "latitude"=>$request->latitude,
            "longitude"=>$request->longitude,
        ]);
        return response()->json([
            'status' => 'Mise à jour réussi'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lieux  $lieux
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lieux $lieux)
    {
        $lieux->delete();
        return response()->json([
            "status" => "Supprimer avec succès"
        ]);
    }
}
