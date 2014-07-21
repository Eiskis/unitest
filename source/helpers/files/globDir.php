<?php

class Unitest {

	/**
	* Find directories
	*/
	final private function globDir ($path = '') {

		// Normalize path
		if (!empty($path)) {
			$path = preg_replace('/(\*|\?|\[)/', '[$1]', $path);
			if (substr($path, -1) !== '/') {
				$path .= '/';
			}
		}

		// Find directories in the path
		$directories = glob($path.'*', GLOB_MARK | GLOB_ONLYDIR);
		foreach ($directories as $key => $value) {
			$directories[$key] = str_replace('\\', '/', $value);
		}
		
		// Sort results
		usort($directories, 'strcasecmp');

		return $directories;
	}

}

?>