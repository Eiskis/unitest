<?php

class UnitestShouldBeEqual extends Unitest {

	function testZeroes () {
		return $this->shouldBeEqual(0, 1-1, 2-2);
	}

	function testOnes () {
		return $this->shouldBeEqual(1, 2-1, 3-2);
	}

}

?>