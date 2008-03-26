<?php
/***************************************************************
* Copyright notice
*
* (c) 2006-2008 Foundation for Evangelism
* All rights reserved
*
* This file is part of the Web-Empowered Church (WEC)
* (http://webempoweredchurch.org) ministry of the Foundation for Evangelism
* (http://evangelize.org). The WEC is developing TYPO3-based
* (http://typo3.org) free software for churches around the world. Our desire
* is to use the Internet to help offer new life through Jesus Christ. Please
* see http://WebEmpoweredChurch.org/Jesus.
*
* You can redistribute this file and/or modify it under the terms of the
* GNU General Public License as published by the Free Software Foundation;
* either version 2 of the License, or (at your option) any later version.
*
* The GNU General Public License can be found at
* http://www.gnu.org/copyleft/gpl.html.
*
* This file is distributed in the hope that it will be useful for ministry,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* This copyright notice MUST APPEAR in all copies of the file!
***************************************************************/

/** 
 * Wrapper class for the FlashObject Javascript library.
 *
 * @author		Web-Empowered Church Team <flashpresentation@webempoweredchurch.org>
 */


/** 
 * Wrapper class for the FlashObject Javascript library.  Provides a PHP object
 * and method to generate client-side Javascript for embedding Flash movies.
 *
 * @author		Web-Empowered Church Team <flashpresentation@webempoweredchurch.org>
 * @package		TYPO3
 * @subpackage	tx_wecflashpresentation
 */
class tx_wecflashpresentation_flashobject {
	
	var $flashObject;
	var $flashObjectVariables;
	var $flashObjectWrite;
	var $flashObjectPath;
	
	
	/*
	 * Constructor for the FlashObject.  Builds the main FlashObject in Javascript.
	 * @param	string	The path to the Flash movie.
	 * @param	string	The name of the Flash movie.
	 * @param	string	The width of the Flash movie.
	 * @param	string	The height of the Flash movie.
	 * @param	string	The version of the Flash Player required
	 * @param	string	The background color of the Flash movie.
	 * @param	string	The path to the FlashObject javascript.
	 */
	function tx_wecflashpresentation_flashobject($flashMoviePath, $name, $width, $height, $version, $bgColor, $flashObjectPath) {
		$this->flashObjectVariables = array();
		$this->flashObjectParameters = array();
		
		$this->flashObjectPath = $flashObjectPath;
		$this->flashMoviePath = $flashMoviePath;
		$this->name = $name;
		$this->width = $width;
		$this->height = $height;
		$this->version = $version;
		
		$this->flashObjectParameters['bgcolor'] = $bgColor;
	}
	
	/*
	 * Adds a variable to be passed to the Flash movie.
	 * @param	string	The name of the variable.
	 * @param	string	The value of the variable.
	 * @return	null
	 */
	function addVariable($var, $value) {
		$this->flashObjectVariables[$var] = $value;
	}
	
	/*
	 * Adds a parameter to be passed to the Flash movie.
	 * @param	string	The name of the parameter.
	 * @param	string	The value of the parameter.
	 */
	function addParameter($var, $value) {
		$this->flashObjectParameters[$var] = $value;
	}
	
	/*
	 * Generates the Javascript output for FlashObject.
	 * @return	string	Javascript output of FlashObject.
	 */
	function outputHeader() {
		
		$javascript = array();
		
		$javascript[] = "var flashvars = {";
		$variables = array();
		foreach($this->flashObjectVariables as $key => $value) {
			$variables[] = "	".addSlashes($key).": escape('".addSlashes($value)."')";
		}
		$javascript[] = implode(','.chr(10), $variables);
		$javascript[] = '}';
		
		$javascript[] = "var params = {";
		$parameters = array();
		foreach($this->flashObjectParameters as $key => $value) {
			$parameters[] = "	".addSlashes($key).": '".addSlashes($value)."'";
		}
		$javascript[] = implode(','.chr(10), $parameters);
		$javascript[] = '}';
		$javascript[] = "swfobject.embedSWF('".$this->flashMoviePath."', '".$this->name."', '".$this->width."', '".$this->height."', '8', '', flashvars, params);";

		$GLOBALS['TSFE']->additionalHeaderData['tx_wecflashpresentation_flashobject'] = '<script type="text/javascript" src="'.$this->flashObjectPath.'swfobject.js"></script>';		
		$GLOBALS['TSFE']->additionalHeaderData[] = t3lib_div::wrapJS(implode(chr(10), $javascript));
	}
}



if (defined("TYPO3_MODE") && $TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/wec_flashpresentation/class.tx_wecflashpresentation_flashobject.php"])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/wec_flashpresentation/class.tx_wecflashpresentation_flashobject.php"]);
}

?>