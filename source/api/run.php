<?php

class Unitest {

	/**
	* Run tests, some or all
	*/
	final public function run () {
		$arguments = func_get_args();

		$ref = new ReflectionClass($this);

		$results = array(
			'class'    => $this->_className($this),
			'file'     => $this->_classFile($this),
			'line'     => $this->_classLineNumber($this),
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
		$suitesOrTests = $this->_flattenArray($arguments);

		// Preparation before suite runs anything (possible exceptions are left uncaught)
		$this->_runHook('beforeTests');

		// Run tests
		foreach ($suitesOrTests as $suiteOrTest) {

			// Child suite
			if ($this->_isValidSuite($suiteOrTest)) {
				$childResults = $suiteOrTest->run(array_merge($suiteOrTest->tests(), $suiteOrTest->children()));
				$results['children'][] = $childResults;

				// Iterate counters
				foreach (array('failed', 'passed', 'skipped') as $key) {
					$results[$key] = $results[$key] + $childResults[$key];
					$results['duration'] += $childResults['duration'];
				}

			// Test method
			} else if (is_string($suiteOrTest)) {
				$testResult = $this->test($suiteOrTest);
				$results['tests'][] = $testResult;

				// Iterate counters
				$results[$testResult['status']]++;
				$results['duration'] += $testResult['duration'];

			}

		}

		// Clean-up after suite has run everything (exceptions are left uncaught)
		$this->_runHook('afterTests');

		return $results;
	}

}

?>