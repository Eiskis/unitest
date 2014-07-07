<?php

class UnitestExtenderFoo extends UnitestExtender {

	protected function barFoo () {
		return 'bar foo';
	}

	function testOwnHelper () {
		return $this->should($this->barFoo() === 'bar foo');
	}

	function testInheritedHelper () {
		return $this->should($this->ownClass() === 'UnitestExtenderFoo');
	}

	function testParentHelper () {
		return $this->should($this->fooBar() === 'foo bar');
	}

}

?>