<?php

class Unitest {

	/**
	* Value's type should be array.
	*/
	final protected function shouldBeArray ($value) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if (!is_array($argument)) {
				return $this->fail();
			}
		}
		return $this->pass();
	}

}

?>