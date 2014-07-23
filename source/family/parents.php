<?php

class Unitest {

	/**
	* All parents
	*/
	final public function parents () {
		$parents = array();
		if ($this->parent()) {
			$parents = array_merge($this->parent()->parents(), array($this->parent()->name()));
		}
		return $parents;
	}

}

?>