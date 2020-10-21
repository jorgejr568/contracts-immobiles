<?php

namespace Tests\Feature;

use App\Http\Requests\ImmobileRequest;
use App\Http\Resources\ImmobileResource;
use App\Models\Immobile;
use Database\Factories\ContractFactory;
use Database\Factories\ImmobileFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImmobileControllerTest extends TestCase
{
    use RefreshDatabase;

    private function generateAuthorization()
    {
        $user = UserFactory::new(['password' => bcrypt('password')])->create();
        $response = $this->post('/api/auth', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $jwt = $response->json('access_token');
        $token_type = $response->json('token_type');

        return "$token_type $jwt";
    }

    private function mockImmobiles($qtd = 5, $generateContracted = false){
        ImmobileFactory::times($qtd)->create();
        if($generateContracted){
            ContractFactory::times($qtd)->with_immobile()->create();
        }

        return Immobile::all();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndexWithNoAuthentication()
    {
        $response = $this->get('/api/immobile');
        $response->assertStatus(401);
    }

    public function testIndex()
    {
        $immobiles = $this->mockImmobiles();

        $response = $this->get('/api/immobile', [
            'Authorization' => $this->generateAuthorization(),
        ]);
        $response->assertStatus(200);
        $response->assertJson(["data" => ImmobileResource::collection($immobiles)->toArray(request())]);
    }

    public function testIndexWithSearch()
    {

        $immobiles = $this->mockImmobiles(1);
        $immobileSearch = $immobiles[0];
        $response = $this->get('/api/immobile?'.http_build_query([
                'search' => "{$immobileSearch->street} {$immobileSearch->city} {$immobileSearch->state}"
            ])
            , [
            'Authorization' => $this->generateAuthorization(),
        ]);
        $response->assertStatus(200);
        $response->assertJson(["data" => ImmobileResource::collection([$immobileSearch])->toArray(request())]);
    }

    public function testIndexWithStatus()
    {
        $immobiles = $this->mockImmobiles(5, true);
        foreach(['non-contracted' => '==', 'contracted' => '!='] as $status => $sign){
            $filtered = $immobiles->where('contract', $sign, null)->values();
            $response = $this->get('/api/immobile?'.http_build_query([
                    'status' => $status
                ])
                , [
                    'Authorization' => $this->generateAuthorization(),
                ]);
            $response->assertStatus(200);
            $response->assertJson(["data" => ImmobileResource::collection($filtered)->toArray(request())]);
        }

    }

    public function testIndexWithSort()
    {
        $immobiles = $this->mockImmobiles(5);
        $attributes = array_keys($immobiles[0]->getAttributes());
        foreach ($attributes as $attribute){
            foreach (['ASC', 'DESC'] as $direction) {
                $isDesc = $direction == 'DESC';
                $sorted = Immobile::orderBy($attribute, $direction)->get();

                $response = $this->get('/api/immobile?' . http_build_query([
                        'sort' => [
                            [
                                'column' => $attribute,
                                'desc' => $isDesc
                            ]
                        ]
                    ])
                    , [
                        'Authorization' => $this->generateAuthorization(),
                    ]);
                $response->assertStatus(200);
                $response->assertJson(["data" => ImmobileResource::collection($sorted)->toArray(request())]);
            }
        }
    }

    /**
     * STORE TESTS
     */

    public function testStoreUnauthorized(){
        $immobileData = ImmobileFactory::new()->make()->toArray();
        $response = $this->post('/api/immobile',$immobileData, [
            'Authorization' => 'invalid_jwt',
        ]);

        $response->assertStatus(401);
    }

    public function testStoreWithMissingData(){
        $request = new ImmobileRequest();
        $rules = collect($request->rules())
            ->filter(function($rule){
                return in_array('required', $rule);
            })->keys();

        foreach($rules as $rule){
            $immobileData = ImmobileFactory::new()->make()->toArray();
            unset($immobileData[$rule]);
            $response = $this->post('/api/immobile',$immobileData, [
                    'Authorization' => $this->generateAuthorization(),
                ]);

            $response->assertStatus(422);

        }
    }

    public function testStoreWithInvalidEmail(){
        $immobileData = ImmobileFactory::new(['email' => 'invalid_email'])->make()->toArray();
        $response = $this->post('/api/immobile',$immobileData, [
                'Authorization' => $this->generateAuthorization(),
            ]);

        $response->assertStatus(422);

    }

    public function testStore(){
        $immobileData = ImmobileFactory::new()->make()->toArray();
        $response = $this->post('/api/immobile',$immobileData, [
            'Authorization' => $this->generateAuthorization(),
        ]);
        $this->assertDatabaseCount('immobiles', 1);
        $immobile = Immobile::first();

        $response->assertStatus(201);
        $response->assertJson(['data' => (new ImmobileResource($immobile))->toArray(request())]);
    }

    public function testDestroyUnauthorized(){
        $immobile = ImmobileFactory::new()->create();
        $response = $this->delete('/api/immobile/'.$immobile->uuid,[], [
            'Authorization' => 'invalid_jwt',
        ]);
        $response->assertStatus(401);
    }

    public function testDestroy(){
        $immobile = ImmobileFactory::new()->create();
        $response = $this->delete('/api/immobile/'.$immobile->uuid,[], [
            'Authorization' => $this->generateAuthorization(),
        ]);
        $this->assertDatabaseCount('immobiles', 1);
        $immobile = Immobile::onlyTrashed()->first();
        $this->assertNotNull($immobile->deleted_at);
        $response->assertStatus(204);
    }
}
