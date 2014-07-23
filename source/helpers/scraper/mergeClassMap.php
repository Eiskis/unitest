<?php

class Unitest {

	/**
	* Go through a list of classes, merge parent classes
	*
	* INPUT
	*	 array(
	*		 array(
	*			'Unitest' => array(
	*				'Alpha' => array(
	*					'Bravo' => array(
	*						'Charlie' => array(
	*						),
	*					),
	*				),
	*			),
	*		 ),
	*		 array(
	*			'Unitest' => array(
	*				'Alpha' => array(
	*					'Uniform' => array(
	*					),
	*				),
	*			),
	*		 ),
	*	 )
	*
	* OUTPUT
	*	 array(
	*		'Unitest' => array(
	*			'Alpha' => array(
	*				'Bravo' => array(
	*					'Charlie' => array(),
	*				),
	*				'Uniform' => array(),
	*			),
	*		),
	*	 )
	*/
	final private function _mergeClassMap ($classTrees) {
		$results = array();

		// Array of each
		if (!empty($classTrees)) {
			foreach ($classTrees as $classTree) {
				foreach ($classTree as $name => $children) {

					// New set
					if (!isset($results[$name])) {
						$results[$name] = array();
					}

					// Collect all children here
					$results[$name][] = $children;

				}
			}

			// Organize children
			foreach ($results as $key => $value) {
				if (empty($value)) {
					$results[$key] = array();
				} else if (count($value) === 1) {
					$results[$key] = $value[0];
				} else {
					$results[$key] = $this->_mergeClassMap($value);
				}
			}

		}

		// Sort by key
		ksort($results);

		return $results;
	}

}

?>