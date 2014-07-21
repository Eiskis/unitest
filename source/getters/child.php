<?php

class Unitest {

	/**
	* Add a suite as a child of this suite
	*/
	final public function child ($child) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if ($this->isValidSuite($argument)) {

				// Store reference to this in the child
				$argument->parent($this, true);

				// Add to own flock
				$this->propertyChildren[] = $argument;

			}
		}
		return $this;
	}

}

?>