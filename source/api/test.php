<?php

class Unitest {

	/**
	* Run an individual test method
	*/
	final public function test ($method) {
		$injections = array();
		$result = $this->skip();
		$duration = 0;

		if (method_exists($this, $method)) {
			$startTime = microtime(true);

			// Take a snapshot of current injections
			$allInjectionsCopy = $this->injections();

			// Contain exceptions of test method
			try {

				// Preparation method
				$this->_runBeforeTest();

				// Get innjections to pass to test method
				foreach ($this->_methodParameterNames($this, $method) as $parameterName) {
					$injections[] = $this->injection($parameterName);
				}

				// Call test method
				$result = $this->_execute($method, $injections);

			// Fail test if there are exceptions
			} catch (Exception $e) {
				$result = $this->fail($this->_stringifyException($e));
			}

			// Contain exceptions of clean-up
			try {
				$this->_runAfterTest();
			} catch (Exception $e) {
				$result = $this->fail($this->_stringifyException($e));
			}

			// Restore injections as they were before the test
			$this->_propertyInjections = $allInjectionsCopy;

			$duration = microtime(true) - $startTime;
		}

		// Test report
		return array(
			'class'      => $this->_className($this),
			'duration'   => $duration,
			'method'     => $method,
			'file'       => $this->_classFile($this),
			'line'       => $this->_methodLineNumber($this, $method),
			'status'     => $this->assess($result),
			'message'    => $result,
			'injections' => $injections,
		);
	}

}

?>