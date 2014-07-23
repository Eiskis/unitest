<?php

class Unitest {



	/**
	* Properties
	*/
	private $_propertyChildren = array();
	private $_propertyInjections = array();
	private $_propertyParent = null;

	private $_baseClass = 'Unitest';
	private $_testMethodPrefix = 'test';



	/**
	* Initialization
	*
	* Parent suite and script variables can be passed
	*/
	final public function __construct () {
		$this->_runInit();
		return $this;
	}



	/**
	* String conversion
	*/
	final public function __toString () {
		return get_class($this);
	}

}

?>