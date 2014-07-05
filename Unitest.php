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
	private $propertyId     	= '';
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
	* Child suites
	*/
	final public function children () {
		return $this->propertyChildren;
	}

	/**
	* Optional ID
	*/
	final public function id ($id = null) {
		if (isset($id) and is_string($id)) {
			return $this->setId($id);
		}
		return $this->propertyId;
	}

	/**
	* Script variables available for test methods
	*/
	final public function inject () {
		$arguments = func_get_args();
		return call_user_func_array(array($this, 'setInjection'), $arguments);
	}

	/**
	* Script variables available for test methods
	*/
	final public function injections () {

		// Set
		if (func_num_args() > 1) {
			$arguments = func_get_args();
			return $this->setInjection($arguments[0], $arguments[1]);
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
	* All test methods of this suite
	*/
	final public function ownTests () {
		$tests = array();

		// Filter from all class methods
		foreach (get_class_methods($this) as $methodName) {
			if (substr($methodName, 0, strlen($this->prefix())) === $this->prefix()) {
				$tests[] = $methodName;
			}
		}

		return $tests;
	}

	/**
	* Parent suite
	*/
	final public function parent ($parent = null, $parentKnows = false) {
		if (isset($parent)) {
			return $this->setParent($parent, $parentKnows);
		}
		return $this->propertyParent;
	}

	/**
	* Test method prefix
	*/
	final public function prefix () {
		return $this->propertyPrefix;
	}



	// Running tests

	/**
	* Run tests, some or all
	*/
	final public function run () {
		$arguments = func_get_args();

		$results = array(
			'class'    => get_class($this),
			'id'       => $this->id(),
			'tests'    => array(),
			'children' => array(),
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
				$results['children'][] = $suiteOrTest->run(array_merge($suiteOrTest->ownTests(), $suiteOrTest->children()));

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
		$result = $this->skip();

		if (method_exists($this, $method)) {

			// Contain errors/exceptions
			set_error_handler('UnitestHandleError');
			try {
				$injections = array();
				$availableInjections = $this->injections();

				// Find parameters to pass to test method
				foreach ($this->methodParameterNames($method) as $parameterName) {
					if (array_key_exists($parameterName, $availableInjections)) {
						$injections[] = $availableInjections[$parameterName];
					}
				}

				// Call test method
				$result = call_user_func_array(array($this, $method), $injections) ? true : false;

			// Fail test if there are errors/exceptions
			} catch (Exception $e) {
				$result = $this->fail($e->getMessage().' ('.$e->getFile().' line '.$e->getLine().')');
			}
			restore_error_handler();

		}

		return $result;
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



	// Assessing a test result

	final public function assess ($value) {
		if ($this->passed($value)) {
			return 'passed';
		} else if ($this->skipped($value)) {
			return 'skipped';
		}
		return 'failed';
	}

	final public function failed ($value) {
		return !($this->passed($value) or $this->skipped($value));
	}

	final public function passed ($value) {
		return $value === true;
	}

	final public function skipped ($value) {
		return $value === null;
	}



	// Reports

	final public function asNumbers ($report) {
		$results = array();
		$total = 0;
		foreach ($this->byStatus($report) as $key => $values) {
			$results[$key] = count($values);
			$total += $results[$key];
		}
		$results = array_merge(array('total' => $total), $results);
		return $results;
	}

	final public function byStatus ($report, $key = '') {

		$results = array(
			'total' => array(),
			'failed' => array(),
			'passed' => array(),
			'skipped' => array(),
		);

		// Quickly validate incoming report
		if (is_array($report) and isset($report['children']) and isset($report['tests'])) {

			// Sort test results by status
			foreach ($report['tests'] as $name => $testResult) {
				$results['total'][$key][$name] = $testResult;
				$results[$this->assess($testResult)][$key][$name] = $testResult;
			}

			// Merge child suite results
			foreach ($report['children'] as $childResults) {
				$new = $this->byStatus($childResults, $childResults['class'].($childResults['id'] ? ' ('.$childResults['id'].')' : ''));
				foreach ($results as $key => $existing) {
					$results[$key] = array_merge($results[$key], $new[$key]);
				}
			}

		}

		return $results;
	}



	// Assertions

	/**
	* Truey
	*/
	final public function should () {
		$values = func_get_args();
		foreach ($values as $value) {
			if (!$value) {
				return $this->fail();
			}
		}
		return $this->pass();
	}

	/**
	* Falsey
	*/
	final public function shouldNot () {
		$arguments = func_get_args();
		return !call_user_func_array(array($this, 'should'), $arguments);
	}

	/**
	* Equality
	*/
	final public function shouldBeEqual () {
		$values = func_get_args();
		$count = count($values);
		if ($count > 1) {
			for ($i = 1; $i < $count; $i++) { 
				if ($values[$i-1] !== $values[$i]) {
					return $this->fail();
				}
			}
		}
		return $this->pass();
	}

	/**
	* Should be of a specific class. Fails if passed non-objects or no objects.
	*/
	final public function shouldBeOfClass ($className) {
		$values = func_get_args();
		array_shift($values);

		// No objects to test
		if (empty($values)) {
			return $this->fail();
		} else {
			foreach ($values as $value) {

				// Not an object
				if (!is_object($value)) {
					return $this->fail();

				// Wrong class
				} else if (get_class($value) !== $className) {
					return $this->fail();
				}

			}

		}

		return $this->pass();
	}

	/**
	* Should be of any class that extends a specific class. Fails if passed non-objects or no objects.
	*/
	final public function shouldExtendClass ($className) {
		$values = func_get_args();
		array_shift($values);

		// No objects to test
		if (empty($values)) {
			return $this->fail();
		} else {
			foreach ($values as $value) {

				// Not an object
				if (!is_object($value)) {
					return $this->fail();

				// Wrong class
				} else if (!is_subclass_of($value, $className)) {
					return $this->fail();
				}

			}

		}

		return $this->pass();
	}



	// Setters

	/**
	* Add a suite as a child of this suite
	*/
	private function setChild () {
		$arguments = func_get_args();
		foreach ($arguments as $child) {
			if ($this->isValidSuite($child)) {

				// Store reference to this in the child
				$child->parent($this, true);

				// Add to own flock
				$this->propertyChildren[] = $child;

			}
		}
		return $this;
	}

	/**
	* Add an optional ID for this suite
	*/
	private function setId ($id) {
		if (isset($id) and is_string($id)) {
			$id = $this->trim($id);
			$this->propertyId = $id;
		}
		return $this;
	}

	/**
	* Add an injectable value that can be passed to functions as parameter
	*/
	private function setInjection ($name, $value) {

		if (is_string($name)) {

			// Validate variable name
			$name = str_replace('-', '', $this->trim($name));
			if (!empty($name)) {
				$this->propertyInjections[$name] = $value;
			}
		}

		return $this;
	}

	/**
	* Parent
	*/
	private function setParent ($parentCase, $parentKnows = false) {
		if ($this->isValidSuite($parentCase)) {

			// Parent case adds this to its flock if needed
			if (!$parentKnows) {
				$parentCase->setChild($this);
			}

			// This stores a reference to its dad
			$this->propertyParent = $parentCase;

		}
		return $this;
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
		if ($ref->isSubclassOf('Unitest')) {
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

			// We include them here
			include_once $path;

			// These Unitest classes will be defined
			$classes = $this->classesInScript(file_get_contents($path));

			// Instantiate new classes as child suites under this
			foreach ($classes as $class) {
				$suite = new $class($parent);
				$suite->id($path);
			}

		}

		return $this;
	}

	/**
	* Trim whitespace from string
	*/
	final private function trim ($string) {
		return is_string($string) ? preg_replace('/\s+/', '', $string) : $string;
	}



	// Debugging and development

	/**
	* Flatten an array
	*/
	final public function dump () {

		$results = array(
			'class' => ''.$this,
			'parent' => $this->parent() ? ''.$this->parent() : null,
			'injections' => $this->injections(),
			'ownTests' => $this->ownTests(),
			'children' => array(),
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