<?php

class UnitestShouldBeFile extends Unitest {

	function testShouldBeFileRelative () {
		return $this->shouldBeFile('index.php');
	}

	function testShouldBeFileThis () {
		return $this->shouldBeFile(__FILE__);
	}

	function testShouldBeFileThisDir () {
		return $this->shouldBeFile(__DIR__.'/shouldBeFile.php');
	}

	function testShouldBeDirectoryRelative () {
		return $this->shouldBeDirectory('./');
	}

	function testShouldBeDirectoryThis () {
		return $this->shouldBeDirectory(__DIR__);
	}

	function testShouldNotBeFileOrDirectory () {
		return $this->shouldNotBeFileOrDirectory(__FILE__.'__');
	}



	function testShouldBeFileFailsOnDirectory () {
		return $this->fails($this->shouldBeFile(__DIR__));
	}

	function testShouldBeDirectoryFailsOnFile () {
		return $this->fails($this->shouldBeDirectory(__FILE__));
	}

	function testShouldNotBeFileOrDirectoryFailsOnFile () {
		return $this->fails($this->shouldNotBeFileOrDirectory(__FILE__));
	}

}

?>