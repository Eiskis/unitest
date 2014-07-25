<?php

// Temporary Unitest class should be loaded now
$refClass = new ReflectionClass('TempUnitest');

// Arbitrary aliases
$aliases = array(
	'shouldBeBool' => 'shouldBeBoolean',
	'shouldBeInt' => 'shouldBeInteger',
	'shouldBeDouble' => 'shouldBeFloat',
);

// Get assertion methods of TempUnitest, add snake_case versions to list of new aliases
foreach ($aliases as $aliasKey => $aliasValue) {
	$aliases[str_replace(' ', '_', from_camelcase($aliasKey))] = $aliasValue;
}
foreach ($refClass->getMethods() as $method) {
	if (substr($method->name, 0, strlen('should')) === 'should') {
		$snake = str_replace(' ', '_', from_camelcase($method->name));
		if ($snake !== $method->name) {
			$aliases[$snake] = $method->name;
		}
	}
}


// Generate source code
foreach ($aliases as $aliasName => $aliasTarget) {
	if (!method_exists('TempUnitest', $aliasTarget)) {
		throw new Exception('Source does not have a method "'.$aliasTarget.'" to create an alias for.');
	} else {

		// Get finality, visibility, staticity
		$refMethod = new ReflectionMethod('TempUnitest', $aliasTarget);
		$final = $refMethod->isFinal();
		$static = $refMethod->isStatic();
		$visibility = ($refMethod->isPrivate() ? 'private' : ($refMethod->isProtected() ? 'protected' : 'public'));

		// Parameters
		$parameters = array();
		foreach ($refMethod->getParameters() as $parameter) {
			if (!$parameter->isOptional()) {
				$parameters[] = '$'.$parameter->name;
			}
		}
		unset($parameter);

	}

	$aliasesOutput .= '
	'.($final ? 'final ' : '').' '.$visibility.' function '.$aliasName.' ('.implode(', ', $parameters).') {
		$arguments = func_get_args();
		return call_user_func_array(array($this, \''.$aliasTarget.'\'), $arguments);
	}
';
}

?>