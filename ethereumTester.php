<?php

use Ethereum\Ethereum;

require_once 'vendor/autoload.php';

$schema = json_decode(file_get_contents("./ethjs-schema.json"), true);

$foo = new Ethereum('http://localhost:8545');

// $params[0] = Constructor types.
// $params[1] = Return types.
foreach ($schema['methods'] as $fn_name => $params) {
    echo "<h3>" . $fn_name . "</h3>";

    if (count($params[0])) {
        echo "Arguments: <pre>" . print_r($params[0], true) . "</pre>";
        call_user_func_array([$foo, $fn_name], $params[0]);
    } else {
        $foo->{$fn_name}();
    }
    echo "<hr />";
}

// echo "<h1>SCHEMA</h1>";
// var_dump($schema);
