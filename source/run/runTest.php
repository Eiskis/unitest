<?php

class Unitest {

	/**
	* Run an individual test method
	*/
	final public function runTest ($method) {
		$injections = array();
		$result = $this->skip();
		$duration = 0;

		if (method_exists($this, $method)) {
			$startTime = microtime(true);

			// Contain exceptions of test method
			try {

				// Take a snapshot of current injections
				$allInjectionsCopy = $this->injections();

				// Preparation method
				$this->runBeforeTest($method);

				// Get innjections to pass to test method
				foreach ($this->methodParameterNames($method) as $parameterName) {
					$injections[] = $this->injection($parameterName);
				}

				// Call test method
				$result = $this->execute($method, $injections);

			// Fail test if there are exceptions
			} catch (Exception $e) {
				$result = $this->fail($this->stringifyException($e));
			}

			// Contain exceptions of clean-up
			try {
				$this->runAfterTest($method);
			} catch (Exception $e) {
				$result = $this->fail($this->stringifyException($e));
			}

			// Restore injections as they were before the test
			$this->propertyInjections = $allInjectionsCopy;

			$duration = microtime(true) - $startTime;
		}

		// Test report
		return array(
			'class'      => $this->name(),
			'duration'   => $this->roundExecutionTime($duration),
			'method'     => $method,
			'file'       => $this->file(),
			'line'       => $this->methodLineNumber($method),
			'status'     => $this->assess($result),
			'message'    => $result,
			'injections' => $injections,
		);
	}

}

?>