<?php

class Unitest {

	/**
	* Class exists
	*/
	final public function shouldBeAvailableClass ($value) {
		if (!class_exists($value)) {
			$this->fail();
		}
		return $this->pass();
	}

}

?>