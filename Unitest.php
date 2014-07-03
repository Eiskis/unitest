<?php

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
	* Parent case
	*/
	final public function parent () {
		return $this->propertyParent;
	}

	/**
	* Child test cases
	*/
	final public function children () {
		return $this->propertyChildren;
	}

	/**
	* Script variables
	*/
	final public function scriptVariables () {
		return $this->propertyScriptVariables;
	}



	// Dynamic getters

	/**
	* All test methods
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



	// Actions

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



	// Running tests

	/**
	* Run an individual test method
	*/
	final public function runTest ($method) {
		if (method_exists($this, $method)) {
			call_user_func_array(array($this, $method), $this->scriptVariables());
		}
		return $this;
	}

	/**
	* Run all own tests
	*/
	final public function runOwnTests () {
		foreach ($this->ownTests() as $testMethod) {
			$this->runTest($testMethod);
		}
		return $this;
	}

	/**
	* Run tests of all children
	*/
	final public function runChildrensOwnTests () {
		foreach ($this->children() as $childCase) {
			$childCase->runOwnTests();
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

}

?>