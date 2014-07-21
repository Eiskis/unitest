<?php

class Unitest {

	/**
	* File where this class is defined in
	*/
	final public function file () {
		$ref = new ReflectionClass($this);
		return $ref->getFileName();
	}

}

?>