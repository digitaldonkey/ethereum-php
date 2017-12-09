<?php

/**
 * @defgroup generators Generators
 *
 * Some files in Ethereum-PHP are generated manually based on resources/ethjs-schema.json.
 */


require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Make Class name.
 *
 * @param string $input
 *   Method name
 *
 * @return string
 *   Derived Class name.
 */
function makeClassName($input)
{
    $return = '';
    foreach (explode('_', $input) as $part) {
        $return .= ucfirst($part);
    }
    return $return;
}

/**
 * Get Ethereum JsonRPC schema definition.
 *
 * @return array
 *   resources/ethjs-schema.json
 */
function getSchema()
{
    return json_decode(file_get_contents(__DIR__ . "/../resources/ethjs-schema.json"), true);
}


/**
 * printMe().
 *
 * @param string $title
 *   Heading.
 *
 * @param mixed $content
 *   Array/String content to be inspected.
 */
function printMe($title, $content = null)
{
    echo "<p><b>" . $title . "</b></p>";
    if ($content) {
        echo '<pre style="background: Azure">';
        if (is_array($content)) {
            print_r($content);
        } else {
            echo($content);
        }
        echo "</pre>";
    }
}
