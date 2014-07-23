<?php

class Unitest {

	/**
	* Parent suite
	*/
	final public function parent ($parent = null, $parentKnows = false) {

		// Set
		if (isset($parent)) {

			// Validate parent
			if (!$this->_isValidSuite($parent)) {
				throw new Exception('Invalid parent suite passed as parent.');
			} else {

				// Parent case adds this to its flock if needed
				if (!$parentKnows) {
					$parent->child($this);
				}

				// This stores a reference to its dad
				$this->_propertyParent = $parent;

			}

			return $this;
		}

		// Get
		return $this->_propertyParent;
	}

}

?>