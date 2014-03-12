<?php

require(__DIR__ . '/../vendor/autoload.php');

$kernel = AspectMock\Kernel::getInstance();
$kernel->init([
    'debug'        => true,
    'includePaths' => [
      __DIR__ . '/../vendor/thomaswelton' // for Gravatar::src() in Tricks\User
    ]
]);
