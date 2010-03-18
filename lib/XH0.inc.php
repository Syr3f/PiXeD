<?php


/**
 *
 *	@package [0]Utilitaries
 *	@version 0.0
 *	@license http://creativecommons.org/licenses/by/3.0/ cc by
 *
 *	@copyright Copyright (c) 2010 Serafim Junior Dos Santos Fagundes Cyb3r Networks
 *	@author Serafim Junior Dos Santos Fagundes <serafim@cyb3r.ca>
 *
 *
 *	Base utilities for the XPiD
 *
 *	This file contains the base code elements of the XPiD. Most of the code in this file is to be used by the XPiD and shouldn't but can be used outsite of the XPiD scope.
 */

 
/**
 *	Simple constant defining an empty string
 */
define("PXH_EMPTY_STRING","");


/**
 *	Simple constant defining a null object
 *
 *	@name PXH_NULL_OBJECT
 */
define("PXH_NULL_OBJECT", null);


/**
 *	Shortcut function for is_string
 *
 *	@param string $vData Holds the value to evaluate if it is a string
 *
 *	@return bool
 */
function _is($vData)
{
	if (is_string($vData))
		return true;
	else
		return false;
}

 
/**
 *	Shortcut function for strlen
 *
 *	@param string $sString String passed to mesure length and assume the parameter is not empty
 *
 *	@return int
 */
function _sl($sString)
{
	if (_is($sString))
		return strlen(trim($sString));
	else
		throw new Exception("Parameter is not a string");
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
	if (_is($sString))
		return trim($sString) == "";
	else
		throw new Exception("Parameter is not a string");
}


/**
 *	Shortcut function to verify if object is null
 *
 *	@param object $vObject Object passed to verify if is null
 *
 *	@return bool
 */
function _in($vObject)
{
	return is_null($vObject);
}


?>