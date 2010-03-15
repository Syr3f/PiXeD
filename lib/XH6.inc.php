<?php


/**
 *
 *	@package [6]Templates
 *	@version 0.0
 *	@license http://creativecommons.org/licenses/by/3.0/ cc by
 *
 *	@copyright Copyright (c) 2010 Serafim Junior Dos Santos Fagundes Cyb3r Networks
 *	@author Serafim Junior Dos Santos Fagundes <serafim@cyb3r.ca>
 *  
 *
 *	The sixth level of abstraction of the XPiD Library.
 *	
 *	This file contains the code elements of the sixth level of abstraction of the XPiD Library.
 *
 *	The idea of this level is to extend the 5nd level, .
 */

 
require_once("XH5.inc.php");
 
 
/**
 *	@todo To document
 */
class Paternal extends XPiDDoc
{
	const sDefEncoding = "UTF-8";
	
	const sDefBgColor = "#777000";
	
	const sDefHeadColor = "#770000";
	
	const sDefBorderColor = "white";
	
	const sDefWidthBorder = "5px";
	
	const sDefHeadBandColor = "#222";
	
	const sDefTitleColor = "white";
	
	
	private $_bHeaderBandSet;
	
	private $_bTitleHeaderSet;
	
	private $_bFooterSet;
	

	public function __construct($sTitle, $sLanguage = "en")
	{
		parent::__construct($sTitle, self::sDefEncoding, $sLanguage);
		
		$this->_bHeaderBandSet = false;
		
		$this->_bTitleHeaderSet = false;
		
		$this->_bFooterSet = true;
		
		$this->_setDefaultStyles();
	}
	
	
	private function _setDefaultStyles()
	{
		$oCSS = new CXHCSS(CSS_LOTUS_TYPO);

		parent::AppendToHeader($oCSS);
		
		parent::AddStyle("background-color", self::sDefBgColor);
		
		parent::AddContainerStyle("background-color", self::sDefHeadColor);
		parent::AddContainerStyle("border", "0px solid ".self::sDefBorderColor);
		parent::AddContainerStyle("border-left-width", self::sDefWidthBorder);
		parent::AddContainerStyle("border-right-width", self::sDefWidthBorder);
	}
	
	
	public function SetHeaderBand($vContent = "XPiD Paternal Template", $sColor = self::sDefHeadBandColor)
	{
		$oBand = new CXHDiv($vContent);
		$oBand->AddStyle("background-color", $sColor);
		$oBand->AddStyle("height", "50px");

		parent::AppendContent($oBand);
		
		$this->_bHeaderBandSet = true;
	}
	
	
	public function SetBgColor($sColor)
	{
		$oDoc->AddStyle("background-color", $sColor);
	}
	
	
	public function SetHeadColor($sColor)
	{
		$oDoc->AddContainerStyle("background-color", $sColor);
	}
	
	
	public function SetBorderColor($sColor)
	{
		$oDoc->AddContainerStyle("border-color", $sColor);
	}
	
	
	public function SetBorderWidth($sWidth)
	{
		$oDoc->AddContainerStyle("border-left-width", $sWidth);
		$oDoc->AddContainerStyle("border-right-width", $sWidth);
	}
	
	
	public function SetTitleHeader($sTitle1 = "XPiD Framework", $sColor1 = sDefTitleColor, $sTitle2 = "Paternal Template", $sColor2 = sDefTitleColor)
	{
			$oDiv = new CXHDiv();
			$oDiv->AddStyle("padding", "25px");

				$oH = new CXHHeading(CXHHeading::iLvl1);
			
				$oH->AppendContent($sTitle1);
				$oH->AddStyle("color", $sColor1);

			$oDiv->AppendContent($oH);
			
		if (_sl($sTitle2))
		{
				$oH = new CXHHeading(CXHHeading::iLvl1);
			
				$oH->AppendContent($sTitle2);
				$oH->AddStyle("color", $sColor2);
				
			$oDiv->AppendContent($oH);
		}

		parent::IntegrateObject($oDiv, XPiDDoc::iClassSpan, 24, false, true);
		
		$this->_bTitleHeaderSet = true;
	}
	
	
	public function SetFooter($vContent = "")
	{
			$oBand = new CXHDiv();
			$oBand->AddStyle("background-color", "#222");
			$oBand->AddStyle("height", "50px");

		$oDoc->IntegrateObject($oBand, XPiDDoc::iClassSpan, 24, false, true);

			$oDiv = new CXHDiv();
			$oDiv->AddStyle("background-color", "white");
			$oDiv->AddStyle("height", "587px");
			
			if (!_sl($vContent))
			{
					$vContent = new CXHDiv("XPiD Framework");
				
					$vContent->SetClass("span-8");
					
				$oDiv->AppendContent($vContent);

					$vContent = new CXHDiv("Paternal Template");
				
					$vContent->SetClass("span-8");
					
				$oDiv->AppendContent($vContent);

					$vContent = new CXHDiv("Cyb3r Network");
				
					$vContent->SetClass("span-8 last");
					
				$oDiv->AppendContent($vContent);
			}
			else
				$oDiv->AppendContent($vContent);

		$oDoc->IntegrateObject($oDiv, XPiDDoc::iClassSpan, 24, false, true);
		
		$this->_bFooterSet = true;
	}
	
	
	public function __toString()
	{
		if (!$this->_bHeaderBandSet)
			$this->SetHeaderBand();
			
		if (!$this->_bTitleHeaderSet)
			$this->SetTitleHeader();
			
		if (!$this->_bFooterSet)
			$this->SetFooter();
	
		return parent::__toString();
	}
}

?>