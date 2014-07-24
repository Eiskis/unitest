<?php

class Unitest {

	/**
	* Array value's keys should be strings.
	*/
	final protected function shouldHaveStringKeys ($value) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if (!is_array($argument)) {
				return $this->fail();
			} else {

				// Fail if incorrect key found
				foreach (array_keys($argument) as $key) {
					if (!is_string($key)) {
						return $this->fail();
					}
				}

			}
		}
		return $this->pass();
	}

}

?>