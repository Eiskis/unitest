<?php

/**
* Some tests just for debugging
*/
class UnitestArithmetics extends Unitest {

	public function testMinus () {
		return $this->assert(1 - 1 === 0);
	}

	public function testPlus () {
		return $this->assert(1 + 1=== 2);
	}

	public function testThatFails () {
		return $this->assert(1 + 2 === 2);
	}

	public function testThatFailsWithException () {
		$foo = array(1, 2);
		return $this->assert(strlen($foo) === 2);
	}

}

?>