<?php
error_reporting(E_ALL);
ini_set('log_errors', '1');
// ini_set('error_log', 'errors.log');
mb_internal_encoding('UTF-8');
date_default_timezone_set('UTC');

// Always JSON
header('Content-type: application/json');

// Baseline is not needed by Unitest
require_once '../Unitest.php';
require_once 'baseline.php';

// Defaults
$lib = '';
$path = '';
$injections = array();
$input = array();

// Take input
if ((isset($_GET) and !empty($_GET)) or (isset($_POST) and !empty($_POST))) {
	$input = array_merge($_POST, $_GET);

	// Spec path(s)
	if (isset($input['path']) and (is_string($input['path']) or is_array($input['path']))) {
		$path = $input['path'];
	}

	// Lib path(s)
	if (isset($input['lib']) and (is_string($input['lib']) or is_array($input['lib']))) {
		$lib = $input['lib'];
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

// No path given
if (empty($path)) {
	header('HTTP/1.1 400 Bad Request');
} else {

	// Load lib
	if (!empty($input['lib'])) {
		$input['lib'] = array_flatten(to_array($input['lib']));
		foreach ($input['lib'] as $value) {
			if (is_string($value)) {
				if (is_file($value)) {
					include_once $value;
				} else if (is_dir($value)) {
					foreach (rglob_files($value) as $file) {
						include_once $value;
					}
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