<?php
declare(strict_types=1);

use App\Dbal\ConnectionFactory;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(dirname(__DIR__) . '/.env');

$connectionParams = [
    'dbname' => $_ENV['DB_DATABASE'],
    'user' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'host' => $_ENV['DB_HOST'] . ':' . $_ENV['DB_PORT'],
    'driver' => $_ENV['DB_DRIVER'],
];

// Application services
if ($_ENV['APP_ENV'] === 'local') {
    $whoops = new Whoops\Run;
    $whoops->pushHandler(new Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}

return (new ConnectionFactory($connectionParams))->create();