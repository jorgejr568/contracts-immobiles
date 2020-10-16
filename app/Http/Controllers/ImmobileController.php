<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImmobileResource;
use App\Models\Immobile;
use Illuminate\Http\Request;

class ImmobileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ImmobileResource::collection(Immobile::paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Immobile  $immobile
     * @return \Illuminate\Http\Response
     */
    public function show(Immobile $immobile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Immobile  $immobile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Immobile $immobile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Immobile  $immobile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Immobile $immobile)
    {
        //
    }
}
