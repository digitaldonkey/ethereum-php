<?php

/**
 * This is used to create consistent data type classes.
 *
 * Disabled, because only required for development.
 */
header("HTTP/1.1 401 Unauthorized");
die ('Access denied');


define('TAGETPATH', './src');

require_once './includes.inc.php';

use Ethereum\EthDataTypePrimitive;
use Ethereum\EthDataType;

foreach ($schema['objects'] as $obj_name => $params) {

  echo "<h3>" . $obj_name . "</h3>";

  $required = $params['__required'];
  unset($params['__required']);

  $ordered_params = reorderParams(array('params' => $params, 'required' => $required));

  $constructor = makeConstructor($ordered_params);
  $constructor_content = makeConstructorContent($ordered_params);
  $setters = makeSetFunctions($ordered_params);

  $return_array = makeReturnArray($ordered_params);

  $properties = makeProperties($ordered_params);

  printMe('Arguments', $ordered_params['params']);
  printMe('Required', $required);
  printMe('Properties', $properties);
  printMe('Constructor', "__construct(" . $constructor . ")");
  printMe('ConstructorContent', $constructor_content);
  printMe('Set&lt;PROPERTY&gt;', $setters);
  printMe('Return Array', $return_array);
  printMe('Type Array', makeTypeArray($ordered_params));

  $data = array(
    "<?php\n",
    "namespace Ethereum;",
    "",
    "/**",
    " * Implement data type $obj_name.",
    " */",
    "class $obj_name extends EthDataType {",
    "",
    $properties,
    "  /**",
    "   * Constructor.",
    "   */",
    "  public function __construct($constructor) {",
    $constructor_content,
    "  }",
    "",
    $setters,
    "",
    "  public function getType() {",
    "    return '$obj_name';",
    "  }",
    "",
    "  public function toArray() {",
    $return_array,
    "  }",
    makeTypeArray($ordered_params),
    "}",
  );
  file_put_contents(TAGETPATH . '/' . ucfirst($obj_name) . '.php', implode("\n", $data));
  echo "<hr />";
}

/**
 * Create set_<PROPERTY> functions content.
 *
 * @param array $input
 *   ['params' => ['name'=> Type, 'name'=> Type ...],
 *    'required' => ['name', 'name' ...] ]
 */
function makeSetFunctions(array $input) {

  $functions = '';
  // Required params first.
  foreach ($input['params'] as $name => $type) {
    $functions .= '  public function set' . ucfirst($name) . '(' . EthDataType::getTypeClass($type, TRUE) . ' $value){' . "\n";
    $functions .= '    if (is_object($value) && is_a($value, \'' . EthDataType::getTypeClass($type, TRUE) . "')) {\n";
    $functions .= '      $this->' . $name . ' = $value;' . "\n";
    $functions .= '    }' . "\n";
    $functions .= '    else {' . "\n";
    $functions .= '      $this->' . $name . ' = new ' . EthDataType::getTypeClass($type, TRUE) . '($value);' . "\n";
    $functions .= '    }' . "\n";
    $functions .= "  }\n\n";
  }
  return $functions;
}

/**
 * Create return array.
 *
 * @param Array $input -
 *   ['params' => ['name'=> Type, 'name'=> Type ...],
 *    'required' => ['name', 'name' ...] ]
 */
function makeReturnArray(Array $input) {
  $array = '    $return = array();' . "\n";

  // Required params first.
  foreach ($input['params'] as $name => $type) {

    if (is_array($type)) {
      $array .= '      (!is_null($this->' . $name . ')) ? $return[' . "'$name'" . '] = EthereumStatic::valueArray($this->' . $name . ", '" . $type[0] . "') : array(); \n";
    }
    else {
      $array .= '      (!is_null($this->' . $name .')) ? $return[' . "'$name'" . '] = $this->' . $name . "->hexVal() : NULL; \n";
    }

  }

  $array .= '    return $return;';
  return $array;
}


/**
 * Create constructor content.
 *
 * @param Array $input -
 *   ['params' => ['name'=> Type, 'name'=> Type ...],
 *    'required' => ['name', 'name' ...] ]
 */
function makeConstructorContent(Array $input) {
  $properties = '';
  // Required params first.
  foreach ($input['params'] as $name => $type) {
    $properties .= '    $this->' . $name . " = $$name;  \n";
  }
  return substr($properties, 0, -2);
}


/**
 * Create Constructor from array.
 *
 * @param Array $input
 *   ['params' => ['name'=> Type, 'name'=> Type ...],
 *    'required' => ['name', 'name' ...] ]
 */
function makeTypeArray(Array $input) {
  $data[] = " /**";
  $data[] = "  * Returns a name => type array.";
  $data[] = "  */";
  $data[] = '  public static function getTypeArray() {';
  $data[] = '    return array( ';
  foreach ($input['params'] as $name => $type) {
    if (is_array($type)) {
      $data[] = "      '" . $name . "' => '" . EthDataTypePrimitive::typeMap($type[0]) . "',";
    }
    else {
      $data[] = "      '" . $name . "' => '" . EthDataTypePrimitive::typeMap($type) . "',";
    }
  }
  $data[] = '    );';
  $data[] = '  }';
  return implode("\n", $data);
}


/**
 * Create properties.
 *
 * @param Array $input -
 *   ['params' => ['name'=> Type, 'name'=> Type ...],
 *    'required' => ['name', 'name' ...] ]
 */
function makeProperties(Array $input) {
  $properties = '';
  // Required params first.
  foreach ($input['params'] as $name => $type) {
    $properties .= '  protected $' . $name . ';' . "\n";
  }
  return $properties;
}

/**
 * Create constructor parameters.
 *
 * @param Array $input -
 *   ['params' => ['name'=> Type, 'name'=> Type ...],
 *    'required' => ['name', 'name' ...] ]
 */
function makeConstructor(Array $input) {

  $constructor = '';

  // Required params first.
  foreach ($input['params'] as $name => $type) {

    if (!is_array($type)) {
      $constructor .= EthDataTypePrimitive::typeMap($type) . ' $' . $name;
      if (!in_array($name, $input['required'])) {
        $constructor .= ' = NULL';
      }
    }
    else {
      $constructor .= 'array ' . ' $' . $name;
      if (!in_array($name, $input['required'])) {
        $constructor .= ' = NULL';
      }
    }
    $constructor .=  ', ';
  }

  return substr($constructor, 0, -2);
}


/**
 * Reorder parameters.
 *
 * Prioritizing required params over unrequired ones.
*/
function reorderParams(Array $input) {
  $ordered_params = $input;
  $ordered_params['params'] = [];
  // Required params first.
  foreach ($input['params'] as $name => $type) {
    if (in_array($name, $input['required'])) {
      $ordered_params['params'][$name] = $type;
    }
  }
  // ... then non required params.
  foreach ($input['params'] as $name => $type) {
    if (!in_array($name, $input['required'])) {
      $ordered_params['params'][$name] = $type;
    }
  }
  return $ordered_params;
}
