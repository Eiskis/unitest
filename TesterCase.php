<?php

class TesterCase {

	/**
	* Properties
	*/
	protected $propertyStatus = null;



	/**
	* Script variables
	*/
	public function scriptVariables () {
		return $this->propertyScriptVariables;
	}



	/**
	* Status
	*/
	public function status () {
		return $this->propertyStatus;
	}



	/**
	* Run all tests
	*/
	public function runTests () {
		foreach ($this->testMethods() as $testMethod) {
			$this->runTest($testMethod)
		}
		return $this;
	};



	/**
	* Find all tests
	*/
	public function runTest ($method) {
		if (method_exists($this, $method)) {
			call_user_func_array(array($this, $method), $this->scriptVariables())
		}
	};



	/**
	* Type checking
	*/
	protected function isAType ($type) {
		return in_array($type,
			array(
				'array',
				'bool',
				'boolean',
				'float',
				'int',
				'integer',
				'null',
				'numeric',
				'object',
				'resource',
				'scalar',
				'string',
			)
		);
	}
}

?>