<?php

class UnitestSkip extends Unitest {

	function testSkipsWhenNotReturningAnything () {
	}

	function testSkipsWhenHardcodingNull () {
		return null;
	}

}

?>