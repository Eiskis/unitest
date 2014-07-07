<?php

class UnitestExtender extends Unitest {

	protected function ownClass () {
		return get_class($this);
	}

	protected function fooBar () {
		return 'foo bar';
	}

	function testFoobar () {
		return $this->should($this->fooBar() === 'foo bar');
	}

}

?>