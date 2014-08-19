<?php

class Unitest {

	/**
	* When a singe test has been run
	*/
	final private function _runAfterTest () {
		$method = 'afterTest';
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