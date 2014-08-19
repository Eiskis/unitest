<?php

class Unitest {

	/**
	* When instance is created
	*/
	final private function _runInit () {
		$method = 'init';
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