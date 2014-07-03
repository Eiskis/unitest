<?php
class TestOfTester extends UnitTestCase {

	function testFalse () {
		$this->assertFalse(false);
	}

	function testTrue () {
		$this->assertFalse(true);
	}

	function testEmptyString () {
		$this->assertFalse('');
	}

	function testWhitespaceString () {
		$this->assertTrue(' ');
	}

	function testNonEmptyString () {
		$this->assertTrue('Foo');
	}

}
?>