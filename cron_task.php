<?php

use App\Parsers\OlxPriceParser;

require_once 'vendor/autoload.php';
$connection = require 'config/services.php';
(new OlxPriceParser($connection))->parse();