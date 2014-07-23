<?php

class Unitest {

	/**
	* Find out which classes will be defined in a script
	*/
	final private function _classesInScript ($code = '') {
		$classes = array();

		// Find tokens that are classes
		$tokens = token_get_all($code);
		for ($i = 2; $i < count($tokens); $i++) {

			// Assess tokens to find class declarations of subclasses
			if (
				$tokens[$i-2][0] === T_CLASS and
				$tokens[$i-1][0] === T_WHITESPACE and
				$tokens[$i][0]   === T_STRING and
				$tokens[$i+1][0] === T_WHITESPACE and
				$tokens[$i+2][0] === T_EXTENDS and
				$tokens[$i+3][0] === T_WHITESPACE and
				$tokens[$i+4][0] === T_STRING
			) {
				$inheritedFrom = $tokens[$i+4][1];

				// See if class extends Unitest
				if ($this->_isValidSuiteClass($inheritedFrom)) {
					$classes[] = $tokens[$i][1];
				}

			}
		}

		return $classes;
	}

}

?>