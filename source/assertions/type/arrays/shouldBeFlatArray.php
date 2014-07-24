<?php

class Unitest {

	/**
	* Array value(s) should not contain subarrays
	*/
	final protected function shouldBeFlatArray ($value) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if (!is_array($argument)) {
				return $this->fail();
			} else {

				// Fail if child array key found
				foreach ($argument as $child) {
					if (is_array($child)) {
						return $this->fail();
					}
				}

			}
		}
		return $this->pass();
	}

}

?>