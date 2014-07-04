<?php

/**
* Some tests just for debugging
*/
class UnitestFails extends Unitest {

	public function testThatFailsWithException () {
		$foo = array(1, 2);
		return $this->assert(strlen($foo) === 2);
	}

}

?>