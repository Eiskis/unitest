<?php

class Unitest {

	/**
	* A file or directory should exist in given location(s)
	*/
	final public function shouldBeFileOrDirectory ($path) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if (!is_file($argument) and !is_dir($argument)) {
				return $this->fail();
			}
		}
		return $this->pass();
	}

}

?>