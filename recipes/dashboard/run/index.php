<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('error_log', 'errors.log');
mb_internal_encoding('UTF-8');
date_default_timezone_set('UTC');

// Always JSON
header('Content-type: application/json');

// Lib
require_once 'Unitest.php';

// Defaults
$path = '';
$injections = array();

// Take input
if ((isset($_GET) and !empty($_GET)) or (isset($_POST) and !empty($_POST))) {
	$input = array_merge($_POST, $_GET);

	// Spec path(s)
	if (isset($input['path']) and (is_string($input['path']) or is_array($input['path']))) {
		$path = $input['path'];
	}

	// Injections
	if (isset($input['injections']) and is_array($input['injections'])) {
		foreach ($input['injections'] as $key => $value) {
			if (is_string($key)) {
				$injections[$key] = $value;
			}
		}
	}

}

// Init
$u = new Unitest();
$u->scrape($path);
$testCount = count($u->tests());
$childCount = count($u->children());

// No tests found
if (!$testCount and !$childCount) {
	header('HTTP/1.1 404 Not Found');
	echo 'No suites available at "'.(realpath($path) ? realpath($path) : $path).'".';

} else {

	// Injections
	foreach ($injections as $key => $value) {
		$u->inject($key, $value);
	}

	// Run tests
	try {
		$report = $u->run();

		// Respond
		header('HTTP/1.1 200 OK');
		echo json_encode($report);

	// Unitest failed (or failed to contain errors)
	} catch (Exception $e) {
		header('HTTP/1.1 500 Internal Server Error');
	}

}

die();
?>