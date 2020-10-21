<?php

namespace Tests\Feature;

use App\Http\Requests\ContractRequest;
use App\Http\Resources\ContractResource;
use App\Models\Immobile;
use Database\Factories\ContractFactory;
use Database\Factories\ImmobileFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\GenerateJWT;

class ContractControllerTest extends TestCase
{
    use RefreshDatabase, GenerateJWT;
    const DOCUMENT_NUMBER = '14856778072';
    /**
     * A basic feature test example.
     *
     * @return void
     */

    private function mockImmobile(): Immobile{
        return ImmobileFactory::new()->create();
    }

    public function testStoreWithInvalidJWT()
    {
        $immobile = $this->mockImmobile();
        $response = $this->post('/api/immobile/'.$immobile->uuid.'/contract');
        $response->assertStatus(401);
    }

    public function testStoreWithInvalidData()
    {
        $immobile = $this->mockImmobile();

        $request = new ContractRequest();
        $rules = collect($request->rules())
            ->filter(function ($rule) {
                return in_array('required', $rule);
            })
            ->keys();

        foreach ($rules as $rule){
            $contractData = ContractFactory::new(['document_number' => self::DOCUMENT_NUMBER])->make()->toArray();
            unset($contractData[$rule]);

            $response = $this->post('/api/immobile/'.$immobile->uuid.'/contract', $contractData, ['Authorization' => $this->generateAuthorization()]);
            $response->assertStatus(422);
        }
    }

    public function testStoreWithInvalidImmobile()
    {
        $response = $this->post('/api/immobile/invalid_uuid/contract', [], ['Authorization' => $this->generateAuthorization()]);
        $response->assertStatus(404);
    }

    public function testStoreUniqueContractForImmobile()
    {
        $contractDatabase = ContractFactory::new()->with_immobile()->create();
        $contractRequest = ContractFactory::new(['document_number' => self::DOCUMENT_NUMBER])->make()->toArray();

        $response = $this->post("/api/immobile/{$contractDatabase->immobile->uuid}/contract", $contractRequest, ['Authorization' => $this->generateAuthorization()]);
        $response->assertStatus(422);
    }

    public function testStore()
    {
        $immobile = $this->mockImmobile();
        $contractData = ContractFactory::new(['document_number' => self::DOCUMENT_NUMBER])->make()->toArray();
        $response = $this->post('/api/immobile/'.$immobile->uuid.'/contract', $contractData, ['Authorization' => $this->generateAuthorization()]);

        $response->assertStatus(201);
        $response->assertJson(['data' => (new ContractResource($contractData))->toArray(request())]);
    }
}
