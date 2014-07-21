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



	/**
	* Successes
	*/

	function testThisShouldHaveProperty () {
		return $this->shouldHaveProperty($this, 'propertyFoo', 'propertyBar', 'propertyBlah');
	}

	function testThisShouldHavePrivateProperty () {
		return $this->shouldHavePrivateProperty($this, 'propertyFoo');
	}

	function testThisShouldHaveProtectedProperty () {
		return $this->shouldHaveProtectedProperty($this, 'propertyBar');
	}

	function testThisShouldHavePublicProperty () {
		return $this->shouldHavePublicProperty($this, 'propertyBlah');
	}



	/**
	* Fails
	*/

	function testThisShouldHavePrivatePropertyFailsOnPublic () {
		return $this->fails($this->shouldHavePrivateProperty($this, 'propertyBlah'));
	}

	function testThisShouldHaveProtectedPropertyFailsOnPublic () {
		return $this->fails($this->shouldHaveProtectedProperty($this, 'propertyBlah'));
	}

	function testThisShouldHavePrivatePropertyFailsOnProtected () {
		return $this->fails($this->shouldHavePrivateProperty($this, 'propertyBar'));
	}

	function testThisShouldHavePublicPropertyFailsOnProtected () {
		return $this->fails($this->shouldHavePublicProperty($this, 'propertyBar'));
	}

	function testThisShouldHaveProtectedPropertyFailsOnPrivate () {
		return $this->fails($this->shouldHaveProtectedProperty($this, 'propertyFoo'));
	}

	function testThisShouldHavePublicPropertyFailsOnPrivate () {
		return $this->fails($this->shouldHavePublicProperty($this, 'propertyFoo'));
	}



}

?>