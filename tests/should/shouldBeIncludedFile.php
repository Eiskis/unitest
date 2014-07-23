<?php

class UnitestShouldBeIncludedFile extends Unitest {

	function testShouldBeBeIncludedFileThis () {
		return $this->shouldBeIncludedFile(__FILE__);
	}

	function testShouldBeBeIncludedFileThisDir () {
		return $this->shouldBeIncludedFile(__DIR__.'/shouldBeIncludedFile.php');
	}

	function testShouldBeIncludedFileRelative () {
		return $this->shouldBeIncludedFile('index.php');
	}

	function testShouldBeIncludedFileDirectoryRelative () {
		return $this->shouldBeIncludedFile('./index.php');
	}



	/**
	* Test runner should not include these
	*/

	function testShouldBeIncludedFileFailsOnRelative () {
		return $this->fails($this->shouldBeIncludedFile('todo.md'));
	}

}

?>