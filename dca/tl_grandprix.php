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
 * Table tl_grandprix
 */
$GLOBALS['TL_DCA']['tl_grandprix'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'                 => 'Table',
		'ctable'                        => array('tl_grandprix_tournaments'),
		'enableVersioning'              => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' 				=> 'primary',
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('saison'),
			'panelLayout'             => 'filter,sort;search,limit',
			'flag'                    => 12,
			'disableGrouping'         => true,
		),
		'label' => array
		(
			'fields'                  => array('id', 'saison', 'title'),
			'showColumns'             => true,
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_grandprix']['edit'],
				'href'                => 'table=tl_grandprix_tournaments',
				'icon'                => 'edit.gif',
			),
			'editheader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_grandprix']['editheader'],
				'href'                => 'act=edit',
				'icon'                => 'header.gif',
			),  
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_grandprix']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_grandprix']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_grandprix']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_grandprix', 'toggleIcon')
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_grandprix']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Select
	'select' => array
	(
		'buttons_callback' => array()
	),

	// Edit
	'edit' => array
	(
		'buttons_callback' => array()
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(''),
		'default'                     => '{title_legend},title,saison;{options_legend},rating,viewnull;{rating_legend},max,better_points,higher_tourns;{winner_legend},name,points;{publish_legend},published'
	),

	// Subpalettes
	'subpalettes' => array
	(
		''                            => ''
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_grandprix']['id'],
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_grandprix']['title'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'filter'                  => true,
			'search'                  => true,
			'eval'                    => array
			(
				'mandatory'           => true, 
				'tl_class'            => 'w50',
				'maxlength'           => 255
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'saison' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_grandprix']['saison'],
			'exclude'                 => true,
			'filter'                  => true,
			'search'                  => true,
			'inputType'               => 'text',
			'flag'                    => 12,
			'eval'                    => array
			(
				'mandatory'           => true, 
				'tl_class'            => 'w50',
				'maxlength'           => 64
			),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'rating' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_grandprix']['rating'],
			'exclude'                 => true,
			'filter'                  => true,
			'default'                 => '20,17,15,14,13,12,11,10,9,8,7,6,5,4,3,2,1',
			'search'                  => true,
			'inputType'               => 'text',
			'flag'                    => 12,
			'eval'                    => array
			(
				'mandatory'           => true, 
				'tl_class'            => 'long',
				'maxlength'           => 255
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'viewnull' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_grandprix']['viewnull'],
			'exclude'                 => true,
			'search'                  => false,
			'sorting'                 => false,
			'default'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array
			(
				'tl_class'            => 'w50',
				'isBoolean'           => true
			),
			'sql'                     => "char(1) NOT NULL default ''"
		), 
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_grandprix']['name'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'filter'                  => true,
			'search'                  => true,
			'eval'                    => array
			(
				'mandatory'           => false, 
				'tl_class'            => 'w50',
				'maxlength'           => 255
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'points' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_grandprix']['points'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'default'                 => 20,
			'filter'                  => true,
			'search'                  => true,
			'eval'                    => array
			(
				'mandatory'           => false, 
				'tl_class'            => 'w50',
				'maxlength'           => 3
			),
			'sql'                     => "int(3) unsigned NOT NULL default '0'"
		),
		'max' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_grandprix']['max'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'default'                 => 5,
			'filter'                  => true,
			'search'                  => true,
			'eval'                    => array
			(
				'mandatory'           => false, 
				'tl_class'            => 'w50',
				'maxlength'           => 1
			),
			'sql'                     => "int(1) unsigned NOT NULL default '0'"
		),
		'better_points' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_grandprix']['better_points'],
			'exclude'                 => true,
			'search'                  => false,
			'sorting'                 => false,
			'default'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array
			(
				'tl_class'            => 'w50 clr',
				'isBoolean'           => true
			),
			'sql'                     => "char(1) NOT NULL default ''"
		), 
		'higher_tourns' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_grandprix']['higher_tourns'],
			'exclude'                 => true,
			'search'                  => false,
			'sorting'                 => false,
			'default'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array
			(
				'tl_class'            => 'w50',
				'isBoolean'           => true
			),
			'sql'                     => "char(1) NOT NULL default ''"
		), 
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_grandprix']['published'],
			'exclude'                 => true,
			'search'                  => false,
			'sorting'                 => false,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class' => 'w50','isBoolean' => true),
			'sql'                     => "char(1) NOT NULL default ''"
		), 
	)
);


/**
 * Class tl_grandprix
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2005-2014
 * @author     Leo Feyer <https://contao.org>
 * @package    News
 */
class tl_grandprix extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}

	
	/**
	 * Ändert das Aussehen des Toggle-Buttons.
	 * @param $row
	 * @param $href
	 * @param $label
	 * @param $title
	 * @param $icon
	 * @param $attributes
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		$this->import('BackendUser', 'User');
		
		if (strlen($this->Input->get('tid')))
		{
			$this->toggleVisibility($this->Input->get('tid'), ($this->Input->get('state') == 0));
			$this->redirect($this->getReferer());
		}
		
		// Check permissions AFTER checking the tid, so hacking attempts are logged
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_grandprix::published', 'alexf'))
		{
			return '';
		}
		
		$href .= '&amp;id='.$this->Input->get('id').'&amp;tid='.$row['id'].'&amp;state='.$row[''];
		
		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}
		
		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}

	/**
	 * Toggle the visibility of an element
	 * @param integer
	 * @param boolean
	 */
	public function toggleVisibility($intId, $blnPublished)
	{
		// Check permissions to publish
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_grandprix::published', 'alexf'))
		{
			$this->log('Not enough permissions to show/hide record ID "'.$intId.'"', 'tl_grandprix toggleVisibility', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}
		
		$this->createInitialVersion('tl_grandprix', $intId);
		
		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_grandprix']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_grandprix']['fields']['published']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnPublished = $this->$callback[0]->$callback[1]($blnPublished, $this);
			}
		}
		
		// Update the database
		$this->Database->prepare("UPDATE tl_grandprix SET tstamp=". time() .", published='" . ($blnPublished ? '' : '1') . "' WHERE id=?")
		               ->execute($intId);
		$this->createNewVersion('tl_grandprix', $intId);
	}

}
