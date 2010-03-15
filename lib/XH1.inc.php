<?php


/**
 *
 *	@package [1]Markup
 *	@version 0.0
 *	@license http://creativecommons.org/licenses/by/3.0/ cc by
 *
 *	@copyright Copyright (c) 2010 Serafim Junior Dos Santos Fagundes Cyb3r Networks
 *	@author Serafim Junior Dos Santos Fagundes <serafim@cyb3r.ca>
 *
 *
 *	The first level of abstraction of the XPiD Library.
 *	
 *	This file contains the code elements of the first level of abstraction of the XPiD Library.
 *
 *	
 */

 
require_once("XH0.inc.php");


/**
 *	Exception class for CMLEntity
 */
class MLException extends Exception
{
	/**
	 *	@param string $sMessage Message of the exception
	 */
	public function __construct($sMessage)
	{
		parent::__construct($sMessage);
	}
}


/**
 *  Markup entity abstraction class
 */
abstract class CMLEntity
{
	/**
	 *	@var string Name of the entity tag
	 */
	private $_sName;


	/**
	 *	@var bool Defines the ending of the entity; true is full markup ending, false is self ending
	 */
	private $_bHasEnd;


	/**
	 *	@var string Variable holding the string content
	 */
	private $_sContent;


	/**
	 *	@var array Hash array holding the entity's attributes; keys are the attribute names, items are the values
	 */
	private $_hsAttrs0;


	/**
	 *	@var string String defining the end of line caracters
	 */
	protected $sNL;


	/**
	 *	@var string String defining the tab caracter
	 */
	protected $sTAB;


	/**
	 *	@var string Constant of maximum size of the content of a CMLEntity in bytes
	 */
	const iMAX_APPEND_SIZE_B = 2097152;


	/**
	 *	@param string $sName Name of the entity tag
	 *	@param bool $bHasEnd Value indicating if entity has an explicit end; if full closed; defaults to true
	 *	@param string $sContent Initial content to add to the entity; defaults to empty string
	 */
	public function __construct($sName, $bHasEnd = true, $sContent = PWL_EMPTY_STRING)
	{	
		$this->_sName = $sName;
		$this->_bHasEnd = $bHasEnd;
		$this->_sContent = $sContent;

		$this->_hsAttrs0 = array();

		$this->sNL = chr(13).chr(10);
		$this->sTAB = chr(9);
		
		$this->_iSizeCount = 0;
	}


	/**
	 *	Returns the name of the entity
	 *
	 *	@return string
	 */
	public function GetName()
	{
		return $this->_sName;
	}


	/**
	 *	Adds an attribute to the entity
	 *
	 *	@param string $sName Name of the attribute
	 *	@param string $sValue Value of the entity
	 */
	public function AddAttr($sName, $sValue)
	{
		if (_sl($sValue))
		{
			$this->_hsAttrs0[$sName] = $sValue;
		}
	}


	/**
	 *	Adds a set of attributes to the entity
	 *	
	 *	@param array $hArray Hash value array containing attribute names and values as keys and values respectively
	 */
	public function AddAttrs($hAttrs)
	{
		foreach ($hAttrs as $sKey => $sVal)
		{
			$this->AddAttr($sKey, $sVal);
		}
	}


	/**
	 *	Appends content to the entity
	 *
	 *	@param mixed $vContent Content to be appended inside the entity
	 */
	public function AppendContent($vContent)
	{
		if ($this->_iSizeCount < self::iMAX_APPEND_SIZE_B)
		{
			if ($this->_bHasEnd)
			{
				if (is_string($vContent) || _io($vContent, 'CMLEntity'))
				{
					$this->_sContent .= $vContent;
					$this->_iSizeCount += _sl(utf8_decode($vContent));
				}
				else
				{
					throw new MLException("Content to append $sContent is not explicitly passed as string or not an instance of CMLEntity");
				}
			}
			else
			{
				throw new MLException("Cannot append to closed end element.");
			}
		}
		else
		{
			throw new MLException("Size above the limit of ".self::iMAX_APPEND_SIZE_B);
		}
	}


	/**
	 *	Replaces the content of the entity
	 *
	 *	@param mixed $vContent Content to replace the entity inner content
	 */
	public function ReplaceContent($vContent)
	{
		$this->_sContent = "";

		$this->AppendContent($vContent);
	}


	/**
	 *	Method to generate the entity's attributes string
	 *
	 *	@return string
	 */
	private function _generateAttrsString()
	{
		$sAttrs = PWL_EMPTY_STRING;

		foreach ($this->_hsAttrs0 as $sName => $sValue)
		{
			$sAttrs .= ' '.$sName.'='.chr(34).$sValue.chr(34);
		}

		return $sAttrs;
	}


	/**
	 *	@return string
	 */
	public function __toString()
	{
		$sML = '<'.$this->_sName.$this->_generateAttrsString();

		if (!$this->_bHasEnd)
			$sML .= ' /';

		$sML .= '>';

		if ($this->_bHasEnd)
		{
			$sML .= $this->_sContent;
			$sML .= '</'.$this->_sName.'>';
		}

		return $sML;
	}
}


?>