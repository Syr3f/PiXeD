<?php


/**
 *
 *	@package [0]Utilitaries
 *	@version 0.0.1
 *	@license MIT License
 *
 *	@copyright Copyright (c) 2010 Serafim Junior Dos Santos Fagundes Cyb3r Networks
 *	@author Serafim Junior Dos Santos Fagundes <serafim@cyb3r.ca>
 *
 *
 *	Base utilities for the XPiD library
 *
 *	This file contains the base code elements of the XPiD library and utilitary classes. Most of the code in this file is to be used by the XPiD library and shouldn't but can be used outsite of the XPiD library scope.
 */

 
/**
 *	Simple constant defining an empty string
 *
 *	@name PXH_EMPTY_STRING
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


/**
 *	@todo To document
 */
class CDatabase
{
	/**
	 *	@todo To document
	 */
	var $_iServer;


	/**
	 *	@todo To document
	 */
	var $_bConnected;


	/**
	 *	@todo To document
	 */
	var $_iLastIsertId;


	/**
	 *	@todo To document
	 */
	var $ErrorNo;


	/**
	 *	@todo To document
	 */
	var $ErrorMsg;


	/**
	 *	@todo To document
	 */
	function CDatabase($sHost = "", $sUser = "", $sPwd = "", $sDatabase = "")
	{
		$this->_bConnected = false;
		
		$this->_iLastIsertId = -1;

		if (strlen(trim($sHost)) > 0 and strlen(trim($sUser)) > 0 and strlen(trim($sPwd)) > 0)
		{
			$this->_iServer = mysql_connect($sHost, $sUser, $sPwd) or $this->Alert("CDatabase","cannot connect to host");
		}
		else
		{
			$iCount = 0;

			if (strlen(trim($sHost)) > 0)
				$iCount++;

			if (strlen(trim($sUser)) > 0)
				$iCount++;

			if (strlen(trim($sPwd)) > 0)
				$iCount++;

			if ($iCount > 0 and $iCount < 3)
				$this->Alert("CDatabase","you must set the 3 minimal parameters or none");
		}

		if (strlen(trim($sDatabase)) > 0)
		{
			if (mysql_select_db($sDatabase, $this->_iServer))
				$this->_bConnected = true;
			else
				 $this->Alert("CDatabase","cannot connect to database");
		}
	}


	/**
	 *	@todo To document
	 */
	function Alert($sFunction, $sMessage)
	{
		die("<strong style='color:red;'>ERROR! function ".$sFunction." - ".$sMessage."</strong><br />");
	}


	/**
	 *	@todo To document
	 */
	function Connect($sHost, $sUser, $sPwd, $sDatabase = "")
	{
		if (!$this->_bConnected)
		{
			if (strlen(trim($sHost)) > 0 and strlen(trim($sUser)) > 0 and strlen(trim($sPwd)) > 0)
			{
				$this->_iServer = mysql_connect($sHost, $sUser, $sPwd) or die("ERROR! function CDatabase cannot connect to host");
			}
			else
			{
				$iCount = 0;

				if (strlen(trim($sHost)) > 0)
					$iCount++;

				if (strlen(trim($sUser)) > 0)
					$iCount++;

				if (strlen(trim($sPwd)) > 0)
					$iCount++;

				if ($iCount > 0 and $iCount < 3)
					$this->Alert("Connect","you must set the 3 minimal parameters or none for function");
			}

			if (strlen(trim($sDatabase)) > 0)
			{
				if (mysql_select_db($sDatabase, $this->_iServer))
					$this->_bConnected = true;
				else
					 $this->Alert("Connect","cannot connect to database");
			}
		}
		else
		{
			$this->Alert("Connect","a connection is already established");
		}
	}


	/**
	 *	@todo To document
	 */
	function Disconnect()
	{
		if ($this->_bConnected)
		{
			mysql_close($this->_iServer);
			$this->_bConnected = false;
		}
	}


	/**
	 *	@todo To document
	 */
	function IsConnected()
	{
		return $this->_bConnected;
	}


	/**
	 *	@todo To document
	 */
	function Query($sSQL)
	{
		$vResult = mysql_query($sSQL);

		if (preg_match("/SELECT|SHOW|DESCRIBE|EXPLAIN/", $sSQL))
		{
			if ($vResult !== false)
			{
				return new CRecordset($vResult);
			}
		}
		else
		{	
			if (preg_match("/INSERT/", $sSQL))
			{
				$this->_iLastIsertId = mysql_insert_id();
			}

			if ($vResult === false)
			{
				$this->ErrorNo = mysql_errno();
				$this->ErrorMsg = mysql_error();
			}
		}

		return $vResult;
	}
	
	function GetLastInsertId()
	{
		return $this->_iLastIsertId;
	}
}


/**
 *	@todo To document
 */
class CRecordset
{
	/**
	 *	@todo To document
	 */
	var $_vResult;


	/**
	 *	@todo To document
	 */
	var $_iCursor;


	/**
	 *	@todo To document
	 */
	var $_iNumRows;


	/**
	 *	@todo To document
	 */
	var $Field;


	/**
	 *	@todo To document
	 */
	function CRecordset($vResult)
	{
		$this->_vResult = $vResult;
		$this->_iCursor = 0;
		$this->_iNumRows = mysql_num_rows($vResult);

		if ($this->_iNumRows > 0)
		{
			$this->Field = mysql_fetch_assoc($this->_vResult);
		}
	}


	/**
	 *	@todo To document
	 */
	function IsEOF() // position after the last recordset
	{
		return ($this->_iNumRows == $this->_iCursor);
	}


	/**
	 *	@todo To document
	 */
	function IsBOF()
	{
		return ($this->_iCursor == 0);
	}


	/**
	 *	@todo To document
	 */
	function MoveNext()
	{
		$this->_iCursor++;
		if ($this->_iCursor <= $this->_iNumRows - 1)
		{
			if (mysql_data_seek($this->_vResult, $this->_iCursor))
			{
				$this->Field = mysql_fetch_assoc($this->_vResult);
			}
		}
	}


	/**
	 *	@todo To document
	 */
	function MoveToData($iPosition)
	{
		if ($iPosition <= $this->_iNumRows - 1)
		{
			$this->_iCursor = $iPosition;

			if (mysql_data_seek($this->_vResult, $this->_iCursor))
			{
				$this->Field = mysql_fetch_assoc($this->_vResult);
			}
		}
		else
		{
			$this->Alert("Move", "The position is beyond the last recordset");
		}
	}


	/**
	 *	@todo To document
	 */
	function GetNumRows()
	{
		return $this->_iNumRows;
	}


	/**
	 *	@todo To document
	 */
	function Alert($sFunction, $sMessage)
	{
		die("<strong style='color:red;'>ERROR! function ".$sFunction." - ".$sMessage."</strong><br />");
	}
}


?>
