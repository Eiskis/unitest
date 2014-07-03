<?php

class Unitest {

	// Tests (just for debugging)

	public function testMinus () {
		return $this->assert(1-1===0);
	}

	public function testPlus () {
		return $this->assert(1+1===2);
	}



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
	* Parent case and script variables can be passed
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
	* Child cases
	*/
	final public function children () {
		return $this->propertyChildren;
	}

	/**
	* Parent case
	*/
	final public function parent () {
		return $this->propertyParent;
	}

	/**
	* Script variables
	*/
	final public function scriptVariables () {
		return $this->propertyScriptVariables;
	}



	// Dynamic getters

	/**
	* All test methods of this case
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



	// Managing cases

	/**
	* Find declared classes that extend Unitest
	*/
	final public function availableCases () {
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
	* Add a valid child test case as a child
	*/
	final public function addChild () {
		$arguments = func_get_args();
		foreach ($arguments as $childCase) {
			if ($this->isValidCase($childCase)) {
				$this->propertyChildren[] = $childCase;
			}
		}
		return $this;
	}

	/**
	* Generate a new child case
	*/
	final public function nest () {
		$childCase = new $this->propertyClassName($this, $this->scriptVariables());
		return $this;
	}

	/**
	* Find PHP files
	*/
	final public function scrape () {
		$results = array();
		$arguments = func_get_args();

		// Multiple paths can be provided
		foreach ($arguments as $argument) {

			// Scrape path for PHP files
			if (is_string($argument)) {
				foreach ($this->rglobFiles($argument, array('php')) as $file) {
					include_once $file;
					$results[] = $file;
				}

			// Recurse
			} else if (is_array($argument)) {
				call_user_func_array(array($this, 'scrape'), $argument);
			}

		}

		return $results;
	}



	// Running tests

	/**
	* Run an individual test method
	*/
	final public function runTest ($method) {
		if (method_exists($this, $method)) {
			$result = call_user_func_array(array($this, $method), $this->scriptVariables());
			return $result ? true : false;
		}
		return null;
	}

	/**
	* Run all own tests
	*/
	final public function runOwnTests () {
		$results = array();
		foreach ($this->ownTests() as $method) {
			$results[$method] = $this->runTest($method);
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
		if ($this->isValidCase($parentCase)) {

			// Parent case adds this to its flock
			$parentCase->addChild($this);

			// This stores a reference to its dad
			$this->propertyParent($parentCase);

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
	private function isValidCase ($case) {
		return isset($case) and (
			get_class($case) === $this->propertyClassName or
			is_subclass_of($case, $this->propertyClassName)
		);
	}

	/**
	* Finding files
	*/

	private function rglobFiles ($path = '', $filetypes = array()) {

		// Run glob_files for this directory and its subdirectories
		$files = $this->globFiles($path, $filetypes);
		foreach ($this->globDir($path) as $child) {
			$files = array_merge($files, $this->rglobFiles($child, $filetypes));
		}

		return $files;
	}

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

?>