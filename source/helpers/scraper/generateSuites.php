<?php

class Unitest {

	/**
	* Instantiate suite objects based on class names recursively
	*/
	final private function _generateSuites ($classes, $parent = null) {
		$suites = array();

		// Default to self
		if (!isset($parent)) {
			$parent = $this;
		}

		// Validate parent
		if (!$this->_isValidSuite($parent)) {
			throw new Exception('Invalid parent suite passed as parent.');
		}

		foreach ($classes as $class => $children) {
			$suite = new $class();

			// Recursion
			if (!empty($children)) {
				$this->_generateSuites($children, $suite);
			}

			// Add to own flock
			$parent->child($suite);

		}
		return $this;
	}

}

?>