<?php

class Unitest {

	/**
	* String conversion
	*/
	final public function __toString () {
		return get_class($this);
	}

}

?>