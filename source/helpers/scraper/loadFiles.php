<?php

class Unitest {

	/**
	* Find test suites in locations
	*/
	final private function _loadFiles () {
		$suites = array();
		$paths = func_get_args();
		$paths = $this->_flattenArray($paths);

		foreach ($paths as $path) {

			// Path given
			if (is_string($path)) {

				// File
				if (is_file($path)) {
					$suites = array_merge($suites, $this->_loadFile($path));

				// Directory: scrape recursively for all files
				} else if (is_dir($path)) {
					$suites = array_merge($suites, $this->_execute('_loadFiles', $this->_rglobFiles($path)));
				}

			}

		}

		return $suites;
	}

}

?>