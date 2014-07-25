<?php

require_once 'compile/baseline.php';
require_once 'Unitest.php';
$u = new Unitest();

echo '<pre>'.var_export($u->assertions(), true).'</pre>';

?>