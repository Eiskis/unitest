<?php

class Unitest {

	/**
	* Assess failure
	*/
	final protected function fails ($value) {
		return !($this->passes($value) or $this->skips($value));
	}

}

?>