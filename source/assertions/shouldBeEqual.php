<?php

class Unitest {

	/**
	* Equality
	*/
	final protected function shouldBeEqual ($value) {
		$arguments = func_get_args();
		$count = count($arguments);
		if ($count > 1) {
			for ($i = 1; $i < $count; $i++) { 
				if ($arguments[$i-1] !== $arguments[$i]) {
					return $this->fail();
				}
			}
		}
		return $this->pass();
	}

}

?>