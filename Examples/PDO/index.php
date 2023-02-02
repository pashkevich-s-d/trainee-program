<?php

require_once(
    implode(
        DIRECTORY_SEPARATOR,
        [
            __DIR__,
            '..',
            'ClassAutoloader',
            'Autoloader.php',
        ]
    )
);

$autoloader = new Autoloader(__DIR__);

require_once('pdo.php');
