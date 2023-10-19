<?php

use \Faker\Factory;

require __DIR__ . "/../vendor/autoload.php";

$faker = Factory::create("es_ES");

for ($i = 0; $i < 10; $i++) {
    echo $faker->firstName() . ", " . $faker->lastName() . ", (" . $faker->city() . ")" . " - Email: " . $faker->email() . " <br>";
}
