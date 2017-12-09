<?php
/**
 * @file
 * Generate empty Method test-classes.
 *
 * We generating from resources/ethjs-schema.json -> objects.
 *
 * @ingroup generators
 */

use Ethereum\EthDataTypePrimitive;
require_once __DIR__ . '/generator-commons.php';

/**
 * @var string TARGET_PATH Generator destination.
 */
define('TARGET_PATH', '../tests/Unit/');

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
 * @var array $schema Decoded ethjs-schema.
 */
$schema = getSchema();

foreach ($schema['methods'] as $method_name => $params) {

    echo "<h3>" . $method_name . "</h3>";

    $class_name = makeClassName($method_name);
    printMe('Class name base', $class_name);

    $valid_arguments = $params[0];
    $argument_class_names = [];
    if (count($valid_arguments)) {

        printMe('Valid arguments', $valid_arguments);

        // Get argument definition Classes.
        foreach ($valid_arguments as $type) {
            $primitiveType = EthDataTypePrimitive::typeMap($type);
            if ($primitiveType) {
                $argument_class_names[] = $primitiveType;
            } else {
                $argument_class_names[] = $type;
            }
        }
        printMe('Valid arguments class names', $argument_class_names);
    }

    $return_type = $params[1];
    printMe('Return value type', $return_type);

    $data = [
        "<?php\n",
        // TODO THIS DOSN'T WORK: Drupal Namespace not recognized.
        "namespace Ethereum;",
        "use Ethereum\EthTest;",
        "use Ethereum\Ethereum;\n",
        "/**",
        " * Test for $method_name.",
        " * @ingroup tests",
        " */",
        "class " . $class_name . "Test extends EthTest {\n",
        makeConstructor(),
        "",
        "  /**",
        "   * Testing. $method_name",
        "   * @ingroup tests",
        "   */",
        "  public function test" . $class_name . "Initial() {\n",
        makeTestUnparameterised(),
        "  }",
        "}",
    ];

    $filename = TARGET_PATH . '/' . $class_name . 'Test.generatedTest.php';
    file_put_contents($filename, implode("\n", $data));
    chmod($filename, 0664);
    echo "<hr />";
}



/**
 * Create constructor content.
 *
 */
function makeConstructor()
{
    $val[] = '  protected $controller;' . "\n";
    $val[] = '  public function __construct(){';
    $val[] = '    parent::__construct();';
    $val[] = '    $this->controller = new Ethereum();';
    $val[] = '  }';

    // Required params first.
    return implode("\n", $val);
}

/**
 * Create test for unparameterised call.
 *
 */
function makeTestUnparameterised()
{
    global $valid_arguments, $method_name, $return_type;
    if (count($valid_arguments) == 0) {
        $val[] = '    $x = $this->controller->client->' . $method_name . '();';
        $val[] = '    $this->assertEquals($x->getType($schema = TRUE), "' . $return_type . '");';
        return implode("\n", $val);
    }
    else {
        return '';
    }
}
