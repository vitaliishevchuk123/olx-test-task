<?php

use App\Http\Controllers\SubscribeAnnouncementController;
use App\Http\Request;
use App\Http\Router;

define('BASE_PATH', dirname(__DIR__));
require_once BASE_PATH . '/vendor/autoload.php';

$connection = require BASE_PATH . '/config/services.php';

$request = Request::createFromGlobals();
$router = new Router();

$router->addRoute('POST', '/subscribe-announcement', function () use ($request, $connection) {
    return (new SubscribeAnnouncementController())->subscribe($request, $connection);
});

$router->matchRoute();
