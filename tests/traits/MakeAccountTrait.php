<?php

use Faker\Factory as Faker;
use Torg\Base\Account;
use Torg\Base\Repositories\AccountRepository;

trait MakeAccountTrait
{
    /**
     * Create fake instance of Account and save it in database
     *
     * @param array $accountFields
     *
     * @return Account
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function makeAccount(array $accountFields = array())
    {
        /** @var AccountRepository $accountRepo */
        $accountRepo = App::make(AccountRepository::class);
        $theme = $this->fakeAccountData($accountFields);

        return $accountRepo->create($theme);
    }

    /**
     * Get fake instance of Account
     *
     * @param array $accountFields
     *
     * @return Account
     */
    public function fakeAccount(array $accountFields = array())
    {
        return new Account($this->fakeAccountData($accountFields));
    }

    /**
     * Get fake data of Account
     *
     * @param array $accountFields
     *
     * @return array
     *
     */
    public function fakeAccountData(array $accountFields = array())
    {
        $fake = Faker::create();

        return array_merge(
            [
                'title' => $fake->word,
                'created_at' => $fake->word,
                'updated_at' => $fake->word,
            ],
            $accountFields
        );
    }
}
