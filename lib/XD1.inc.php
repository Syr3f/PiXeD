<?php


/**
 *
 *	@package XD[1]Markup
 *	@version 0.2
 *	@license MIT License
 *
 *	@copyright Copyright (c) 2010 Serafim Junior Dos Santos Fagundes Cyb3r Network
 *	@author Serafim Junior Dos Santos Fagundes <serafim@cyb3r.ca>
 *
 *
 *	The first level of abstraction of the XD Library.
 *	
 *	This file contains the code elements of the first level of abstraction of the XD Library.
 *
 *	The first level of abstraction defines the concept of markup identification as used in the XHTML documentation. Only classes and relative Exceptions refered to basic markup creation are defined in this file.
 */

 
/**
 *	Links base utilitaries file
 */
require_once("XD0.inc.php");


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
 *	XD abstraction class
 *
 *	All objects to be used in an XHTML document must be an instance of this class.
 *
 *	@abstract
 */
abstract class CMLObject
{
	/**
	 *	Main initializer of the class. Variable assignments and methods used to instantiate the class should be processed in this method, not in __construct. Default parameter values should be used in __construct vs. non mandatory parameters should have an explicit value in _Create.
	 *
	 *	@abstract
	 */
	abstract protected function _Create();

	
	/**
	 *	Main generator of the markup entity. Markup should be assembled in this method not in __toString.
	 *
	 *	@abstract
	 */
	abstract protected function _Generate();
}

/**
 *  Markup entity abstraction class
 *	
 *	@abstract
 */
abstract class CMLEntity extends CMLObject
{
	/**
	 *	@var string Name of the entity tag
	 *	@access private
	 */
	private $_sName;


	/**
	 *	@var bool Defines the ending of the entity; true is full markup ending, false is self ending
	 *	@access private
	 */
	private $_bHasEnd;


	/**
	 *	@var string Variable holding the string content
	 *	@access private
	 */
	private $_sContent;


	/**
	 *	@var array Hash array holding the entity's attributes; keys are the attribute names, items are the values
	 *	@access private
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
	public function __construct($sName, $bHasEnd = true, $sContent = PXH_EMPTY_STRING)
	{	
		self::_Create($sName, $bHasEnd, $sContent);
	}


	/**
	 *	@param string $sName Name of the entity tag
	 *	@param bool $bHasEnd Value indicating if entity has an explicit end; if full closed; defaults to true
	 *	@param string $sContent Initial content to add to the entity; defaults to empty string
	 */
	protected function _Create($sName, $bHasEnd, $sContent)
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
	 *	Gets the attribute value associated with the name
	 *
	 *	@param string $sName Name of the attribute
	 *	@return string
	 */
	public function GetAttr($sName)
	{
		if (array_key_exists($sName, $this->_hsAttrs0))
			$sResult = $this->_hsAttrs0[$sName];
		else
			$sResult = "";
		
		return $sResult;
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
				if (is_string($vContent) || _io($vContent, 'CMLObject'))
				{
					$this->_sContent .= $vContent;
					$this->_iSizeCount += _sl(utf8_decode($vContent));
				}
				else
				{
					throw new MLException("Content to append is not explicitly passed as string or not an instance of CMLEntity");
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
	 *	@access private
	 *
	 *	@return string
	 */
	private function _generateAttrsString()
	{
		$sAttrs = PXH_EMPTY_STRING;

		foreach ($this->_hsAttrs0 as $sName => $sValue)
		{
			$sAttrs .= ' '.$sName.'='.chr(34).$sValue.chr(34);
		}

		return $sAttrs;
	}
	
	
	/**
	 *	Generates the markup with it's content 
	 *
	 *	@return string
	 */
	protected function _Generate()
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


	/**
	 *	@return string
	 */
	public function __toString()
	{
		return self::_Generate();
	}
}


?>
