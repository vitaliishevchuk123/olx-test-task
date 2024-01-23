<?php

declare(strict_types=1);
use App\Parsers\OlxPriceParser;

require_once 'vendor/autoload.php';
$connection = require 'config/services.php';
(new OlxPriceParser($connection))->parse();