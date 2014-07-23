<?php

class Unitest {

	/**
	* Truey
	*/
	final public function should ($value) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if (!$argument) {
				return $this->fail();
			}
		}
		return $this->pass();
	}

}

?>