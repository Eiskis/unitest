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

	public function dump () {

		$results = array(
			'class' => get_class($this),
			'parent' => get_class($this->parent()),
			'ownTests' => $this->ownTests(),
			'scriptVariables' => $this->scriptVariables(),
			'children' => array(),
		);

		foreach ($this->children() as $child) {
			$results['children'][] = $child->dump();
		}

		return $results;
	}



	// Basics

	/**
	* Properties
	*/
	private $propertyTestPrefix      = 'test';

	private $propertyParent          = null;
	private $propertyChildren        = array();
	private $propertyScriptVariables = array();

	/**
	* Initialization
	*
	* Parent suite and script variables can be passed
	*/
	final public function __construct ($parent = null, $scriptVariables = array()) {

		$this->setParent($parent);
		$this->setScriptVariables($scriptVariables);

		return $this;
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



	// Managing suite and running tests

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

	/**
	* Run tests, some or all
	*/
	final public function run () {
		$arguments = func_get_args();

		$results = array(
			'children' => array(),
			'tests' => array(),
		);

		// Default to tests of this and children arguments
		if (empty($arguments)) {
			$arguments = array($this->ownTests(), $this->children());
		}

		// Flatten arguments
		$suitesOrTests = $this->flattenArray($arguments);

		// Run tests
		foreach ($suitesOrTests as $suiteOrTest) {

			// Child suite
			if ($this->isValidSuite($suiteOrTest)) {
				$results['children'][''.$suiteOrTest] = $suiteOrTest->run(array_merge($suiteOrTest->ownTests(), $suiteOrTest->children()));

			// Test method
			} else if (is_string($suiteOrTest)) {
				$results['tests'][''.$suiteOrTest] = $this->runTest($suiteOrTest);
			}

		}

		return $results;
	}

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



	// Managing Files

	/**
	* Find tests in locations
	*/
	final public function scrape () {
		$arguments = func_get_args();

		foreach ($arguments as $argument) {
			if (is_string($argument)) {
				if (is_file($argument)) {
					$this->scrapeFile($argument, $this);
				} else if (is_dir($argument)) {
					$this->scrapeDirectory($argument, $this);
				}
			} else if (is_array($argument)) {
				call_user_func_array(array($this, 'scrape'), $argument);
			}
		}

		return $this;
	}

	/**
	* Find PHP test files in a directory
	*/
	final private function scrapeDirectory ($path, $parent) {

		// Validate parent
		if (!$this->isValidSuite($parent)) {
			throw new Exception('Invalid parent suite passed to "scrapeDirectory".');
		}

		if (is_dir($path)) {

			// Create parent suite for the directory
			$directorySuite = new Unitest($parent);

			// PHP files
			foreach ($this->globFiles($path, array('php')) as $file) {
				$this->scrapeFile($file, $directorySuite);
			}

			// Subdirectories
			foreach ($this->globDir($path) as $dir) {
				call_user_func(array($this, 'scrapeDirectory'), $dir, $directorySuite);
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
	final private function scrapeFile ($path, $parent) {

		// Validate parent
		if (!$this->isValidSuite($parent)) {
			throw new Exception('Invalid parent suite passed to "scrapeFile".');
		}

		if (is_file($path)) {

			// These Unitest classes will be defined
			$classes = $this->getValidClassesDefinedInScript(file_get_contents($path));

			// We include them here
			include_once $path;

			// Instantiate new classes as child suites under this
			foreach ($classes as $class) {
				$suite = new $class($parent);
			}

		}

		return $this;
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
	* Validate a suite object
	*/
	private function isValidSuite ($case) {
		return isset($case) and is_object($case) and (
			get_class($case) === 'Unitest' or
			is_subclass_of($case, 'Unitest')
		);
	}

	/**
	* Validate a suite class
	*/
	private function isValidSuiteClass ($class) {
		$ref = new ReflectionClass($class);
		if ($ref->isSubclassOf('Unitest')) {
			return true;
		}
		return false;
	}

	/**
	* Find out which classes will be defined in a script
	*/
	private function getValidClassesDefinedInScript ($code = '') {
		$classes = array();

		// Find tokens that are classes
		$tokens = token_get_all($code);
		for ($i = 2; $i < count($tokens); $i++) {
			if ($tokens[$i - 2][0] === T_CLASS && $tokens[$i - 1][0] === T_WHITESPACE && $tokens[$i][0] === T_STRING) {
				$class = $tokens[$i][1];

				// See if class extends Unitest
				if ($this->isValidSuiteClass($class)) {
					$classes[] = $class;
				}

			}
		}

		return $classes;
	}

	/**
	* Find files
	*/
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

	/**
	* Find directories
	*/
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

	/**
	* Flatten an array
	*/
	private function flattenArray ($array) {
		$result = array();
		foreach ($array as $key => $value) {
			if (!is_array($value)) {
				$result[] = $value;
			}
			$result = array_merge($result, array_flatten($value));
		}
		return $result;
	}

}



function UnitestHandleError ($errno, $errstr, $errfile, $errline, array $errcontext) {
	throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}

?>