<?php

class UnitestShouldHave extends Unitest {

	private $propertyFoo = true;
	private function methodFoo () { return true; }

	protected $propertyBar = true;
	protected function methodBar () { return true; }

	public $propertyBlah = true;
	public function methodBlah () { return true; }

	final public function methodFinal () { return true; }
	static public function methodStatic () { return true; }



	/**
	* Successful methods
	*/

	function testThisShouldHaveMethod () {
		return $this->shouldHaveMethod($this, 'methodFoo', 'methodBar', 'methodBlah');
	}

	function testThisShouldHavePrivateMethod () {
		return $this->shouldHavePrivateMethod($this, 'methodFoo');
	}

	function testThisShouldHaveProtectedMethod () {
		return $this->shouldHaveProtectedMethod($this, 'methodBar');
	}

	function testThisShouldHavePublicMethod () {
		return $this->shouldHavePublicMethod($this, 'methodBlah');
	}

	function testThisShouldHaveFinalMethod () {
		return $this->shouldHaveFinalMethod($this, 'methodFinal');
	}

	function testThisShouldHaveStaticMethod () {
		return $this->shouldHaveStaticMethod($this, 'methodStatic');
	}



	/**
	* Successful properties
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
	* Failing methods
	*/

	function testThisShouldHavePrivateMethodFailsOnPublic () {
		return $this->fails($this->shouldHavePrivateMethod($this, 'methodBlah'));
	}

	function testThisShouldHaveProtectedMethodFailsOnPublic () {
		return $this->fails($this->shouldHaveProtectedMethod($this, 'methodBlah'));
	}

	function testThisShouldHavePrivateMethodFailsOnProtected () {
		return $this->fails($this->shouldHavePrivateMethod($this, 'methodBar'));
	}

	function testThisShouldHavePublicMethodFailsOnProtected () {
		return $this->fails($this->shouldHavePublicMethod($this, 'methodBar'));
	}

	function testThisShouldHaveProtectedMethodFailsOnPrivate () {
		return $this->fails($this->shouldHaveProtectedMethod($this, 'methodFoo'));
	}

	function testThisShouldHavePublicMethodFailsOnPrivate () {
		return $this->fails($this->shouldHavePublicMethod($this, 'methodFoo'));
	}

	function testThisShouldHaveFinalMethodFailsOnNonFinal () {
		return $this->fails($this->shouldHaveFinalMethod($this, 'methodFoo'));
	}

	function testThisShouldHaveStaticMethodFailsOnNonStatic () {
		return $this->fails($this->shouldHaveStaticMethod($this, 'methodFoo'));
	}



	/**
	* Failing properties
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