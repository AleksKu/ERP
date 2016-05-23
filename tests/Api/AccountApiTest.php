<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccountApiTest extends TestCase
{
    use MakeAccountTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * 
     */
    public function testCreateAccount()
    {
        $account = $this->fakeAccountData();
        $this->json('POST', '/api/v1/accounts', $account);

        $this->assertApiResponse($account);
    }

    /**
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testReadAccount()
    {
        $account = $this->makeAccount();
        $this->json('GET', '/api/v1/accounts/'.$account->id);

        $this->assertApiResponse($account->toArray());
    }

    /**
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testUpdateAccount()
    {
        $account = $this->makeAccount();
        $editedAccount = $this->fakeAccountData();

        $this->json('PUT', '/api/v1/accounts/'.$account->id, $editedAccount);

        $this->assertApiResponse($editedAccount);
    }

    /**
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testDeleteAccount()
    {
        $account = $this->makeAccount();
        $this->json('DELETE', '/api/v1/accounts/'.$account->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/accounts/'.$account->id);

        $this->assertResponseStatus(404);
    }
}
