<?php

class Unitest {

	/**
	* Array value's keys should be sequential and numerical.
	*/
	final protected function shouldHaveIndexedKeys ($value) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if (!is_array($argument)) {
				return $this->fail();
			} else {

				// Fail if incorrect key found
				$keys = array_keys($argument);
				for ($i = 0; $i < count($array); $i++) { 
					if ($keys[$i] !== $i) {
						return $this->fail();
					}
				}

			}
		}
		return $this->pass();
	}

}

?>