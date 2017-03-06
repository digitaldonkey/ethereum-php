<?php

/**
 * printMe().
 */
function printMe($title, $content = NULL) {
  echo "<p><b>" . $title . "</b></p>";
  if ($content) {
    echo '<pre style="background: Azure">';
    if (is_array($content)) {
      print_r($content);
    }
    else {
      echo ($content);
    }
    echo "</pre>";
  }
}
