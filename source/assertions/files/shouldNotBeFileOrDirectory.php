<?php

class Unitest {

	/**
	* A file or directory should NOT exist in given location(s)
	*/
	final protected function shouldNotBeFileOrDirectory ($path) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if (is_file($argument) or is_dir($argument)) {
				return $this->fail();
			}
		}
		return $this->pass();
	}

}

?>