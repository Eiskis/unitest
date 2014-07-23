<?php

class Unitest {

	/**
	* Find files recursively
	*/
	final private function _rglobFiles ($path = '', $filetypes = array()) {

		// Accept file type restrictions as a single array or multiple independent values
		$arguments = func_get_args();
		array_shift($arguments);
		$filetypes = $this->_flattenArray($arguments);

		// Run glob_files for this directory and its subdirectories
		$files = $this->_globFiles($path, $filetypes);
		foreach ($this->_globDir($path) as $child) {
			$files = array_merge($files, $this->_rglobFiles($child, $filetypes));
		}

		return $files;
	}

}

?>