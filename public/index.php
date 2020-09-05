<?php

use App\Bootstrap;

include_once '../vendor/autoload.php';

$bootstrap = new Bootstrap(dirname(__DIR__));

$bootstrap->boot();

$bootstrap->http();