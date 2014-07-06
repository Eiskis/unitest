<?php

/**
* Unitest
*
* A one-class miniature unit testing framework for PHP.
*
* This class is a test suite that can test methods, and contain child suites. It can also search for more test files in the file system and generate suites automatically.
*
*
*
* Version 0.1.0
*
* Released under MIT License
* Authored by Jerry Jäppinen
* http://eiskis.net/
* eiskis@gmail.com
*
* https://bitbucket.org/Eiskis/unitest/
*/
class Unitest {



	// Basics

	/**
	* Properties
	*/
	private $propertyChildren   = array();
	private $propertyInjections = array();
	private $propertyParent     = null;
	private $propertyPrefix     = 'test';

	/**
	* Initialization
	*
	* Parent suite and script variables can be passed
	*/
	final public function __construct ($parent = null) {
		return $this->parent($parent);
	}

	/**
	* String conversion
	*/
	final public function __toString () {
		return get_class($this);
	}



	// Public getters

	/**
	* Add a suite as a child of this suite
	*/
	private function child ($child) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if ($this->isValidSuite($argument)) {

				// Store reference to this in the child
				$argument->parent($this, true);

				// Add to own flock
				$this->propertyChildren[] = $argument;

			}
		}
		return $this;
	}

	/**
	* Child suites
	*/
	final public function children () {

		// Set
		$arguments = func_get_args();
		if (!empty($arguments)) {
			return call_user_func_array(array($this, 'child'), $arguments);
		}

		// Get
		return $this->propertyChildren;
	}

	/**
	* Add an injectable value that can be passed to functions as parameter
	*/
	final public function inject ($name, $value) {
		if (is_string($name)) {

			// Sanitize variable name
			$name = str_replace('-', '', preg_replace('/\s+/', '', $name));
			if (!empty($name)) {
				$this->propertyInjections[$name] = $value;
			}

		}
		return $this;
	}

	/**
	* Script variables available for test methods
	*/
	final public function injections () {

		// Set
		$arguments = func_get_args();
		if (!empty($arguments)) {
			return call_user_func_array(array($this, 'inject'), $arguments);
		}

		// Get own injections, bubble
		$results = array();
		if ($this->parent()) {
			$results = array_merge($results, $this->parent()->injections());
		}
		$results = array_merge($results, $this->propertyInjections);	


		return $results;
	}

	/**
	* Parent suite
	*/
	final public function parent ($parent = null, $parentKnows = false) {

		// Set
		if (isset($parent)) {

			// Validate parent
			if (!$this->isValidSuite($parent)) {
				throw new Exception('Invalid parent suite passed to "scrapeDirectory".');
			} else {

				// Parent case adds this to its flock if needed
				if (!$parentKnows) {
					$parent->child($this);
				}

				// This stores a reference to its dad
				$this->propertyParent = $parent;

			}

			return $this;
		}

		// Get
		return $this->propertyParent;
	}

	/**
	* All parents
	*/
	final public function parents () {
		$parents = array();
		if ($this->parent()) {
			$parents = array_merge(array(''.$this->parent()), $this->parent()->parents());
		}
		return $parents;
	}

	/**
	* Test method prefix
	*/
	final public function prefix () {
		return $this->propertyPrefix;
	}

	/**
	* All test methods of this suite
	*/
	final public function tests () {
		$tests = array();

		// All class methods
		foreach (get_class_methods($this) as $method) {

			// Class methods with the correct prefix
			if (substr($method, 0, strlen($this->prefix())) === $this->prefix()) {

				// Prefixed methods that aren't declared in base class
				$ref = new ReflectionMethod($this, $method);
				$class = $ref->getDeclaringClass();
				if ($class->name !== 'Unitest') {
					$tests[] = $method;
				}

			}
		}

		return $tests;
	}



	// Running tests

	/**
	* Run tests, some or all
	*/
	final public function run () {
		$arguments = func_get_args();

		$results = array(
			'children' => array(),
			'class'    => get_class($this),
			'parents'  => $this->parents(),
			'tests'    => array(),

			'failed'   => 0,
			'passed'   => 0,
			'skipped'  => 0,
		);

		// Default to tests of this and children arguments
		if (empty($arguments)) {
			$arguments = array($this->tests(), $this->children());
		}

		// Flatten arguments
		$suitesOrTests = $this->flattenArray($arguments);

		// Run tests
		foreach ($suitesOrTests as $suiteOrTest) {

			// Child suite
			if ($this->isValidSuite($suiteOrTest)) {
				$results['children'][] = $suiteOrTest->run(array_merge($suiteOrTest->tests(), $suiteOrTest->children()));

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
		$injections = array();
		$result = $this->skip();

		if (method_exists($this, $method)) {

			// Contain errors/exceptions
			set_error_handler('UnitestHandleError');
			try {
				$availableInjections = $this->injections();

				// Find parameters to pass to test method
				foreach ($this->methodParameterNames($method) as $parameterName) {
					if (array_key_exists($parameterName, $availableInjections)) {
						$injections[] = $availableInjections[$parameterName];
					}
				}

				// Call test method
				$result = call_user_func_array(array($this, $method), $injections);

			// Fail test if there are errors/exceptions
			} catch (Exception $e) {
				$result = $this->fail($e->getMessage().' ('.$e->getFile().' line '.$e->getLine().')');
			}

			restore_error_handler();

		}

		// Test report
		return array(
			'class'      => ''.$this,
			'injections' => $injections,
			'message'    => $result,
			'method'     => $method,
			'parents'    => $this->parents(),
			'status'     => $this->assess($result),
		);
	}

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



	// Reports

	final public function counts ($report) {
		$counts = array(
			'total' => 0,
			'failed' => 0,
			'passed' => 0,
			'skipped' => 0,
		);

		foreach ($this->digest($report) as $suite) {
			$counts['total'] += count($suite);
			foreach ($suite as $test) {
				$counts[$test['status']]++;
			}
		}

		return $counts;
	}

	final public function digest ($report) {
		$results = array();

		// Quickly validate incoming report
		if (is_array($report) and isset($report['children']) and isset($report['tests'])) {

			// Sort test results by status
			foreach ($report['tests'] as $testResult) {
				$results[$testResult['class']][] = $testResult;
			}

			// Merge child suite results
			foreach ($report['children'] as $childResults) {
				$new = $this->digest($childResults);
				$results = array_merge($results, $new);
			}

		// Return report as it was given
		} else {
			$results = $report;
		}

		return $results;
	}



	// Assertions

	/**
	* Truey
	*/
	final public function should ($value) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if (!$argument) {
				return $this->fail();
			}
		}
		return $this->pass();
	}

	/**
	* Falsey
	*/
	final public function shouldNot ($value) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if ($argument) {
				return $this->fail();
			}
		}
		return $this->pass();
	}

	/**
	* Equality
	*/
	final public function shouldBeEqual ($value) {
		$arguments = func_get_args();
		$count = count($arguments);
		if ($count > 1) {
			for ($i = 1; $i < $count; $i++) { 
				if ($arguments[$i-1] !== $arguments[$i]) {
					return $this->fail();
				}
			}
		}
		return $this->pass();
	}

	/**
	* Non-equality
	*/
	final public function shouldNotBeEqual ($value) {
		$arguments = func_get_args();
		return !call_user_func_array(array($this, 'shouldBeEqual'), $arguments);
	}

	/**
	* Should be of a specific class. Fails if passed non-objects or no objects.
	*/
	final public function shouldBeOfClass ($className, $value) {
		$arguments = func_get_args();
		array_shift($arguments);

		// No objects to test
		if (empty($arguments)) {
			return $this->fail();
		} else {
			foreach ($arguments as $argument) {

				// Not an object
				if (!is_object($argument)) {
					return $this->fail();

				// Wrong class
				} else if (get_class($argument) !== $className) {
					return $this->fail();
				}

			}

		}

		return $this->pass();
	}

	/**
	* Should be of any class that extends a specific class. Fails if passed non-objects or no objects.
	*/
	final public function shouldExtendClass ($className, $value) {
		$arguments = func_get_args();
		array_shift($arguments);

		// No objects to test
		foreach ($arguments as $value) {

			// Not an object
			if (!is_object($value)) {
				return $this->fail();

			// Wrong class
			} else if (!is_subclass_of($value, $className)) {
				return $this->fail();
			}

		}

		return $this->pass();
	}



	// Assessing a test result

	final protected function assess ($value) {
		if ($this->passes($value)) {
			return 'passed';
		} else if ($this->skips($value)) {
			return 'skipped';
		}
		return 'failed';
	}

	final protected function fails ($value) {
		return !($this->passes($value) or $this->skips($value));
	}

	final protected function passes ($value) {
		return $value === true;
	}

	final protected function skips ($value) {
		return $value === null;
	}



	// Private helpers: assertions

	/**
	* Test can fail with false, or a message (any value but null or true)
	*/
	private function fail () {
		$arguments = func_get_args();
		$count = func_num_args();

		// Empty value is returned as false, otherwise returned as message
		if ($count === 1) {
			return !empty($arguments[0]) ? $arguments[0] : false;

		// Multiple values provided, fail with those as message
		} else if ($count > 1) {
			return $arguments;
		}

		// Default to false
		return false;
	}

	/**
	* Test always passes with true
	*/
	private function pass () {
		return true;
	}

	/**
	* Test skipped with null
	*/
	private function skip () {
		return true;
	}



	// Private helpers: miscellaneous

	/**
	* Find out which classes will be defined in a script
	*/
	private function classesInScript ($code = '') {
		$classes = array();

		// Find tokens that are classes
		$tokens = token_get_all($code);
		for ($i = 2; $i < count($tokens); $i++) {

			// Assess tokens to find class declarations of subclasses
			if (
				$tokens[$i-2][0] === T_CLASS and
				$tokens[$i-1][0] === T_WHITESPACE and
				$tokens[$i][0]   === T_STRING and
				$tokens[$i+1][0] === T_WHITESPACE and
				$tokens[$i+2][0] === T_EXTENDS and
				$tokens[$i+3][0] === T_WHITESPACE and
				$tokens[$i+4][0] === T_STRING
			) {
				$inheritedFrom = $tokens[$i+4][1];

				// See if class extends Unitest
				if ($this->isValidSuiteClass($inheritedFrom)) {
					$classes[] = $tokens[$i][1];
				}

			}
		}

		return $classes;
	}

	/**
	* Flatten an array
	*/
	private function flattenArray ($array) {
		$result = array();
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				$result = array_merge($result, $this->flattenArray($value));
			} else {
				$result[] = $value;
			}
		}
		return $result;
	}

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
		if ($class === 'Unitest' or $ref->isSubclassOf('Unitest')) {
			return true;
		}
		return false;
	}

	/**
	* Find out which variables a method is expecing
	*/
	private function methodParameterNames ($method) {
		$results = array();
		$ref = new ReflectionMethod($this, $method);
		foreach ($ref->getParameters() as $parameter) {
			$results[] = $parameter->name;
		}
		return $results;
	}



	// Private helpers: file system

	/**
	* Find directories
	*/
	private function globDir ($path = '') {

		// Normalize path
		if (!empty($path)) {
			$path = preg_replace('/(\*|\?|\[)/', '[$1]', $path);
			if (substr($path, -1) !== '/') {
				$path .= '/';
			}
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
			$path = preg_replace('/(\*|\?|\[)/', '[$1]', $path);
			if (substr($path, -1) !== '/') {
				$path .= '/';
			}
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
	* Find PHP test files in a directory
	*/
	final private function scrapeDirectory ($path, $parent) {

		// Validate parent
		if (!$this->isValidSuite($parent)) {
			throw new Exception('Invalid parent suite passed to "scrapeDirectory".');
		}

		if (is_dir($path)) {

			// PHP files
			foreach ($this->globFiles($path, array('php')) as $file) {
				$this->scrapeFile($file, $parent);
			}

			// Subdirectories
			foreach ($this->globDir($path) as $dir) {
				$directorySuite = new Unitest($parent);
				call_user_func(array($this, 'scrapeDirectory'), $dir, $directorySuite);
			}

		}

		return $this;
	}

	/**
	* Include PHP tests in a file
	*/
	final private function scrapeFile ($path, $parent) {

		// Validate parent
		if (!$this->isValidSuite($parent)) {
			throw new Exception('Invalid parent suite passed to "scrapeFile".');
		}

		if (is_file($path)) {

			// Look for any Unitest classes
			$classes = $this->classesInScript(file_get_contents($path));

			// Include if found
			if (!empty($classes)) {
				include_once $path;
			}

			// Instantiate new classes as child suites under this
			foreach ($classes as $class) {
				$suite = new $class($parent);
			}

		}

		return $this;
	}



	// Debugging and development

	/**
	* Flatten an array
	*/
	final public function dump () {

		$results = array(
			'class' => ''.$this,
			'children' => array(),
			'injections' => $this->injections(),
			'parent' => $this->parent() ? ''.$this->parent() : null,
			'parents' => $this->parents(),
			'tests' => $this->tests(),
		);

		foreach ($this->children() as $child) {
			$results['children'][] = $child->dump();
		}

		return $results;
	}

}



function UnitestHandleError ($errno, $errstr, $errfile, $errline, array $errcontext) {
	throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}

?>