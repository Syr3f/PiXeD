<?php


/**
 *
 *	@package XHTML[5]
 *	@version 0.0
 *	@license http://creativecommons.org/licenses/by/3.0/ cc by
 *
 *	@copyright Copyright (c) 2010 Serafim Junior Dos Santos Fagundes Cyb3r Networks
 *	@author Serafim Junior Dos Santos Fagundes <serafim@cyb3r.ca>
 *  
 *
 *	The fifth level of abstraction of the XPiD Library.
 *	
 *	This file contains the code elements of the fifth level of abstraction of the XPiD Library.
 *
 *	The idea of this level is to extend the 4th level, .
 *
 *
 *	The XPiD Document.
 *	***
 ** XPiDDoc
 *	***
 *
 */
 

include("XH4.inc.php");


/**
 *	Creates an XDiP document with default style and Blueprint grid.
 */
class XPiDDoc extends CXHDoc
{
	/**
	 *	@todo To document
	 */
	const iClassSpan = 'span';


	/**
	 *	@todo To document
	 */
	const iClassAppend = 'append';


	/**
	 *	@todo To document
	 */
	const iClassPrepend = 'prepend';

	
	/**
	 *	@todo To document
	 */
	const iClassPull = 'pull';


	/**
	 *	@todo To document
	 */
	const iClassPush = 'push';


	/**
	 *	@todo To document
	 */
	const iMaxCols = 24;


	/**
	 *	@todo To document
	 */
	const iMaxPull = 24;


	/**
	 *	@todo To document
	 */
	const iMaxPush = 24;

	
	/**
	 *	@todo To document
	 */
	private $_oContainer;
	
	
	/**
	 *	@todo To document
	 */
	private $_sClassSet;

	
	/**
	 *	@todo To document
	 */
	private $_bIsContainerIntegrated;
	
	
	/**
	 *	@todo To document
	 */
	public function __construct($sTitle = "My XPiD Document", $sEncoding = "UTF-8", $sLanguage = "en")
	{
		parent::__construct($sTitle, $sEncoding, $sLanguage);
				
		$this->_iRowColCount = 0;
		$this->_sClassSet = "";
		
		$this->_oContainer = new CXHDiv();
		$this->_bIsContainerIntegrated = false;
		
		$this->_setCSS();
	}
	
	
	/**
	 *	@todo To document
	 */
	public function _setCSS()
	{
			$oCSS = new CXHCSS(CSS_BLUEPRINT_SCREEN);
		
		parent::AppendToHeader($oCSS);

			$oCSS = new CXHCSS(CSS_BLUEPRINT_PRINT, "print");
		
		parent::AppendToHeader($oCSS);

		if ($this->_isIE())
		{
				$oCSS = new CXHCSS(CSS_BLUEPRINT_IE);
		
			parent::AppendToHeader($oCSS);
		}
		
			//$oCSS = new CXHCSS(CSS_BLUEPRINT_LIQUID);
		
		//parent::AppendToHeader($oCSS);
	}
	
	
	/**
	 *	@todo To document
	 */
	public function _isIE()
	{
		$sUA = $_SERVER['HTTP_USER_AGENT'];
		
		return (preg_match('/msie/', $userAgent) ? true : false);
	}
	
	
	/**
	 *	@todo To document
	 */
	public function _validateAddition($csClassType, $iCols, $bIsColBordered)
	{
		$this->_iRowColCount += $iCols + ($bIsColBordered ? 1 : 0);
	
		switch ($csClassType)
		{
			case self::iClassSpan:
			case self::iClassAppend:
			case self::iClassPrepend:
				if ($this->_iRowColCount > self::iMaxCols)
					throw new XHException("Column ".$csClassType." is above the grid limit of ".self::iMaxCols." (".$this->iRowColCount.")");
			break;
			case self::iClassPull:
				if ($iCols > self::iMaxPull)
					throw new XHException("Column pull is above the limit of ".self::iMaxPull." (".$iCols.")");
			break;
			case self::iClassPush:
				if ($iCols > self::iMaxPush)
					throw new XHException("Column push is above the limit of ".self::iMaxPush." (".$iCols.")");
			break;
		}

	}
	
	
	/**
	 *	@todo To document
	 */
	public function SetContainerClass($sClass)
	{
		$this->_sClassSet = $sClass;
	}
	
	
	/**
	 *	@todo To document
	 */
	public function AddContainerStyle($sName, $sStyle)
	{
		$this->_oContainer->AddStyle($sName, $sStyle);
	}
	
	
	/**
	 *	@todo To document
	 */
	public function AdaptObject($oObject, $csClassType, $iNumCols, $bHasColBorder = false, $bIsLast = true)
	{
		if (_io($oObject, 'CXHEntityAttrs'))
		{
			$sClass = $oObject->GetClass();
			
			if (_sl($sClass))
				$sClass .= " ";
			
			$oObject->SetClass($sClass.$csClassType."-".$iNumCols);
		}
		else
			throw new XHException("Column to be appended is not an instance of CXHEntityAttrs");
		
		return $oObject;
	}
	
	
	/**
	 *	@todo To document
	 */
	public function IntegrateObject($oObject, $csClassType, $iNumCols, $bHasColBorder = false, $bIsLast = true)
	{
		$this->_validateAddition($cClassType, $iNumCols, $bHasColBorder);
	
		$oObject = $this->AdaptObject($oObject, $csClassType, $iNumCols, $bIsBoxed, $bHasColBorder, $bIsLast);

		$this->ContainerAppend($oObject);

		if ($bIsLast)
			$this->_iRowColCount = 0;
	}
	
	
	/**
	 *	@todo To document
	 */
	public function ContainerAppend($oObject)
	{
		$this->_oContainer->AppendContent($oObject);
	}
	
	
	/**
	 *	@todo To document
	 */
	private function _setContainerClasses()
	{
		$sContainerClass = "container";
		
		$sClasses = (_sl($this->_sClassSet) ? $sContainerCLass." ".$this->_sClassSet : $sContainerClass);
		
		$this->_oContainer->SetClass($sClasses);
	}
	

	/**
	 *	@todo To document
	 */
	public function IntegrateContainer()
	{
		$this->_bIsContainerIntegrated = true;
	
		$this->_setContainerClasses();
	
		parent::AppendContent($this->_oContainer);
	}
	
	
	/**
	 *	@todo To document
	 */
	public function __toString()
	{
		if (!$this->_bIsContainerIntegrated)
			$this->IntegrateContainer();
	
		return parent::__toString();
	}
}


?>