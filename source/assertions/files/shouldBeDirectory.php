<?php

class Unitest {

	/**
	* A directory should exist in given location(s)
	*/
	final protected function shouldBeDirectory ($path) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if (!is_dir($argument)) {
				return $this->fail();
			}
		}
		return $this->pass();
	}

}

?>