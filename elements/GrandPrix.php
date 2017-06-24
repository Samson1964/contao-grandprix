<?php 

namespace Samson;

if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * @package   chesstable
 * Version    1.0.0
 * @author    Frank Hoppe
 * @license   GNU/LGPL
 * @copyright Frank Hoppe 2013
 */

class GrandPrix extends \ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_grandprix';

	/**
	 * Generate the module
	 */
	protected function compile()
	{

		// Parameter zuweisen
		$gp = $this->grandprix_list;
		$tourncount = $this->grandprix_tourncount;

		// Infos zum gewünschten Grand Prix laden
		$objGrandPrix = \Database::getInstance()->prepare('SELECT * FROM tl_grandprix WHERE published = ? AND id = ?')
							   				    ->execute(1, $this->grandprix_list);		

		if($objGrandPrix->numRows == 1)
		{
			// Wertungspunkte festlegen und Array verschieben von 0-x nach 1-x
			$wertung = explode(',', $objGrandPrix->rating);
			array_unshift($wertung, false);

			// Grand Prix ist online, jetzt die Turniere laden
			$objTurniere = \Database::getInstance()->prepare('SELECT * FROM tl_grandprix_tournaments WHERE published = ? AND pid = ? ORDER BY date ASC')
												   ->limit($this->grandprix_tourncount)
												   ->execute(1, $this->grandprix_list);
			if($objTurniere->numRows > 0)
			{
				$arrGP = array(); // Array mit den Spielern/Wertungspunkten initialisieren
				$turnier = 0; // Zähler für Turniernummer
				// Bonuspunkte eintragen
				$arrGP[] = array
				(
					'name'         => trim($objGrandPrix->name),
					'bonus'        => $objGrandPrix->points,
					't1'           => false,
					't2'           => false,
					't3'           => false,
					't4'           => false,
					't5'           => false,
					't6'           => false,
					't7'           => false,
					't8'           => false,
					't9'           => false,
					't10'          => false,
					't11'          => false,
					't12'          => false,
					't13'          => false,
					't14'          => false,
					'punkte'       => 0,
					'anzahl'       => 0,
					'feinwertung1' => 0,
					'platz'        => 0,
				);
				
				// Turniere der Reihe nach auswerten
				while($objTurniere->next())
				{
					$turnier++;
					// CSV einlesen und übertragen
					$arrCSV = explode("\n", $objTurniere->csv);
					for($row = 0; $row < count($arrCSV); $row++)
					{
						$spalte = explode(";", $arrCSV[$row]); // Spalten trennen
						if($row == 0)
						{
							// Kopfspalte auswerten
							for($col = 0; $col < count($spalte); $col++)
							{
								switch(trim($spalte[$col]))
								{
									case 'Platz':
									case 'Pl.':
									case 'No.':
									case 'Nr.':
									case 'Br.':
										$colPlatz = $col;
										break;
									case 'Spieler':
									case 'Spielerin':
									case 'Name':
									case 'Teilnehmer':
									case 'Teilnehmerin':
									case 'Weiß':
									case 'Weiss':
									case 'Schwarz':
										$colName = $col;
										break;
									default:
								}
							}
						}
						else
						{
							// Datenspalte auswerten
							$spielername = $this->NameKonvertieren($spalte[$colName]);
							// Teilnehmer suchen
							$found = false;
							for($x = 0; $x < count($arrGP); $x++)
							{
								if($spielername == $arrGP[$x]['name'])
								{
									$found = true;
									break;
								}
							}

							// Wertungspunkte ermitteln
							$platz = 0 + $spalte[$colPlatz];
							$punkte = $wertung[$platz] ? $wertung[$platz] : 0;

							// Teilnehmer eintragen
							if($found)
							{
								// Array modifizieren
								$arrGP[$x]['t'.$turnier] = $punkte;
							}
							else
							{
								
								// Array erweitern
								$arrGP[] = array
								(
									'name'         => $spielername,
									'bonus'        => false,
									't1'           => $turnier == 1 ? $punkte : false,
									't2'           => $turnier == 2 ? $punkte : false,
									't3'           => $turnier == 3 ? $punkte : false,
									't4'           => $turnier == 4 ? $punkte : false,
									't5'           => $turnier == 5 ? $punkte : false,
									't6'           => $turnier == 6 ? $punkte : false,
									't7'           => $turnier == 7 ? $punkte : false,
									't8'           => $turnier == 8 ? $punkte : false,
									't9'           => $turnier == 9 ? $punkte : false,
									't10'          => $turnier == 10 ? $punkte : false,
									't11'          => $turnier == 11 ? $punkte : false,
									't12'          => $turnier == 12 ? $punkte : false,
									't13'          => $turnier == 13 ? $punkte : false,
									't14'          => $turnier == 14 ? $punkte : false,
									'punkte'       => 0,
									'anzahl'       => 0,
									'feinwertung1' => 0,
									'platz'        => 0,
								);
							}
						}
					}
				}

				// Summenwertung im Grand-Prix-Array berechnen
				for($x = 0; $x < count($arrGP); $x++)
				{
					// Turnieranzahl eintragen
					$anzahl = 0;
					$beste_turniere = array(); // Nimmt die Wertungspunkte der Turniere auf
					if($arrGP[$x]['bonus']) 
					{
						$anzahl++;
						$beste_turniere[] = sprintf("%2s",$arrGP[$x]['bonus']); // zweistellig, z.B. "01" statt "1"
					}
					for($t = 1; $t <= 14; $t++)
					{
						if($arrGP[$x]['t'.$t] !== false) 
						{
							$anzahl++;
							$beste_turniere[] = $arrGP[$x]['t'.$t]; // zweistellig, z.B. "01" statt "1"
						}
					}
					rsort($beste_turniere); // Drittwertung alphabetisch sortieren, höchster Wert am Anfang
					array_push($beste_turniere, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0); // Array auffüllen (damit Maximum der zu wertenden Turniere erreicht wird)
					$beste_turniere = array_slice($beste_turniere, 0, $objGrandPrix->max); // Auf beste x Turniere kürzen
					$arrGP[$x]['punkte'] = array_sum($beste_turniere); // Summe der Wertungen eintragen
					$arrGP[$x]['anzahl'] = $anzahl;
					// 1. Feinwertung eintragen
					$temp = '';
					foreach ($beste_turniere as $element) 
					{
						$temp .= substr('0'.$element, -2).'_';
					}
					$arrGP[$x]['feinwertung1'] = $temp;
				}
				
				// Grand-Prix-Tabelle sortieren
				$arrGP = $this->sortArrayByFields($arrGP, array('punkte' => SORT_DESC, 'feinwertung1' => SORT_DESC, 'anzahl' => SORT_DESC));

				//print_r($arrGP);
				// Header erstellen
				$content = '<table>';
				$content .= '<tr>';
				$content .= '<th>Pl.</th>';
				$content .= '<th>Teilnehmer</th>';
				$content .= '<th>B</th>';
				for($x = 1; $x <= $objTurniere->numRows; $x++)
				{
					$content .= '<th>T'.$x.'</th>';
				}
				$content .= '<th>Summe</th>';
				$content .= '<th>Anz.</th>';
				$content .= '</tr>';
				$alt = '';
				for($x = 0; $x < count($arrGP); $x++)
				{
					$platz = $x + 1;
					$neu = $arrGP[$x]['punkte'].$arrGP[$x]['feinwertung1'].$arrGP[$x]['anzahl'];
					$content .= '<tr>';
					$content .= $neu == $alt ? '<td>&nbsp;</td>' : '<td>'.$platz.'.</td>';
					$alt = $neu;
					$content .= '<td>'.$arrGP[$x]['name'].'</td>';
					$content .= '<td>'.$arrGP[$x]['bonus'].'</td>';
					for($y = 1; $y <= $objTurniere->numRows; $y++)
					{
						$content .= '<td>'.$arrGP[$x]['t'.$y].'</td>';
					}
					$content .= '<td>'.$arrGP[$x]['punkte'].'</td>';
					$content .= '<td>'.$arrGP[$x]['anzahl'].'</td>';
					$content .= '</tr>';
				}
				$content .= '</table>';
				
				//$content .= $objTurniere->title;
			}
			$this->Template->tabelle = $content;
		}
		else
		{
			$this->Template->tabelle = 'Noch kein Gesamtstand verfügbar!';
		}
		//global $objPage,$objArticle;
		//print_r($GLOBALS);
		//echo "ID=".$objPage->id;

		// Parameter zuweisen
			// Template ausgeben
			//$this->Template = new \FrontendTemplate($this->strTemplate);
			//$this->Template->class = "ce_chesstable";
			//$this->Template->tabelle = $content;
	}

	protected function NameDrehen($intext)
	{
		// Konvertiert Namen der Form Nachname,Vorname,Titel nach Titel Vorname Name
		$array = explode(",",$intext);
		$teile = count($array);
		$result = "";
		for($x=$teile-1;$x>=0;$x--)
		{
			$result .= " ".$array[$x];
		}
		return $result;
	}

	protected function NameKonvertieren($string) 
	{
		// Berichtigt einen String "Name,Vorname,Titel"
		// Entfernung von Leerzeichen und FIDE-Titeln
		$teil = explode(",",$string);
		// Leerzeichen davor und dahinter entfernen
		for($x=0;$x<count($teil);$x++) 
		{
			$teil[$x] = trim($teil[$x]);
		}
		// Neuen String bauen
		$temp = $teil[0];
		for($x=1;$x<count($teil);$x++) 
		{
			if(strtoupper($teil[$x])!="FM" && strtoupper($teil[$x])!="IM" && strtoupper($teil[$x])!="GM" && strtoupper($teil[$x])!="CM" && strtoupper($teil[$x])!="WGM" && strtoupper($teil[$x])!="WIM" && strtoupper($teil[$x])!="WFM" && strtoupper($teil[$x])!="WCM") 
			{
				$temp .= ",".$teil[$x];
			}
		}
		return $temp;
	}

	protected function sortArrayByFields($arr, $fields)
	{
		$sortFields = array();
		$args       = array();
		
		foreach ($arr as $key => $row) {
			foreach ($fields as $field => $order) {
				$sortFields[$field][$key] = $row[$field];
			}
		}
		
		foreach ($fields as $field => $order) {
			$args[] = $sortFields[$field];
			
			if (is_array($order)) {
				foreach ($order as $pt) {
				    $args[$pt];
				}
			} else {
				$args[] = $order;
			}
		}
		
		$args[] = &$arr;
		
		call_user_func_array('array_multisort', $args);
		
		return $arr;
	}

}
