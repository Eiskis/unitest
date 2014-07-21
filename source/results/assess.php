<?php

class Unitest {

	/**
	* Assess a value like it was a test result
	*/
	final protected function assess ($value) {
		if ($this->passes($value)) {
			return 'passed';
		} else if ($this->skips($value)) {
			return 'skipped';
		}
		return 'failed';
	}

}

?>