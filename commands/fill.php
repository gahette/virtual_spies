<?php

use Database\DBConnection;

require_once __DIR__ . '/../vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

$pdo = (new DBConnection)->getPDO();


$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');

$pdo->exec('TRUNCATE TABLE country_mission');
$pdo->exec('TRUNCATE TABLE missions');
$pdo->exec('TRUNCATE TABLE agents');
//$pdo->getPDO()->exec('TRUNCATE TABLE countries');
$pdo->exec('TRUNCATE TABLE USERS');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');


for ($i = 0; $i < 30; $i++) {
    $pdo->exec("INSERT INTO missions SET 
                         title='$faker->sentence', 
                         slug='$faker->slug', 
                         content='$faker->paragraph,$faker->paragraph, $faker->paragraph', 
                         nickname='$faker->username', 
                         created_at='$faker->date, $faker->time', 
                         closed_at='$faker->date, $faker->time'
                         ");
}
for ($i = 0; $i < 30; $i++) {
    $pdo->exec("INSERT INTO agents SET 
                         lastname='$faker->userName', 
                         slug='$faker->slug', 
                         firstname='$faker->userName',
                         bod='$faker->date, $faker->time', 
                         ");
}
for ($i = 1; $i < 245; $i++) {
    $pdo->exec("INSERT INTO country_mission SET 
                         country_id= $i, 
                         mission_id= '$faker->randomDigitNotNull'
                         ");
}

$password = password_hash('admin', PASSWORD_BCRYPT);
$pdo->exec("INSERT INTO users SET lastname='Doe', firstname='John', email='john@doe.com', password='$password', created_at='$faker->date'");

