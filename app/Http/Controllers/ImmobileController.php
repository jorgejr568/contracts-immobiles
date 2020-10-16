<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImmobileRequest;
use App\Http\Resources\ImmobileResource;
use App\Models\Immobile;

class ImmobileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ImmobileResource::collection(
            Immobile::paginate(config('pagination.per_page'))
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return ImmobileResource
     */
    public function store(ImmobileRequest $request)
    {
        return new ImmobileResource(Immobile::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Immobile  $immobile
     * @return ImmobileResource
     */
    public function show(Immobile $immobile)
    {
        return new ImmobileResource($immobile);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ImmobileRequest $request
     * @param \App\Models\Immobile $immobile
     * @return ImmobileResource
     */
    public function update(ImmobileRequest $request, Immobile $immobile)
    {
        $immobile->update($request->all());
        return new ImmobileResource($immobile);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Immobile $immobile
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Immobile $immobile)
    {
        $immobile->delete();
        return response(null, 204);
    }
}
