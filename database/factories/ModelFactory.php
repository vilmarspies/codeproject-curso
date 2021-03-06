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

$factory->define(CodeProject\Entities\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(CodeProject\Entities\OAuthClient::class, function (Faker\Generator $faker) {
    return [
        'id' => $faker->word,
        'secret' => str_random(10),
        'name' => $faker->word,
    ];
});

$factory->define(CodeProject\Entities\Client::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'responsible' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'obs'	=> $faker->sentence,
    ];
});

$factory->define(CodeProject\Entities\Project::class, function (Faker\Generator $faker) {
    return [
        //'owner_id' => $faker->numberBetween(1,5),
       // 'client_id' => $faker->numberBetween(1,10),
        'owner_id' => rand(1,5),
        'client_id' => rand(1,10),
        'name' => $faker->word,
        'description' => $faker->sentence,
        //'progress' => $faker->word,
        'progress' => rand(1,100),
       // 'status' => $faker->word,
        'status' => rand(1,3),
        'due_date'   => $faker->dateTime('now')
    ];
});

$factory->define(CodeProject\Entities\ProjectNote::class, function (Faker\Generator $faker) {
    return [
        'project_id' => $faker->numberBetween(1,5),
        'title' => $faker->word,
        'note' => $faker->paragraph
    ];
});

$factory->define(CodeProject\Entities\ProjectTask::class, function (Faker\Generator $faker) {
    return [
        'project_id' => $faker->numberBetween(1,5),
        'name' => $faker->word,
        'start_date' => $faker->dateTime('now'),
        'status' => rand(1,3)
    ];
});

$factory->define(CodeProject\Entities\ProjectMember::class, function (Faker\Generator $faker) {
    return [
        'project_id' => $faker->numberBetween(1,10),
        'member_id' => $faker->numberBetween(1,5)
    ];
});
