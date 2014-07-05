<?php

class UnitestSkip extends Unitest {

	function testSkipWhenNotReturningAnything () {
	}

	function testSkipsWhenHardcodingNull () {
		return null;
	}

}

?>