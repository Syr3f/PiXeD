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
 *	@package XHTML3
 */

 
/**
 *	@todo To document
 */
class CXHLiquidGridDoc extends CXHDoc
{
	/**
	 *	@todo To document
	 */
	const iMaxCols = 24;

	
	/**
	 *	@todo To document
	 */
	const iCmdSpan = 'span';

	
	/**
	 *	@todo To document
	 */
	const iCmdAppend = 'append';


	/**
	 *	@todo To document
	 */
	const iCmdPrepend = 'prepend';

	/**
	 *	@todo To document
	 */
	const iMaxPull = 4;

	
	/**
	 *	@todo To document
	 */
	const iCmdPull = 'pull';


	/**
	 *	@todo To document
	 */
	const iMaxPush = 4;


	/**
	 *	@todo To document
	 */
	const iCmdPush = 'push';

	
	/**
	 *	@todo To document
	 */
	private $_oContainer;

	
	/**
	 *	@todo To document
	 */
	public function __construct($bShowGrid = false, $sTitle = "My XDiP Modeler Document", $sEncoding = "UTF-8", $sLanguage = "en")
	{
		parent::__construct($sTitle, $sEncoding, $sLanguage);
		
			$oCSS = new CXHCSS(CSS_BLUEPRINT_RESET);
		
		parent::AppendToHeader($oCSS);

			$oCSS = new CXHCSS(CSS_BLUEPRINT_TYPO);
		
		parent::AppendToHeader($oCSS);

			$oCSS = new CXHCSS(CSS_BLUEPRINT_FORMS);
		
		parent::AppendToHeader($oCSS);

			$oCSS = new CXHCSS(CSS_BLUEPRINT_LIQUID);
		
		parent::AppendToHeader($oCSS);

			$oCSS = new CXHCSS(CSS_BLUEPRINT_PRINT);
		
		parent::AppendToHeader($oCSS);
		
		$this->_iRowColCount = 0;
		
		$this->_oContainer = new CXHDiv();
		
		if ($bShowGrid)
			$this->_oContainer->SetClass("showgrid");
	}
	
	
	/**
	 *	@todo To document
	 */
	public function _genCol($sLiquidGridClass, $vContent, $bBoxed, $bColBorder, $bLast)
	{
		$sClass = "";
	
		if ($bColBorder)
			$sClass = "colborder"

		if ($bLast)
			$sClass = " last"

		$oDiv = new CHXDiv();
		
		$oDiv->SetClass($sClass);
		
			if ($bBoxed)
			{
				$vContent = new CXHDiv($vContent);
				
				$vContent->SetClass("box");
			}

			$oDiv->AppendContent($vContent);
	
		return $oDiv;
	}
	
	
	/**
	 *	@todo To document
	 */
	public function AddCol($cGridWidthCmd, $iCols, $vContent, $bBoxed = false, $bColBorder = true, $bLast = false)
	{
		$this->_iRowColCount += $iCols;
	
		switch ($cGridWidthCmd)
		{
			case self::iCmdSpan:
			case self::iCmdAppend:
			case self::iCmdPrepend:
				if ($this->_iRowColCount > self::iMaxCols)
					throw new XHException("Column ".$cGridWidthCmd." is above the grid limit of ".self::iMaxCols." (".$this->iRowColCount.")");
			break;
			case self::iCmdPull:
				if ($iCols > self::iMaxPull)
					throw new XHException("Column pull is above the limit of ".self::iMaxPull." (".$iCols.")");
			break;
			case self::iCmdPush:
				if ($iCols > self::iMaxPush)
					throw new XHException("Column push is above the limit of ".self::iMaxPush." (".$iCols.")");
			break;
		}
		
		$oCol = $this->_genCol($cGridWidthCmd."-".$iCols, $vContent, $bBoxed, $bColBorder, $bLast);
		
		$this->_oContainer->AppendContent($oCol);
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

?>