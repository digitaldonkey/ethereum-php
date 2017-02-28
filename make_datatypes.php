<?php

define('TAGETPATH', './src');

require_once './includes.inc.php';

use Ethereum\EthDataTypePrimitive;

$d = new EthDataTypePrimitive();




foreach ($schema['objects'] as $obj_name => $params) {

  echo "<h3>" .  $obj_name ."</h3>";

  $required = $params['__required'];
  unset($params['__required']);

  $ordered_params = reorderParams(array('params' => $params, 'required' => $required));

  $constructor = makeConstructor($ordered_params);
  $constructor_content = makeConstructorContent($ordered_params);
  $setters = makeSetFunctions($ordered_params);

  $return_array = makeReturnArray($ordered_params);



  $properties = makeProperties($ordered_params);



  printMe ('Arguments', $ordered_params['params']);
  printMe ('Required', $required);
  printMe ('Properties', $properties);
  printMe ('Constructor', "__construct(" . $constructor . ")");
  printMe ('ConstructorContent', $constructor_content);
  printMe ('Set&lt;PROPERTY&gt;', $setters);
  printMe ('Return Array', $return_array);



  $data = array (
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
    "  public function toArray() {",
    $return_array,
    "  }",
    "}",
  );

  file_put_contents ( TAGETPATH . '/Eth' . ucfirst($obj_name) . '.generated.php',  implode("\n",$data));

  echo "<hr />";


}

// echo "<h1>SCHEMA</h1>";
// var_dump($schema);



/**
 * Create set_<PROPERTY> functions content.
 *
 * @param Array $input -
 *   ['params' => ['name'=> Type, 'name'=> Type ...],
 *    'required' => ['name', 'name' ...] ]
 */
function makeSetFunctions(Array $input) {
  global $d;
  $functions = '';
  // Required params first.
  foreach ($input['params'] as $name => $type) {

    // TODO ARRAY HANDLING MISSING!

    $functions .= '    public function set' . ucfirst($name) . '(' . $d::map[$type] .' $value){' . "\n";
    $functions .= '      $this->' . $name . ' = $value;' . "\n";
    $functions .=     "    }\n";
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
    $array .= '      (!is_null($this->' . $name .')) ? $return[' . "'$name'" . '] = $this->' . $name . "->getHexVal() : NULL; \n";
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
  global $d;

  $constructor = '';

  // Required params first.
  foreach ($input['params'] as $name => $type) {

    if (!is_array($type)) {
      $constructor .= $d::map[$type] . ' $' . $name;
      if (!in_array($name, $input['required'])) {
        $constructor .= ' = NULL';
      }
    }
    else {
      $constructor .= 'Array ' . ' $' . $name;
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
