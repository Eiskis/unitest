<?php

class Unitest {

	/**
	* Values available for test methods
	*/
	final public function injections () {

		// Set
		$arguments = func_get_args();
		if (!empty($arguments)) {
			return $this->_execute('inject', $arguments);
		}

		// Get own injections, bubble
		$results = array();
		if ($this->parent()) {
			$results = array_merge($results, $this->parent()->injections());
		}
		$results = array_merge($results, $this->_propertyInjections);	


		return $results;
	}

}

?>