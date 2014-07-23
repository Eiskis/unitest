<?php

$files = array(
	'Unitest.php',
	'html/conf.php',
	'json/baseline.php',
);
foreach ($files as $file) {
	include_once $file;
}
$treatedFiles = $files;
foreach ($treatedFiles as $key => $treatedFile) {
	$treatedFiles[$key] = realpath($treatedFile);
}

echo '<pre>'.var_export(array($files, $treatedFiles, get_included_files()), true).'</pre>';

?>