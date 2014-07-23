<?php

class Unitest {

	/**
	* Initialize suites in locations
	*/
	final public function scrape () {
		$arguments = func_get_args();

		// Load classes automatically (arguments passed to loadFiles)
		$classes = $this->execute('loadFiles', $arguments);

		// Treat classes
		foreach ($classes as $key => $values) {
			$classes[$key] = $this->generateClassMap($values);
		}
		$classes = $this->mergeClassMap($classes);

		if (!empty($classes)) {
			$parents = array_reverse(class_parents($this));
			$parents[] = $this->className($this);

			// Find own class from class map, only generate child suites from own child classes
			foreach ($parents as $parent) {
				if (isset($classes[$parent])) {
					$classes = $classes[$parent];
				} else {
					break;
				}
			}

			// We generate a map of required test suite classes here
			$suites = $this->generateSuites($classes);

		}

		return $this;
	}

}

?>