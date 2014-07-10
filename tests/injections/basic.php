<?php

class UnitestInjectionsBasic extends Unitest {

	function init () {
		$this->inject('foo', 1)->inject('bar', 2)->inject('string', 'Some string value');
	}

	// FLAG injecting in test methods leaves injections for other injections
	function testLocalInjection () {
		$this->inject('testInjection', 3);
		return $this->should($this->injection('testInjection') === 3);
	}

	function testInjectionOfAnotherMethodIsNotAvailable () {
		try {
			$this->injection('testInjection');
			return $this->fail();
		} catch (Exception $e) {
			return $this->pass();
		}
	}

	function testOverWrittenLocalInjection () {
		$this->inject('anotherTestInjection', 1);
		$this->inject('anotherTestInjection', 2);
		return $this->should($this->injection('anotherTestInjection') === 2);
	}

	function testClassInitInjectionCount ($foo) {
		$arguments = func_get_args();
		return $this->should(count($arguments) === 1);
	}

	function testTwoSelfInjectionsCount ($foo, $bar) {
		$arguments = func_get_args();
		return $this->should(count($arguments) === 2);
	}

	function testClassInitInjectionValue ($foo) {
		return $this->should($foo === 1);
	}

	function testTwoSelfInjectionsValues ($foo, $bar) {
		return $this->should(($foo === 1), ($bar === 2));
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