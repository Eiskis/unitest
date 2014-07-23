<?php

class Unitest {

	/**
	* File(s) should have been included in current PHP script.
	*/
	final protected function shouldBeIncludedFile ($path) {
		$arguments = func_get_args();
		$arguments = $this->_flattenArray($arguments);
		$loadedFiles = get_included_files();

		foreach ($arguments as $argument) {
			if (!is_string($argument) or !in_array(realpath($argument), $loadedFiles)) {
				return $this->fail();
			}
		}

		return $this->pass();
	}

}

?>