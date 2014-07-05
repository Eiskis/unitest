<?php

class UnitestMath extends Unitest {

	function testMinus () {
		return $this->shouldBeEqual(0, 1-1, 2-2, 3-3);
	}

	function testPlus () {
		return $this->should(1 + 1=== 2);
	}

}

?>