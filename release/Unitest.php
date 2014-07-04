<?php

/**
* Unitest
*
* A one-class miniature unit testing framework for PHP.
*
* This class is a test suite that can test methods, and contain child suites. It can also search for more test files in the file system and generate suites automatically.
*
* http://eiskis.net/unitest/
*/
class Unitest {



	// Basics

	/**
	* Properties
	*/
	private $propertyClassName       = 'Unitest';
	private $propertyTestPrefix      = 'test';

	private $propertyChildren        = null;
	private $propertyParent          = null;
	private $propertyScriptVariables = null;

	/**
	* Initialization
	*
	* Parent suite and script variables can be passed
	*/
	final public function __construct ($parent = null, $scriptVariables = array()) {
		return $this->setParent($parent)->setScriptVariables($scriptVariables);
	}

	/**
	* String conversion
	*/
	final public function __toString () {
		return get_class($this);
	}



	// Getters

	/**
	* Child suites
	*/
	final public function children () {
		return $this->propertyChildren;
	}

	/**
	* Parent suite
	*/
	final public function parent () {
		return $this->propertyParent;
	}

	/**
	* Script variables
	*/
	final public function scriptVariables () {
		$scriptVariables = array();
		if ($this->parent()) {
			$scriptVariables = array_merge($scriptVariables, $scriptVariables);
		}
		$scriptVariables = array_merge($scriptVariables, $this->propertyScriptVariables);	
		return $scriptVariables;
	}



	// Dynamic getters

	/**
	* All test methods of this suite
	*/
	final public function ownTests () {
		$tests = array();
		$all = get_class_methods($this);

		foreach ($all as $methodName) {
			if (substr($methodName, 0, strlen($this->propertyTestPrefix)) === $this->propertyTestPrefix) {
				$tests[] = $methodName;
			}
		}
		return $tests;
	}



	// Managing suites

	/**
	* Find declared classes that extend Unitest
	*/
	final public function availableSuites () {
		$available = array();
		foreach(get_declared_classes() as $class){
			$ref = new ReflectionClass($class);
			if ($ref->isSubclassOf($this->propertyClassName)) {
				$available[] = $class;
			}
		}
		return $available;
	}

	/**
	* Add a valid child suite as a child of this suite
	*/
	final public function addChild () {
		$arguments = func_get_args();
		foreach ($arguments as $child) {
			if ($this->isValidSuite($child)) {
				$this->propertyChildren[] = $child;
			}
		}
		return $this;
	}



	// Managing Files

	/**
	* Find tests in locations
	*/
	final public function scrape () {
		$arguments = func_get_args();

		foreach ($arguments as $argument) {
			if (is_string($argument)) {
				if (is_file($argument)) {
					$this->handleFile($argument);
				} else if (is_dir($argument)) {
					$this->handleDirectory($argument);
				}
			} else if (is_array($argument)) {
				call_user_func_array(array($this, 'scrape'), $argument);
			}
		}

		return $this;
	}

	/**
	* Find PHP test files in a directory
	*
	* FLAG no results
	*/
	final private function handleDirectory ($path, $parent = null) {

		// Validate parent
		if (!isset($parent)) {
			$parent = $this;
		} else if (!$this->isValidSuite($parent)) {
			throw new Exception('Invalid parent suite passed to "handleDirectory".');
			
		}

		if (is_string($path)) {

			// Create parent suite for the directory
			$directorySuite = new $this->propertyClassName($parent);

			// PHP files
			foreach ($this->globFiles($path, array('php')) as $file) {
				$this->handleFile($file);
			}

			// Subdirectories
			foreach ($this->globDir($path) as $dir) {
				call_user_func(array($this, 'handleDirectory'), $dir, $directorySuite);
			}

		}

		return $this;
	}

	/**
	* Include PHP tests in a file
	*
	* FLAG
	*   - Should detect (new) Unitest classes
	*   - Instantiate new suites
	*   - Add new suites as child suites
	*/
	final private function handleFile ($path) {

		if (is_file($path)) {
			include_once $path;
			$results[] = $path;
		}

		return $this;
	}



	// Running tests

	/**
	* Run an individual test method
	*/
	final public function runTest ($method) {
		$result = null;
		if (method_exists($this, $method)) {
			set_error_handler('UnitestHandleError');
			try {
				$result = call_user_func_array(array($this, $method), $this->scriptVariables()) ? true : false;
			} catch (Exception $e) {
				$result = $e->getMessage().' ('.$e->getFile().' line '.$e->getLine().')';
			}
			restore_error_handler();
		}
		return $result;
	}

	/**
	* Run all own tests
	*/
	final public function runOwnTests () {
		$results = array(
			'passed' => 0,
			'failed' => 0,
			'skipped' => 0,
			'results' => array(),
		);
		foreach ($this->ownTests() as $method) {
			$result = $this->runTest($method);
			$results['results'][$method] = $result;
			if (!isset($result)) {
				$results['skipped']++;
			} else if ($result === true) {
				$results['passed']++;
			} else {
				$results['failed']++;
			}
		}
		return $results;
	}

	/**
	* Run tests of all children
	*/
	final public function runChildrensOwnTests () {
		$results = array();
		foreach ($this->children() as $childCase) {
			$results[$childCase.''] = $childCase->runOwnTests();
		}
		return $results;
	}



	// Assertions

	/**
	* Truey
	*/
	final public function assert () {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if (!$argument) {
				return false;
			}
		}
		return true;
	}

	/**
	* Equality
	*/
	final public function assertEquals () {
		$arguments = func_get_args();
		$count = count($arguments);
		if ($count > 1) {
			for ($i = 1; $i < $count; $i++) { 
				if ($arguments[$i-1] !== $arguments[$i]) {
					return false;
				}
			}
		}
		return true;
	}



	// Setters

	/**
	* Parent
	*/
	private function setParent ($parentCase) {
		if ($this->isValidSuite($parentCase)) {

			// Parent case adds this to its flock
			$parentCase->addChild($this);

			// This stores a reference to its dad
			$this->propertyParent = $parentCase;

		}
		return $this;
	}

	/**
	* Script variables
	*
	* Each will have to have a valid variable name as key
	*/
	private function setScriptVariables ($scriptVariables = array()) {
		$results = array();

		foreach ($scriptVariables as $key => $value) {
			if (is_string($key)) {
				$results[preg_replace('/\s+/', '', $key)] = $value;
			}
		}

		$this->propertyScriptVariables = $results;

		return $this;
	}



	// Private helpers

	/**
	* Validate a case object
	*/
	private function isValidSuite ($case) {
		return isset($case) and (
			get_class($case) === $this->propertyClassName or
			is_subclass_of($case, $this->propertyClassName)
		);
	}

	/**
	* Finding files
	*/

	// private function rglobFiles ($path = '', $filetypes = array()) {

	// 	// Run glob_files for this directory and its subdirectories
	// 	$files = $this->globFiles($path, $filetypes);
	// 	foreach ($this->globDir($path) as $child) {
	// 		$files = array_merge($files, $this->rglobFiles($child, $filetypes));
	// 	}

	// 	return $files;
	// }

	private function globFiles ($path = '', $filetypes = array()) {
		$files = array();

		// Handle filetype input
		if (empty($filetypes)) {
			$brace = '';
		} else {
			$brace = '.{'.implode(',', $filetypes).'}';
		}

		// Handle path input
		if (!empty($path)) {
			$path = preg_replace('/(\*|\?|\[)/', '[$1]', suffix($path, '/'));
		}

		// Do the glob()
		foreach (glob($path.'*'.$brace, GLOB_BRACE) as $value) {
			if (is_file($value)) {
				$files[] = $value;
			}
		}

		// Sort results
		usort($files, 'strcasecmp');

		return $files;
	}

	private function globDir ($path = '') {

		// Normalize path
		if (!empty($path)) {
			$path = preg_replace('/(\*|\?|\[)/', '[$1]', suffix($path, '/'));
		}

		// Find directories in the path
		$directories = glob($path.'*', GLOB_MARK | GLOB_ONLYDIR);
		foreach ($directories as $key => $value) {
			$directories[$key] = str_replace('\\', '/', $value);
		}
		
		// Sort results
		usort($directories, 'strcasecmp');

		return $directories;
	}


}



function UnitestHandleError ($errno, $errstr, $errfile, $errline, array $errcontext) {
	throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}

?>