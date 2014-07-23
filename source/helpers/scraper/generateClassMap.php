<?php

class Unitest {

	/**
	* Go through a list of classes, merge parent classes
	*
	* INPUT
	*	 array('Unitest', 'Alpha', 'Bravo', 'Charlie')
	*
	* OUTPUT
	*	 array(
	*		'Unitest' => array(
	*			'Alpha' => array(
	*				'Bravo' => array(
	*					'Charlie' => array(
	*					),
	*				),
	*			),
	*		),
	*	 )
	*/
	final private function _generateClassMap ($classes) {
		$results = array();

		// Go deeper if there's any children
		if (is_array($classes) and !empty($classes)) {
			$children = $classes;
			$parent = array_shift($children);

			// Recursion for treating children
			$results[$parent] = $this->_generateClassMap($children);

		}

		return $results;
	}

}

?>