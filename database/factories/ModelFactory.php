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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Erp\Catalog\Product::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(4),
        'description'=>$faker->sentence(10),
        'type' => 'product',
        'sku' => $faker->randomNumber(7),
        'weight' => $faker->randomNumber(2),
        'volume' => $faker->randomNumber(2),
        'unit_id' =>1
    ];
});


$factory->define(App\Erp\Catalog\ProductCategory::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(4),
        'product_count'=>0
    ];
});
