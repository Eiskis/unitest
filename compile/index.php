<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', '1');
ini_set('log_errors', '1');
mb_internal_encoding('UTF-8');
date_default_timezone_set('UTC');



/**
* Merge all source files into a single file for distribution
*/

// Basic variables
$root = '../';
$sourcePath = $root.'source/';
$exportPath = $root.'Unitest.php';
$tempPath = 'TempUnitest.php';
$output = '';

// Something for parsing
$prefix = '<?php

class Unitest {';
$suffix = '}

?>';

// Helpers
require_once 'baseline.php';

// Go through all source files
$classOutput = '';
foreach (rglob_files($sourcePath, 'php') as $file) {
	$fileContents = trim(file_get_contents($file));
	$prefixLength = strlen($prefix);
	$suffixLength = strlen($suffix);

	// Remove PHP start tag
	if (substr($fileContents, 0, $prefixLength) === $prefix) {
		$fileContents = substr($fileContents, $prefixLength);
	}

	// Remove PHP end tag
	if (substr($fileContents, -$suffixLength) === $suffix) {
		$fileContents = substr($fileContents, 0, strlen($fileContents)-$suffixLength);
	}

	$classOutput .= "\n\n".'	'.trim($fileContents)."\n\n";
	unset($fileContents);
}

// Wrap output in PHP tags to include temporarily
$tempOutput = '<?php
class TempUnitest {
'.$classOutput.'
}
?>';
file_put_contents($tempPath, $tempOutput);
require_once $tempPath;



// Output aliasing declarations
$aliasesOutput = '';
require_once 'aliases.php';
unlink($tempPath);



// Wrap final output in PHP tags, add comments
$output = '<?php

/**
* Unitest 0.1.0
*
* A one-class miniature unit testing framework for PHP.
*
* This class is a test suite that can contain test methods and child suites. It can also search for test files in the file system, generating suites automatically.
*
* Test results are reported as raw array data, which can then be converted into HTML, JSON or any other format easily.
*
*
*
* Released under MIT License
* Authored by Jerry Jäppinen
* http://eiskis.net/
* eiskis@gmail.com
*
* https://bitbucket.org/Eiskis/unitest/
*/

class Unitest {

'.$classOutput.'

	/**
	* Aliases
	*/

'.$aliasesOutput.'

}

function __UnitestHandleError ($errno, $errstr, $errfile, $errline, array $errcontext) {
	throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
	return true;
}

?>';



// Optional saving, on localhost
if (!isset($_GET['dontsave']) and in_array($_SERVER['SERVER_ADDR'], array('127.0.0.1', '::1'))) {

	// Create export path
	$dir = pathinfo($exportPath, PATHINFO_DIRNAME).'/';
	if ((is_dir($dir) or mkdir($dir, 0777, true)) and is_writable($dir)) {

		// Save output
		file_put_contents($exportPath, $output);

		// Re-read output back to make sure we get an accurate reflection of what was saved
		$output = '';
		$output = file_get_contents($exportPath);

	} else {
		throw new Exception('Cannot write to export directory', 500);
	}


}

// Output
header('Content-Type: text/plain;charset=utf-8');
echo $output;

die();

?>