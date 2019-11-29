<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Answer;
use App\Question;
use Faker\Generator as Faker;

$factory->define(Answer::class, function (Faker $faker) {
    return [
        'question_id' => factory(Question::class)->create(),
        'answer' => $faker->words(3, true),
        'correct' => $faker->boolean,
    ];
});
