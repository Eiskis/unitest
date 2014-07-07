<?php

class UnitestShouldExtendClass extends Unitest {

	function testThisExtendsUnitest () {
		return $this->shouldExtendClass('Unitest', $this);
	}

}

?>