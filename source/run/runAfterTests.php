<?php

class Unitest {

	/**
	* When a suite has run tests
	*/
	final private function _runAfterTests () {
		$injections = array();
		$method = 'afterTests';

		if (method_exists($this, $method)) {

			// Get innjections to pass to hook method
			foreach ($this->_methodParameterNames($this, $method) as $parameterName) {
				$injections[] = $this->injection($parameterName);
			}

			$this->_execute($method, $injections);

		}

		return $this;
	}

}

?>