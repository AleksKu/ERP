<?php

trait ApiTestTrait
{
    /**
     * @param array $actualData
     */
    public function assertApiResponse(Array $actualData)
    {
        $this->assertApiSuccess();

        $response = json_decode($this->response->getContent(), true);
        $responseData = $response['data'];

        static::assertNotEmpty($responseData['id']);
        $this->assertModelData($actualData, $responseData);
    }

    /**
     *
     */
    public function assertApiSuccess()
    {
        $this->assertResponseOk();
        $this->seeJson(['success' => true]);
    }

    /**
     * @param array $actualData
     * @param array $expectedData
     */
    public function assertModelData(Array $actualData, Array $expectedData)
    {
        foreach ($actualData as $key => $value) {
            static::assertEquals($actualData[$key], $expectedData[$key]);
        }
    }
}