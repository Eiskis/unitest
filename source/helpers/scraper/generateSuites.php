<?php

class Unitest {

	/**
	* Instantiate suite objects based on class names recursively
	*/
	final private function generateSuites ($classes, $parent = null) {
		$suites = array();

		// Default to self
		if (!isset($parent)) {
			$parent = $this;
		}

		// Validate parent
		if (!$this->isValidSuite($parent)) {
			throw new Exception('Invalid parent suite passed as parent.');
		}

		foreach ($classes as $class => $children) {
			$suite = new $class();

			// Recursion
			if (!empty($children)) {
				$this->generateSuites($children, $suite);
			}

			// Add to own flock
			$parent->child($suite);

		}
		return $this;
	}

}

?>