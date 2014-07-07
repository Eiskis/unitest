<?php

class UnitestExtenderBar extends UnitestExtender {

	protected function oneTwoThree () {
		return array(1, 2, 3);
	}

	function testOwnHelper () {
		return $this->should(count($this->oneTwoThree()) === 3);
	}

	function testInheritedHelper () {
		return $this->should($this->ownClass() === 'UnitestExtenderBar');
	}

	function testParentHelper () {
		return $this->should($this->fooBar() === 'foo bar');
	}

}

?>