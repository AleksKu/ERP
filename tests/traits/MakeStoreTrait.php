<?php

use Faker\Factory as Faker;
use Torg\Base\Store;
use Torg\Base\Repositories\StoreRepository;

trait MakeStoreTrait
{
    /**
     * Create fake instance of Store and save it in database
     *
     * @param array $storeFields
     * @return Store
     */
    public function makeStore($storeFields = [])
    {
        /** @var StoreRepository $storeRepo */
        $storeRepo = App::make(StoreRepository::class);
        $theme = $this->fakeStoreData($storeFields);
        return $storeRepo->create($theme);
    }

    /**
     * Get fake instance of Store
     *
     * @param array $storeFields
     * @return Store
     */
    public function fakeStore($storeFields = [])
    {
        return new Store($this->fakeStoreData($storeFields));
    }

    /**
     * Get fake data of Store
     *
     * @param array $postFields
     * @return array
     */
    public function fakeStoreData($storeFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $storeFields);
    }
}
