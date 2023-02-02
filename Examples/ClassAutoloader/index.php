<?php

require_once('Autoloader.php');

$autoloader = new Autoloader(__DIR__ . DIRECTORY_SEPARATOR . 'src');

$user = new \Entity\User();
$car = new \Entity\Car();
$data = new \Model\Data();
