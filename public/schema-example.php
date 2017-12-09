<?php

use Ethereum\Ethereum;
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * @var bool ACCESS Deny public access to this generator.
 */
define('IS_PUBLIC', FALSE);

/**
 * Better disable access in production.
 */
if (!IS_PUBLIC) {
    header("HTTP/1.1 401 Unauthorized");
    die('ACCESS DENIED');
}

/**
 * @var Ethereum $client Ethereum JsonRPC client.
 */
$client = new Ethereum('http://localhost:8545');

/**
 * @var array $schema Decoded ethjs-schema.
 */
$schema = $client->getDefinition(); /**< array $schema Decoded ethjs-schema. */

echo "<h1>SCHEMA</h1>";

foreach ($schema['methods'] as $fn_name => $params) {

    // $params[0] = Constructor types.
    // $params[1] = Return types.

    echo "<h3>" . $fn_name . "</h3>";

    if (count($params[0])) {
        echo "Arguments: <pre>" . print_r($params[0], true) . "</pre>";
        call_user_func_array([$client, $fn_name], $params[0]);
    } else {
        $client->{$fn_name}();
    }
    echo "<hr />";
}

 echo "<h1>SCHEMA</h1>";
 var_dump($schema);
