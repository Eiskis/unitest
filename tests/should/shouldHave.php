<?php

class UnitestShouldHave extends Unitest {

	private $propertyFoo = 'foo';
	private function foo () { return 'foo'; }

	protected $propertyBar = 'bar';
	protected function bar () { return 'bar'; }

	public $propertyBlah = 'blah';
	public function blah () { return 'blah'; }



	function testThisShouldHaveMethod () {
		return $this->shouldHaveMethod($this, 'foo', 'bar', 'blah');
	}

	function testThisShouldHavePrivateMethod () {
		return $this->shouldHavePrivateMethod($this, 'foo');
	}

	function testThisShouldHaveProtectedMethod () {
		return $this->shouldHaveProtectedMethod($this, 'bar');
	}

	function testThisShouldHavePublicMethod () {
		return $this->shouldHavePublicMethod($this, 'blah');
	}



	function testThisShouldHaveProperty () {
		return $this->shouldHaveProperty($this, 'propertyFoo', 'propertyBar', 'propertyBlah');
	}

	// function testThisShouldHavePrivateProperty () {
	// 	return $this->shouldHavePrivateProperty($this, 'propertyFoo');
	// }

	// function testThisShouldHaveProtectedProperty () {
	// 	return $this->shouldHaveProtectedProperty($this, 'propertyBar');
	// }

	// function testThisShouldHavePublicProperty () {
	// 	return $this->shouldHavePublicProperty($this, 'propertyBlah');
	// }



}

?>