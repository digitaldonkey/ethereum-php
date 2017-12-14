<?php
/**
 * @file
 * Helper functions to generate the API.
 *
 * @ingroup generators
 */

/**
 * @defgroup generators Generators
 *
 * Some files in Ethereum-PHP are generated manually based on resources/ethjs-schema.json.
 */

/**
 * @defgroup generated Generated
 *
 * Files in this group are generated based on resources/ethjs-schema.json.
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
    echo "$title \n";
    if ($content) {
        if (is_array($content)) {
            print_r($content) . "\n";
        } else {
            echo($content) . "\n";
        }
    }
}


function addUseStatement ($type, &$useStatements) {

    if (is_array($type)) {
        foreach ($type as $subtype) {
            if (!in_array($subtype, $useStatements)) {
                $useStatements[] = $subtype;
            }
        }
    }
    else {
        // Add type to $useStatements so we can generate e.g. 'use Ethereum\EthS;' later.
        if (!in_array($type, $useStatements)) {

            // Special case for eth_syncing which returns Object or false.
            if (strpos($type, '|')) {
                // @todo This is actually very weired in the Schema: We have an "or" in Return values.
                // For now we just include both types, but this requires deeper investigation how to handle that.
                foreach (explode('|', $type) as $t) {
                    if (!in_array($t, $useStatements)) {
                        $useStatements[] = $t;
                    }
                }
            }
            else {
                $useStatements[] = $type;
            }
        }
    }
}
