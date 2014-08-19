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
	private $_assertionMethodPrefix = 'should';



	/**
	* Initialization
	*/
	final public function __construct () {
		$this->_runHook('init');
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