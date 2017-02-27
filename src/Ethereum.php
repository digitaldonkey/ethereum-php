<?php


class Ethereum {

  private $definition, $methods;

  public function __construct() {
    global $schema;
    $this->definition = $schema;

    foreach ($this->definition['methods'] as $name => $params) {
      ${$name} = function () {

          $fn_name = debug_backtrace()[2]['args'][0];
          $params = $this->definition['methods'][$fn_name];


          echo "<b>Called function name</b> <br />" .  $fn_name ."<br />";
//           var_dump($params);

         // Arguments.
         $args = func_get_args();
         if (count($args)) {
            echo "<br /><b>Arguments</b>";
            echo '<pre style="background: Azure">' . print_r($args, true) . "</pre></small>";
         }

         // Return values
         echo "<br /><b>Return values</b>";
         echo '<pre style="background: Azure">' . print_r($params[1], true) . "</pre></small>";

         // Required parameters
         if (isset($params[2])) {
           echo "<br /><b>Required Params: </b>";
           $required = array_slice($params[0], 0, $params[2]);
           echo '<pre style="background: Azure">' . print_r($required, true) . "</pre></small>";
         }

         if (isset($params[3])) {
           echo "<br /><b>Require block parameter: </b>";
           echo '<pre style="background: Azure">TRUE</pre></small>';
         }
       };
      $this->methods[$name] = \Closure::bind(${$name}, $this, get_class());
    }
  }

  function __call($method, $args) {
    if(is_callable($this->methods[$method])) {
      return call_user_func_array($this->methods[$method], $args);
    }
  }
}
