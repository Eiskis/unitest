<?php

class UnitestShouldBeOfOrExtendClass extends Unitest {

	function testThisIsThis () {
		return $this->shouldBeOfClass($this, 'UnitestShouldBeOfOrExtendClass');
	}

	function testThisExtendsUnitest () {
		return $this->shouldExtendClass($this, 'Unitest');
	}

}

?>