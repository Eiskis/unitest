<?php

class Unitest {

	/**
	* Flatten an array
	*/
	final private function flattenArray ($array) {
		$result = array();
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				$result = array_merge($result, $this->flattenArray($value));
			} else {
				$result[] = $value;
			}
		}
		return $result;
	}

}

?>