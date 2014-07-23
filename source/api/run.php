<?php

class Unitest {

	/**
	* Run tests, some or all
	*/
	final public function run () {
		$arguments = func_get_args();

		$ref = new ReflectionClass($this);

		$results = array(
			'class'    => $this->className($this),
			'file'     => $this->classFile($this),
			'line'     => $this->classLineNumber($this),
			'parents'  => $this->parents(),

			'duration' => 0,

			'failed'   => 0,
			'passed'   => 0,
			'skipped'  => 0,

			'tests'    => array(),
			'children' => array(),
		);

		// Default to tests of this and children arguments
		if (empty($arguments)) {
			$arguments = array($this->tests(), $this->children());
		}

		// Flatten arguments
		$suitesOrTests = $this->flattenArray($arguments);

		// Preparation before suite runs anything (possible exceptions are left uncaught)
		$this->_runBeforeTests();

		// Run tests
		foreach ($suitesOrTests as $suiteOrTest) {

			// Child suite
			if ($this->isValidSuite($suiteOrTest)) {
				$childResults = $suiteOrTest->run(array_merge($suiteOrTest->tests(), $suiteOrTest->children()));
				$results['children'][] = $childResults;

				// Iterate counters
				foreach (array('failed', 'passed', 'skipped') as $key) {
					$results[$key] = $results[$key] + $childResults[$key];
					$results['duration'] += $childResults['duration'];
				}

			// Test method
			} else if (is_string($suiteOrTest)) {
				$testResult = $this->runTest($suiteOrTest);
				$results['tests'][] = $testResult;

				// Iterate counters
				$results[$testResult['status']]++;
				$results['duration'] += $testResult['duration'];

			}

		}

		// Clean-up after suite has run everything (exceptions are left uncaught)
		$this->_runAfterTests();

		return $results;
	}

}

?>