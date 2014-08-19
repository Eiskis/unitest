<?php

class Unitest {

	/**
	* When a suite is about to run
	*/
	final private function _runBeforeTests () {
		$method = 'beforeTests';
		$injections = array();

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