<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StoreApiTest extends TestCase
{
    use MakeStoreTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateStore()
    {
        $store = $this->fakeStoreData();
        $this->json('POST', '/api/v1/stores', $store);

        $this->assertApiResponse($store);
    }

    /**
     * @test
     */
    public function testReadStore()
    {
        $store = $this->makeStore();
        $this->json('GET', '/api/v1/stores/'.$store->id);

        $this->assertApiResponse($store->toArray());
    }

    /**
     * @test
     */
    public function testUpdateStore()
    {
        $store = $this->makeStore();
        $editedStore = $this->fakeStoreData();

        $this->json('PUT', '/api/v1/stores/'.$store->id, $editedStore);

        $this->assertApiResponse($editedStore);
    }

    /**
     * @test
     */
    public function testDeleteStore()
    {
        $store = $this->makeStore();
        $this->json('DELETE', '/api/v1/stores/'.$store->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/stores/'.$store->id);

        $this->assertResponseStatus(404);
    }
}
