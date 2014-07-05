<?php

class UnitestShould extends Unitest {

	function testPassesWithTrue () {
		return $this->should(true);
	}

	function testPassesWithOne () {
		return $this->should(1);
	}

	function testPassesWithString () {
		return $this->should('Foo');
	}

}

?>