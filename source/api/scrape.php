<?php

class Unitest {

	/**
	* Initialize suites in locations
	*/
	final public function scrape () {
		$arguments = func_get_args();

		// Load classes automatically (arguments passed to loadFiles)
		$classes = $this->_execute('_loadFiles', $arguments);

		// Treat classes
		foreach ($classes as $key => $values) {
			$classes[$key] = $this->_generateClassMap($values);
		}
		$classes = $this->_mergeClassMap($classes);

		if (!empty($classes)) {
			$parents = array_reverse(class_parents($this));
			$parents[] = $this->_className($this);

			// Find own class from class map, only generate child suites from own child classes
			foreach ($parents as $parent) {
				if (isset($classes[$parent])) {
					$classes = $classes[$parent];
				} else {
					break;
				}
			}

			// We generate a map of required test suite classes here
			$suites = $this->_generateSuites($classes);

		}

		return $this;
	}

}

?>