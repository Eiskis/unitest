<?php

class Unitest {

	/**
	* A file should exist in given location(s)
	*/
	final protected function shouldBeFile ($path) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if (!is_file($argument)) {
				return $this->fail();
			}
		}
		return $this->pass();
	}

}

?>