<?php

use Ethereum\Ethereum;

require_once 'vendor/autoload.php';

$ethereum = new Ethereum('http://localhost:8545');

$schema = $ethereum->getDefinition();

// $params[0] = Constructor types.
// $params[1] = Return types.
foreach ($schema['methods'] as $fn_name => $params) {
    echo "<h3>" . $fn_name . "</h3>";

    if (count($params[0])) {
        echo "Arguments: <pre>" . print_r($params[0], true) . "</pre>";
        call_user_func_array([$ethereum, $fn_name], $params[0]);
    } else {
        $ethereum->{$fn_name}();
    }
    echo "<hr />";
}

// echo "<h1>SCHEMA</h1>";
// var_dump($schema);
