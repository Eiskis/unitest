<?php

class Unitest {

	/**
	* Add an injectable value that can be passed to functions as parameter
	*/
	final public function inject ($name, $value) {
		if (is_string($name)) {

			// Sanitize variable name
			$name = str_replace('-', '', preg_replace('/\s+/', '', $name));
			if (!empty($name)) {
				$this->propertyInjections[$name] = $value;
			}

		}
		return $this;
	}

}

?>