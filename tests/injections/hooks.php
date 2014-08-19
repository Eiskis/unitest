<?php

class UnitestInjectionsHooks extends Unitest {

	function init () {
		$this->inject('foo', 1)->inject('bar', 2)->inject('string', 'Some string value');
	}



	function beforeTests ($foo) {
		return $foo;
	}

	function beforeTest ($foo) {
		return $foo;
	}

	function afterTest ($foo) {
		return $foo;
	}

	function afterTests ($foo) {
		return $foo;
	}



	function testPlaceholder ($foo) {
		return $this->should($foo);
	}

	function testPlaceholder2 ($bar) {
		return $this->should($bar);
	}

}

?>