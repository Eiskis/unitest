<?php

class Unitest {

	/**
	* Flatten an array
	*/
	final private function _flattenArray ($array) {
		$result = array();
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				$result = array_merge($result, $this->_flattenArray($value));
			} else {
				$result[] = $value;
			}
		}
		return $result;
	}

}

?>