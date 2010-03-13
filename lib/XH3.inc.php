<?php


/**
 *	Second level abstraction of the PHPWebLib.
 *	
 *	This file contains the code elements of the second level abstraction of the PHPWebLib.
 *
 *	@author Serafim Junior Dos Santos Fagundes <serafim@cyb3r.ca>
 *	@copyright Copyright (c) 2010 Serafim Junior Dos Santos Fagundes Cyb3r Networks
 *	@license http://creativecommons.org/licenses/by/3.0/ cc by
 *  
 *	@version 0.0
 *
 *	@package XHTML-Level3
 */


include("XH1.inc.php");


/**
 *	Creates a Blueprint grid document.
 */
class CXHBpDoc extends CXHDoc
{
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
	public function __construct($sTitle = "My XDiP Modeler Document", $sEncoding = "UTF-8", $sLanguage = "en")
	{
		parent::__construct($sTitle, $sEncoding, $sLanguage);
				
		$this->_iRowColCount = 0;
		
		$this->_oContainer = new CXHDiv();
		
		$this->_oContainer->SetClass("container");
		
		$this->_setCSS();
	}
	
	
	/**
	 *	@todo To document
	 */
	public function _setCSS()
	{
			$oCSS = new CXHCSS(CSS_BLUEPRINT_RESET);
		
		parent::AppendToHeader($oCSS);

			//$oCSS = new CXHCSS(CSS_BLUEPRINT_TYPO);
		
		//parent::AppendToHeader($oCSS);

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
	public function _validateAddition($cClassType, $iCols, $bIsColBordered)
	{
		$this->_iRowColCount += $iCols + ($bIsColBordered ? 1 : 0);
	
		switch ($cClassType)
		{
			case CXHBpCol::iClassSpan:
			case CXHBpCol::iClassAppend:
			case CXHBpCol::iClassPrepend:
				if ($this->_iRowColCount > self::iMaxCols)
					throw new XHException("Column ".$cClassType." is above the grid limit of ".self::iMaxCols." (".$this->iRowColCount.")");
			break;
			case CXHBpCol::iClassPull:
				if ($iCols > self::iMaxPull)
					throw new XHException("Column pull is above the limit of ".self::iMaxPull." (".$iCols.")");
			break;
			case CXHBpCol::iClassPush:
				if ($iCols > self::iMaxPush)
					throw new XHException("Column push is above the limit of ".self::iMaxPush." (".$iCols.")");
			break;
		}

	}
	
	
	/**
	 *	@todo To document
	 */
	public function AddCol($cClassType, $iCols, $vContent, $bBoxed = false, $bColBorder = true, $bLast = false)
	{
			$oCol = new CXHLGCol($cClassType, $iCols, $bBoxed, $bColBorder, $bLast);
		
			$oCol->AppendContent($vContent);
		
		$this->AppendContent($oCol);
	}
	
	
	/**
	 *	@todo To document
	 */
	public function InsertCol($oCol)
	{
		$this->AppendContent($oCol);
	}
	
	
	/**
	 *	@todo To document
	 */
	public function AppendContent($oCol)
	{
		$this->_validateAddition($oCol->GetClassType(), $oCol->GetNumCols(), $oCol->IsColBordered());
	
		if (_io($oCol, 'CXHBpCol'))
			$this->_oContainer->AppendContent($oCol);
		else
			throw new XHException("Column to be appended is not an instance of CXHBpCol");
			
		if ($oCol->IsLast())
			$this->_iRowColCount = 0;
	}
	
	
	/**
	 *	@todo To document
	 */
	public function __toString()
	{
		parent::AppendContent($this->_oContainer);
	
		return parent::__toString();
	}
}


/**
 *	@todo To document
 */
class CXHBpCol extends CXHDiv
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
	private $_sClass;
	
	
	/**
	 *	@todo To document
	 */
	private $_sClassType;
	
	
	/**
	 *	@todo To document
	 */
	private $_bBoxed;
	
	
	/**
	 *	@todo To document
	 */
	private $_bColBorder;
	
	
	/**
	 *	@todo To document
	 */
	private $_bLast;
	
	
	/**
	 *	@todo To document
	 */
	private $_iNumCols;


	/**
	 *	@todo To document
	 */
	private $_vContent;

	
	/**
	 *	@todo To document
	 */
	public function __construct($sClassType, $iNumCols, $bBoxed, $bColBorder, $bLast)
	{
		parent::__construct();
		
		$this->_sClass = "";
		
		$this->_sClassType = $sClassType;
		$this->_iNumCols = $iNumCols;
		$this->_bBoxed = $bBoxed;
		$this->_bColBorder = $bColBorder;
		$this->_bLast = $bLast;
		
		$this->_vContent = "";
	}
	
	
	/**
	 *	@todo To document
	 */
	public function SetClass($sClass)
	{
		$this->_sClass = $sClass;
	}
	
	
	/**
	 *	@todo To document
	 */
	public function GetClassType()
	{
		return $this->_sClassType;
	}
	
	
	/**
	 *	@todo To document
	 */
	public function GetNumCols()
	{
		return $this->_iNumCols;
	}
	
	
	/**
	 *	@todo To document
	 */
	public function IsColBordered()
	{
		return $this->_bColBorder;
	}
	
	
	/**
	 *	@todo To document
	 */
	 public function IsLast()
	 {
		return $this->_bLast;
	 }
	 
	
	/**
	 *	@todo To document
	 */
	public function AppendContent($vContent)
	{
		if (!_io($vContent, 'CXHBpCol'))
			$this->_vContent = $vContent;
		else
			throw new XHException("Content to be appended is an instance of CXHBpCol");
	}
	
	
	/**
	 *	@todo To document
	 */
	public function __toString()
	{
		$sClass = $this->_sClassType."-".$this->_iNumCols;
	
		if ($this->_bColBorder) $sClass .= " colborder";

		if ($this->_bLast) $sClass .= " last";
		
		parent::SetClass($this->_sClass.$sClass);
		
		$vContent = $this->_vContent;
		
		if ($this->_bBoxed)
		{
			if (_io($vContent, 'CXHEntityAttrs') || _io($vContent, 'CXHEntityCoreAttrs'))
			{
				$sClass = $vContent->GetClass();
			
				if (_sl($sClass))
					$sClass = " ".$sClass;
			
				$vContent->SetClass("box".$sClass);
			}
			else
			{
				$vContent = new CXHDiv($this->_vContent);
			
				$vContent->SetClass("box");
			}
			
		}

		parent::AppendContent($vContent);

		return parent::__toString();
	}
}


?>