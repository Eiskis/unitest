<?php

/**
* Some tests just for debugging
*/
class UnitestVars extends Unitest {

	public function testOneVar ($foo) {
		$arguments = func_get_args();
		return $this->should(count($arguments) === 1);
	}

	public function testTwoVars ($foo, $bar) {
		$arguments = func_get_args();
		return $this->should(count($arguments) === 2);
	}

	public function testRightVar ($string) {
		return $this->should(isset($string) and is_string($string));
	}

	public function testUnavailableVar ($someKey) {
		return $this->should(isset($someKey));
	}

}

?>