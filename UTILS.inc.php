<?php

/**
 *	Base utilities for the PHPWebLib
 *
 *	This file contains the base code elements of the PHPWebLib. Most of the code in this file is to be used by the PHPWebLib and shouldn't but can be used outsite of the PHPWebLib scope.
 *	
 *	@author Serafim Junior Dos Santos Fagundes <serafim@cyb3r.ca>
 *	@copyright Copyright (c) 2010 Serafim Junior Dos Santos Fagundes
 *	@license http://creativecommons.org/licenses/by/3.0/ cc by
 *  
 *	@version 1.0
 *
 *	@package PHPWebLib
 */

 
/**
 *	Simple constant defining an empty string
 */
define("PWL_EMPTY_STRING","");


/**
 *	Simple constant defining a null object
 *
 *	@name PWL_NULL_OBJECT
 */
define("PWL_NULL_OBJECT", null);

 
/**
 *	Shortcut function for strlen
 *
 *	@param string $sString String passed to mesure length and assume the parameter is not empty
 *
 *	@return int
 */
function _sl($sString)
{
	if (is_string($sString))
		return strlen(trim($sString));
	else
		throw new Exception($sString." is not explicitly a string");
}


/**
 *	Shortcut function for instance of
 *
 *	@param object $oInstance Object passed to verify if is instance of $sClass
 *	@param string $sClass String of the class to verify is $oInstance is an instance of it
 *
 *	@return bool
 */
function _io($oInstance, $sClass)
{
	return $oInstance instanceof $sClass;
}


/**
 *	Shortcut function to verify if string is empty
 *
 *	@param string $sString String to verify if is empty
 *
 *	@return bool
 */
function _es($sString)
{
	return trim($sString) == "";
}


/**
 *	Shortcut function to verify if object is null
 *
 *	@param object $vObject Object passed to verify if is null
 *
 *	@return bool
 */
function _nv($vObject)
{
	return is_null($vObject);
}
?>