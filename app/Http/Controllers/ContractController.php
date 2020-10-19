<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractRequest;
use App\Http\Resources\ContractResource;
use App\Models\Immobile;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ContractController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Immobile $immobile
     * @param ContractRequest $request
     * @return ContractResource
     */
    public function store(Immobile $immobile, ContractRequest $request)
    {
        Validator::make(
            [
                'immobile_id' => $immobile->id,
            ],
            [
                'immobile_id' => 'unique:contracts',
            ],
        )->validate();

        return new ContractResource(
            $immobile->contract()->create($request->all()),
        );
    }
}
