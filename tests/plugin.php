<?php

define('DEBUG', TRUE);

require_once "../classes/plugin/plugin.php";
require_once "../plugins/Statz/Statz.php";
require_once "../classes/config.class.php";

$config = json_decode(file_get_contents("../config.json"), TRUE);

$mysqli = new mysqli(
    $config["mysql"]["host"],
    $config["mysql"]["username"],
    $config["mysql"]["password"],
    $config["mysql"]["dbname"]
);

$plugin = new \BlueStats\Plugin\LiteBans($mysqli);

echo $plugin->player->getID("Zeyphros") . PHP_EOL;
echo $plugin->player->getID("5f7e4c8d-8c79-42a9-953b-538e3f62e644") . PHP_EOL;
echo $plugin->player->getUUIDfromID($plugin->player->getID("2Low")) . PHP_EOL;
echo $plugin->player->getNamefromID($plugin->player->getID("206d307c-ef43-45b0-aa77-3511e13df2f1")) . PHP_EOL;

foreach ($plugin->database['stats'] as $stat => $info)
    var_dump($plugin->stats->player($plugin->player->getUUIDfromID($plugin->player->getID("206d307c-ef43-45b0-aa77-3511e13df2f1")), $stat));

foreach ($plugin->database['stats'] as $stat => $info)
    var_dump($plugin->stats->statList($stat, 10));