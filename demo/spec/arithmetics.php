<?php

/**
* Some tests just for debugging
*/
class UnitestArithmetics extends Unitest {

	public function testMinus () {
		return $this->shouldBeEqual(0, 1-1, 2-2, 3-3);
	}

	public function testPlus () {
		return $this->should(1 + 1=== 2);
	}

}

?>