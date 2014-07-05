<?php

class UnitestAssessments extends Unitest {



	// Passes

	function testTruePasses () {
		return $this->should($this->passed(true));
	}



	// Not passes

	function testArrayDoesNotPass () {
		return $this->should(!$this->passed(array(1, 2, 3)));
	}

	function testEmptyArrayDoesNotPass () {
		return $this->should(!$this->passed(array()));
	}

	function testStringDoesNotPass () {
		return $this->should(!$this->passed('Foo bar'));
	}

	function testNullDoesNotPass () {
		return $this->should(!$this->passed(null));
	}



	// Fails

	function testFalseFails () {
		return $this->should($this->failed(false));
	}

	function testStringFails () {
		return $this->should($this->failed('Foo bar'));
	}

	function testArrayFails () {
		return $this->should($this->failed(array(1, 2, 3)));
	}

	function testEmptyArrayFails () {
		return $this->should($this->failed(array()));
	}



	// Not fails

	function testTrueDoesNotFail () {
		return $this->shouldNot($this->failed(true));
	}

	function testNullDoesNotFail () {
		return $this->shouldNot($this->failed(null));
	}

}

?>