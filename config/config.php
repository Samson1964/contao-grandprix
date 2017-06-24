<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @package   Elo
 * @author    Frank Hoppe
 * @license   GNU/LPGL
 * @copyright Frank Hoppe 2016
 */


/**
 * BACK END MODULES
 *
 * Back end modules are stored in a global array called "BE_MOD". You can add
 * your own modules by adding them to the array.
 *
 * Not all of the keys mentioned above (like "tables", "key", "callback" etc.)
 * have to be set. Take a look at the system/modules/core/config/config.php
 * file to see how back end modules are configured.
 */

/**
 * Backend-Bereich BSV anlegen, wenn noch nicht vorhanden
 */
if(!$GLOBALS['BE_MOD']['bsv']) 
{
	$bsv = array(
		'bsv' => array()
	);
	array_insert($GLOBALS['BE_MOD'], 0, $bsv);
}

$GLOBALS['BE_MOD']['bsv']['grandprix'] = array
(
   'tables'       	=> array('tl_grandprix', 'tl_grandprix_tournaments'),
   'icon'         	=> 'system/modules/grandprix/assets/icons/icon.png',
);


/**
 * -------------------------------------------------------------------------
 * CONTENT ELEMENTS
 * -------------------------------------------------------------------------
 */
$GLOBALS['TL_CTE']['schach']['grandprix'] = 'GrandPrix';

/**
 * FRONT END MODULES

$GLOBALS['FE_MOD']['elo'] = array
(
	'elo_toplist' => 'Samson\Elo\Elo',
);  
 */

