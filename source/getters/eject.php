<?php

class Unitest {

	/**
	* Remove an injectable value
	*/
	final public function eject ($name) {
		$arguments = func_get_args();
		$arguments = $this->flattenArray($arguments);
		foreach ($arguments as $argument) {
			if ($this->isInjection($argument)) {
				unset($this->_propertyInjections[$argument]);
			}
		}
		return $this;
	}

}

?>