<?php

class Unitest {

	/**
	* Include PHP tests in a file
	*/
	final private function _loadFile ($path) {
		$suites = array();

		if (is_file($path)) {

			// Look for any Unitest classes
			$classes = $this->_classesInScript(file_get_contents($path));

			// Include if found
			if (!empty($classes)) {
				include_once $path;
			}

			// Store class tree
			foreach ($classes as $class) {
				// $suite = new $class();
				$suites[] = array_merge(array_reverse(array_values(class_parents($class))), array($class));
			}

		}

		return $suites;
	}

}

?>