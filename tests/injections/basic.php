<?php

class UnitestInjectionsBasic extends Unitest {

	function testOneInjection ($foo) {
		$arguments = func_get_args();
		return $this->should(count($arguments) === 1);
	}

	function testTwoInjections ($foo, $bar) {
		$arguments = func_get_args();
		return $this->should(count($arguments) === 2);
	}

	function testRightInjection ($string) {
		return $this->should(isset($string) and is_string($string));
	}

	function testUnavailableInjection () {
		try {
			$this->injection('someUnavailableKey');
			return $this->fail();
		} catch (Exception $e) {
			return $this->pass();
		}
	}

}

?>