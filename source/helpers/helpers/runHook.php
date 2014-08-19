<?php

class Unitest {

	/**
	* Run a suite's hook method, passing it injections
	*/
	final private function _runHook ($hookMethod) {
		$injections = array();

		if (method_exists($this, $hookMethod)) {

			// Get innjections to pass to hook method
			foreach ($this->_methodParameterNames($this, $hookMethod) as $parameterName) {
				$injections[] = $this->injection($parameterName);
			}

			$this->_execute($hookMethod, $injections);

		}

		return $this;
	}

}

?>