<?php

spl_autoload_register(function ($class) {

	// project-specific namespace prefix
	$prefixes = array(
		'Sangoma\\SuiteCRM\\' => __DIR__ . '/src/',
	);

	// Fixed, known, classes
	$classes = array();

	// Have we been asked for a known one?
	if (isset($classes[$class])) {
		if (!file_exists($classes[$class])) {
			throw new \Exception("Known class $class does not exist at ".$classes[$class]);
		}
		require $classes[$class];
		return;
	}

	// Check if it's a prefix we know about
	foreach ($prefixes as $prefix => $basedir) {
		// does the class use the namespace prefix?
		$len = strlen($prefix);
		if (strncmp($prefix, $class, $len) === 0) {
			// get the relative class name
			$relative_class = substr($class, $len);

			// replace the namespace prefix with the base directory, replace namespace
			// separators with directory separators in the relative class name, append
			// with .php
			$file = $basedir . str_replace('\\', '/', $relative_class) . '.php';

			// if the file exists, require it
			if (!file_exists($file)) {
				throw new \Exception("Authoritative on $prefix, but $file doesn't exist");
			} else {
				require $file;
				break;
			}
		}
	}
});
