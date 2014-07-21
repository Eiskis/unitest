<?php

class Unitest {

	/**
	* Find test suites in locations
	*/
	final private function loadFiles () {
		$suites = array();
		$paths = func_get_args();
		$paths = $this->flattenArray($paths);

		foreach ($paths as $path) {

			// Path given
			if (is_string($path)) {

				// File
				if (is_file($path)) {
					$suites = array_merge($suites, $this->loadFile($path));

				// Directory: scrape recursively for all files
				} else if (is_dir($path)) {
					$suites = array_merge($suites, $this->execute('loadFiles', $this->rglobFiles($path)));
				}

			}

		}

		return $suites;
	}

}

?>