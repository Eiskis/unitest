<?php

class Unitest {

	/**
	* Value's type should be null
	*/
	final protected function shouldBeNull ($value) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if (!is_null($argument)) {
				return $this->fail();
			}
		}
		return $this->pass();
	}

}

?>