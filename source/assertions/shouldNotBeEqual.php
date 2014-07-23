<?php

class Unitest {

	/**
	* Non-equality
	*/
	final protected function shouldNotBeEqual ($value) {
		$arguments = func_get_args();
		return !$this->execute('shouldBeEqual', $arguments);
	}

}

?>