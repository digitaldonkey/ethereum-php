<?php

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Better disable access in production.
 */
if (!IS_PUBLIC) {
    header("HTTP/1.1 401 Unauthorized");
    die('ACCESS DENIED');
}

function printTable($rows) {
    echo "<table>";
    foreach ($rows as $row){
        echo "<tr style='border: 1px solid lightgray'>";
        echo    "<td style='border: 1px solid lightgray'>" . $row[0] . "</td>";
        echo    "<td style='border: 1px solid lightgray'>" . $row[1] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
