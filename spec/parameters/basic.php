<?php

class UnitestParametersBasic extends Unitest {

	function testOneParameter ($foo) {
		$arguments = func_get_args();
		return $this->should(count($arguments) === 1);
	}

	function testTwoParameters ($foo, $bar) {
		$arguments = func_get_args();
		return $this->should(count($arguments) === 2);
	}

	function testRightParameter ($string) {
		return $this->should(isset($string) and is_string($string));
	}

	function testUnavailableParameter ($someKey) {
		return $this->should(isset($someKey));
	}

}

?>