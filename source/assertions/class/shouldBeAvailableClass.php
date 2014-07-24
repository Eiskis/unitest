<?php

class Unitest {

	/**
	* Class exists
	*/
	final protected function shouldBeAvailableClass ($value) {
		if (!class_exists($value)) {
			$this->fail();
		}
		return $this->pass();
	}

}

?>