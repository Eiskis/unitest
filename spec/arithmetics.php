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

}

?>