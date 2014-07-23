<?php

class Unitest {

	/**
	* Represent exception as string
	*/
	final private function _stringifyException ($e) {
		return ''.$e->getMessage().' ('.$e->getFile().' line '.$e->getLine().', error code '.$e->getCode().')';
	}

}

?>