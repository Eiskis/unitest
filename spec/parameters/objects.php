<?php

class UnitestParametersObjects extends Unitest {

	function testOneParameter ($unitest) {
		$arguments = func_get_args();
		return $this->should(count($arguments) === 1);
	}

}

?>