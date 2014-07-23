<?php

class Unitest {

	/**
	* Falsey
	*/
	final public function shouldNot ($value) {
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			if ($argument) {
				return $this->fail();
			}
		}
		return $this->pass();
	}

}

?>