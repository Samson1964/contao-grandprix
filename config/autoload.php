<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Samson',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Samson\GrandPrix' => 'system/modules/grandprix/elements/GrandPrix.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'ce_grandprix' => 'system/modules/grandprix/templates',
));
