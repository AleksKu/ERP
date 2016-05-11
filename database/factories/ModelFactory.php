<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(Torg\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'account_id' => factory(\Torg\Base\Account::class)->create()->id,

    ];
});


$factory->define(Torg\Catalog\Product::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(4),
        'description'=>$faker->sentence(10),
        'type' => 'product',
        'sku' => $faker->randomNumber(7),
        'weight' => $faker->randomNumber(2),
        'volume' => $faker->randomNumber(2),
        'cost' => $faker->randomNumber(2),
        'price' => $faker->randomNumber(2),
        'unit_id' =>1,
        'category_id' => factory(Torg\Catalog\ProductCategory::class)->create()->id,

    ];
});


$factory->define(Torg\Catalog\ProductCategory::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(4),
        'product_count'=>0
    ];
});

$factory->define(Torg\Base\Account::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->company,
        



    ];
});

$factory->define(Torg\Base\Company::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->company,
        'code'=>$faker->sentence(2),
        'account_id' => factory(\Torg\Base\Account::class)->create()->id,



    ];
});

$factory->define(Torg\Base\Warehouse::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->company,
        'code'=>$faker->sentence(4),
        'account_id' => factory(\Torg\Base\Account::class)->create()->id,


    ];
});

$factory->define(Torg\Base\Store::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->company,
        'code'=>$faker->sentence(4),
        'account_id' => factory(\Torg\Base\Account::class)->create()->id,
        'company_id' => factory(\Torg\Base\Company::class)->create()->id,


    ];
});



$factory->define(Torg\Stocks\Stock::class, function (Faker\Generator $faker) {
    return [
        'product_id' => factory(Torg\Catalog\Product::class)->create()->id,
        'warehouse_id' => factory(Torg\Base\Warehouse::class)->create()->id,
        'stock_code'=>$faker->sentence(2),

    ];
});

$factory->define(Torg\Stocks\StockReserve::class, function (Faker\Generator $faker) {
    return [
        'code'=>$faker->sentence(2),
        'warehouse_id' => factory(Torg\Base\Warehouse::class)->create()->id,
        'status'=>\Torg\Stocks\StockDocument::STATUS_NEW

    ];
});

$factory->define(\Torg\Sales\Order::class, function (Faker\Generator $faker) {
    return [
        'code'=>$faker->sentence(2),
        'warehouse_id' => factory(Torg\Base\Warehouse::class)->create()->id,
        'company_id' => factory(Torg\Base\Company::class)->create()->id

    ];
});

$factory->define(\Torg\Sales\OrderItem::class, function (Faker\Generator $faker) {
    return [
        'product_id' => factory(Torg\Catalog\Product::class)->create()->id,
        'stock_id' => factory(\Torg\Stocks\Stock::class)->create()->id,
        'qty' => 1


    ];
});
