<?php

class TesterSuite {

	/**
	* Properties
	*/
	protected $propertyCases = array();



	/**
	* Case listing
	*/
	public function cases () {
		return $this->propertyCases;
	}
	public function casesCount () {
		return count($this->cases());
	}

	/**
	* Case listing filtered by property value
	*/
	public function filteredCases ($property) {
		$filtered = array();
		foreach ($this->cases() as $case) {
			if (method_exists($case, $property)) {

				// Get value
				$caseValue = call_user_func(array($case, $property));

				// Compare truey
				if (func_num_args() <= 1) {
					if ($caseValue) {
						$filtered[] = $case;
					}

				// Specific target value
				} else {
					if ($caseValue === func_get_arg(1)) {
						$filtered[] = $case;
					}
				}

			}
		}
		return $filtered;
	}

	/**
	* Those cases out of all cases that have failed
	*/
	public function failedCases () {
		return $this->filteredCases('failed');
	}
	public function failedCasesCount () {
		return count($this->failedCases());
	}

	/**
	* Those cases out of all cases that have passed
	*/
	public function passedCases () {
		return $this->filteredCases('passed');
	}
	public function passedCasesCount () {
		return count($this->passedCases());
	}

}

?>