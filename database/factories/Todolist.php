<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Todolist;
use Faker\Generator as Faker;

$factory->define(Todolist::class, function (Faker $faker) {
    $created_at = $faker->unixTime();
    $updated_at = $faker->unixTime();

    if ($created_at - $updated_at >0) {
        $tmp = $created_at;
        $created_at = $updated_at;
        $updated_at = $tmp;
    }

    return [
        'title'=>$faker->sentence(),
        'content'=>$faker->sentence(),
        'created_at'=>$created_at,
        'updated_at'=>$updated_at
    ];
});
