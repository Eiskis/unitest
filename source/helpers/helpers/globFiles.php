<?php

class Unitest {

	/**
	* Find files
	*/
	final private function _globFiles ($path = '', $filetypes = array()) {
		$files = array();

		// Handle filetype input
		if (empty($filetypes)) {
			$brace = '';
		} else {
			$brace = '.{'.implode(',', $filetypes).'}';
		}

		// Handle path input
		if (!empty($path)) {
			$path = preg_replace('/(\*|\?|\[)/', '[$1]', $path);
			if (substr($path, -1) !== '/') {
				$path .= '/';
			}
		}

		// Do the glob()
		foreach (glob($path.'*'.$brace, GLOB_BRACE) as $value) {
			if (is_file($value)) {
				$files[] = $value;
			}
		}

		// Sort results
		usort($files, 'strcasecmp');

		return $files;
	}

}

?>