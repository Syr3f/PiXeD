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
 *	Base utilities for the XPiD
 *
 *	This file contains the base code elements of the XPiD. Most of the code in this file is to be used by the XPiD and shouldn't but can be used outsite of the XPiD scope.
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


class DBException extends Exception
{
	public function __construct($sMessage)
	{
		parent::__construct($sMessage);
	}
}

/**
 *	@todo To document
 */
class CDatabase
{
	/**
	 *	@todo To document
	 *	@access private
	 */
	private $_iServer;


	/**
	 *	@todo To document
	 *	@access private
	 */
	private $_bConnected;


	/**
	 *	@todo To document
	 *	@access private
	 */
	private $_iLastIsertId;


	/**
	 *	@todo To document
	 *	@access private
	 */
	private $ErrorNo;


	/**
	 *	@todo To document	 
	 *	@access private
	 */
	private $ErrorMsg;


	/**
	 *	@todo To document
	 */
	public function __construct($sHost = "", $sUser = "", $sPwd = "", $sDatabase = "")
	{
		self::_Create($sHost, $sUser, $sPwd, $sDatabase);
	}


	protected function _Create($sHost, $sUser, $sPwd, $sDatabase)
	{
		$this->_bConnected = false;
		
		$this->_iLastIsertId = -1;

		$this->Connect($sHost, $sUser, $sPwd, $sDatabase);
	}


	/**
	 *	@todo To document
	 */
	public function Connect($sHost, $sUser, $sPwd, $sDatabase = "")
	{
		if (!$this->_bConnected)
		{
			if (_sl(trim($sHost)) > 0 and _sl(trim($sUser)) > 0 and _sl(trim($sPwd)) > 0)
			{
				if (!($this->_iServer = mysql_connect($sHost, $sUser, $sPwd)))
					throw new DBException("cannot connect to host");
			}
			else
			{
				$iCount = 0;

				if (_sl(trim($sHost)) > 0)
					$iCount++;

				if (_sl(trim($sUser)) > 0)
					$iCount++;

				if (_sl(trim($sPwd)) > 0)
					$iCount++;

				if ($iCount > 0 and $iCount < 3)
					throw new DBException("you must set the 3 minimal parameters or none for function");
			}

			if (_sl(trim($sDatabase)) > 0)
			{
				if (mysql_select_db($sDatabase, $this->_iServer))
					$this->_bConnected = true;
				else
					 throw new DBException("cannot connect to database");
			}
		}
		else
		{
			throw new DBException("a connection is already established");
		}
	}


	/**
	 *	@todo To document
	 */
	public function Disconnect()
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
	public function IsConnected()
	{
		return $this->_bConnected;
	}


	/**
	 *	@todo To document
	 */
	public function Query($sSQL)
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
	
	public function GetLastInsertId()
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
	 *	@access private
	 */
	private $_vResult;


	/**
	 *	@todo To document
	 *	@access private
	 */
	private $_iCursor;


	/**
	 *	@todo To document
	 *	@access private
	 */
	private $_iNumRows;


	/**
	 *	@todo To document
	 */
	public $Field;


	/**
	 *	@todo To document
	 */
	public function __construct($vResult)
	{
		self::_Create($vResult);
	}


	/**
	 *	@todo To document
	 */
	protected function _Create($vResult)
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
	public function IsEOF() // position after the last recordset
	{
		return ($this->_iNumRows == $this->_iCursor);
	}


	/**
	 *	@todo To document
	 */
	public function IsBOF()
	{
		return ($this->_iCursor == 0);
	}


	/**
	 *	@todo To document
	 */
	public function MoveNext()
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
	public function MoveToData($iPosition)
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
			throw new DBException("The position is beyond the last recordset");
		}
	}


	/**
	 *	@todo To document
	 */
	public function GetNumRows()
	{
		return $this->_iNumRows;
	}
}


?>
