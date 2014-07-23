<?php

class Unitest {

	/**
	* Falsey
	*/
	final protected function shouldNot ($value) {
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