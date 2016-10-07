<?php

namespace Test;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/Utility/Autoload.php';

new Utility\Autoload(dirname(__DIR__) . '/PhpMySql', 'PhpMySql');
new Utility\Autoload(dirname(__DIR__) . '/Test', 'Test');
