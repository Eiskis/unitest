<?php

class UnitestAssessments extends Unitest {



	// Skips

	function testNullSkips () {
		return $this->should($this->skips(null));
	}

	function testTrueDoesNotSkip () {
		return $this->shouldNot($this->skips(true));
	}

	function testFalseDoesNotSkip () {
		return $this->shouldNot($this->skips(false));
	}

	function testStringDoesNotSkip () {
		return $this->shouldNot($this->skips('foo bar'));
	}



	// Passes

	function testTruePasses () {
		return $this->should($this->passes(true));
	}



	// Not passes

	function testArrayDoesNotPass () {
		return $this->shouldNot($this->passes(array(1, 2, 3)));
	}

	function testEmptyArrayDoesNotPass () {
		return $this->shouldNot($this->passes(array()));
	}

	function testStringDoesNotPass () {
		return $this->shouldNot($this->passes('Foo bar'));
	}

	function testNullDoesNotPass () {
		return $this->shouldNot($this->passes(null));
	}



	// Fails

	function testFalseFails () {
		return $this->should($this->fails(false));
	}

	function testStringFails () {
		return $this->should($this->fails('Foo bar'));
	}

	function testArrayFails () {
		return $this->should($this->fails(array(1, 2, 3)));
	}

	function testEmptyArrayFails () {
		return $this->should($this->fails(array()));
	}



	// Not fails

	function testTrueDoesNotFail () {
		return $this->shouldNot($this->fails(true));
	}

	function testNullDoesNotFail () {
		return $this->shouldNot($this->fails(null));
	}

}

?>