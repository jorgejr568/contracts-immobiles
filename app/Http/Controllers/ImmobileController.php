<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImmobileRequest;
use App\Http\Requests\PaginationRequest;
use App\Http\Resources\ImmobileResource;
use App\Models\Immobile;
use Illuminate\Support\Facades\Log;

class ImmobileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PaginationRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(PaginationRequest $request)
    {
        $search_fields = [
            'state',
            'city',
            'street',
            'number'
        ];
        $sort = $request->input('sort', []);
        return ImmobileResource::collection(
            Immobile
                ::when(count($sort) > 0, function ($query) use ($sort) {
                    foreach ($sort as $rule) {
                        $rule = json_decode($rule, true);
                        $query->orderBy(
                            $rule['column'],
                            $rule['desc'] ? 'DESC' : 'ASC',
                        );
                    }
                })
                ->when($request->search(), function($query) use($request, $search_fields){
                    $words = $request->search();
                    foreach ($search_fields as $field){
                        foreach ($words as $word){
                            $query->orWhere($field, 'like', $word);
                        }
                    }
                })
                ->paginate(
                    $request->input('per_page', config('pagination.per_page')),
                ),
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
