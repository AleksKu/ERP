<?php

use Torg\Base\Account;
use Torg\Base\Repositories\AccountRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccountRepositoryTest extends TestCase
{
    use MakeAccountTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var AccountRepository
     */
    protected $accountRepo;

    public function setUp()
    {
        parent::setUp();
        $this->accountRepo = App::make(AccountRepository::class);
    }

    /**
     *  create
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testCreateAccount()
    {
        $account = $this->fakeAccountData();
        $createdAccount = $this->accountRepo->create($account);
        $createdAccount = $createdAccount->toArray();
        static::assertArrayHasKey('id', $createdAccount);
        static::assertNotNull($createdAccount['id'], 'Created Account must have id specified');
        static::assertNotNull(Account::find($createdAccount['id']), 'Account with given id must be in DB');
        $this->assertModelData($account, $createdAccount);
    }

    /**
     *  read
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testReadAccount()
    {
        $account = $this->makeAccount();
        $dbAccount = $this->accountRepo->find($account->id);
        $dbAccount = $dbAccount->toArray();
        $this->assertModelData($account->toArray(), $dbAccount);
    }

    /**
     *  update
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testUpdateAccount()
    {
        $account = $this->makeAccount();
        $fakeAccount = $this->fakeAccountData();
        $updatedAccount = $this->accountRepo->update($fakeAccount, $account->id);
        $this->assertModelData($fakeAccount, $updatedAccount->toArray());
        $dbAccount = $this->accountRepo->find($account->id);
        $this->assertModelData($fakeAccount, $dbAccount->toArray());
    }

    /**
     *  delete
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testDeleteAccount()
    {
        $account = $this->makeAccount();
        $resp = $this->accountRepo->delete($account->id);
        static::assertTrue($resp);
        static::assertNull(Account::find($account->id), 'Account should not exist in DB');
    }
}
