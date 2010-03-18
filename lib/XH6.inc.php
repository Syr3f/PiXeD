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
	/**
	 *	@todo To document
	 */
	const sDefEncoding = "UTF-8";
	
	/**
	 *	@todo To document
	 */
	const sDefBgColor = "#777000";
	
	/**
	 *	@todo To document
	 */
	const sDefHeadColor = "#770000";
	
	/**
	 *	@todo To document
	 */
	const sDefBorderColor = "white";
	
	/**
	 *	@todo To document
	 */
	const sDefWidthBorder = "5px";
	
	/**
	 *	@todo To document
	 */
	const sDefHeadBandColor = "#222";
	
	/**
	 *	@todo To document
	 */
	const sDefTitleColor = "white";
	
	/**
	 *	@todo To document
	 */
	const sDefEvenContentBgColor = "#666";
	
	/**
	 *	@todo To document
	 */
	const sDefOddContentBgColor = "#999";
	
	/**
	 *	@todo To document
	 */
	private $_bHeaderBandSet;
	
	/**
	 *	@todo To document
	 */
	private $_bTitleHeaderSet;
	
	/**
	 *	@todo To document
	 */
	private $_bFooterSet;
	
	/**
	 *	@todo To document
	 */
	private $_iContentCount;


	/**
	 *	@todo To document
	 */
	public function __construct($sTitle = "XPiD Library - Paternal Template", $sLanguage = "en")
	{
		parent::__construct($sTitle, self::sDefEncoding, $sLanguage);
		
		$this->_bHeaderBandSet = false;
		
		$this->_bTitleHeaderSet = false;
		
		$this->_bFooterSet = false;
		
		$this->_iContentCount = 0;
		
		$this->_setDefaultStyles();
	}
	
	
	/**
	 *	@todo To document
	 */
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
	
	
	/**
	 *	@todo To document
	 */
	public function SetHeaderBand($vContent = "XPiD Paternal Template", $sColor = self::sDefHeadBandColor)
	{
		$oBand = new CXHDiv($vContent);
		$oBand->AddStyle("background-color", $sColor);
		$oBand->AddStyle("height", "50px");

		parent::AppendContent($oBand);
		
		$this->_bHeaderBandSet = true;
	}
	
	
	/**
	 *	@todo To document
	 */
	public function SetBgColor($sColor)
	{
		$oDoc->AddStyle("background-color", $sColor);
	}
	
	
	/**
	 *	@todo To document
	 */
	public function SetHeadColor($sColor)
	{
		$oDoc->AddContainerStyle("background-color", $sColor);
	}
	
	
	/**
	 *	@todo To document
	 */
	public function SetBorderColor($sColor)
	{
		$oDoc->AddContainerStyle("border-color", $sColor);
	}
	
	
	/**
	 *	@todo To document
	 */
	public function SetBorderWidth($sWidth)
	{
		$oDoc->AddContainerStyle("border-left-width", $sWidth);
		$oDoc->AddContainerStyle("border-right-width", $sWidth);
	}
	
	
	/**
	 *	@todo To document
	 */
	public function AddContentSpace($vContent)
	{
		if ($this->_iContentCount % 2 == 0)
			$sColor = self::sDefEvenContentBgColor;
		else
			$sColor = self::sDefOddContentBgColor;
	
			$oDiv = new CXHDiv($vContent);
			$oDiv->AddStyle("background-color", $sColor);
			$oDiv->AddStyle("height", "587px");

		$this->IntegrateObject($oDiv, XPiDDoc::sClassSpan, 24, false, true);
		
		$this->_iContentCount++;
	}
	

	/**
	 *	@todo To document
	 */
	public function SetTitleHeader($sTitle1 = "XPiD Library", $sColor1 = sDefTitleColor, $sTitle2 = "Paternal Template", $sColor2 = sDefTitleColor)
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

		parent::IntegrateObject($oDiv, XPiDDoc::sClassSpan, 24, false, true);
		
		$this->_bTitleHeaderSet = true;
	}
	
	
	/**
	 *	@todo To document
	 */
	public function SetFooter($vContent = "")
	{
			$oBand = new CXHDiv();
			$oBand->AddStyle("background-color", "#222");
			$oBand->AddStyle("height", "50px");

		$this->IntegrateObject($oBand, XPiDDoc::sClassSpan, 24, false, true);

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

		$this->IntegrateObject($oDiv, XPiDDoc::sClassSpan, 24, false, true);
		
		$this->_bFooterSet = true;
	}
	
	
	/**
	 *	@todo To document
	 */
	public function __toString()
	{
		if (!$this->_bHeaderBandSet)
			$this->SetHeaderBand();
			
		if (!$this->_bTitleHeaderSet)
			$this->SetTitleHeader();
	
		if ($this->_iContentCount == 0)
			$this->AddContentSpace("XPiD Library - Paternal Template");
	
		if (!$this->_bFooterSet)
			$this->SetFooter();
	
		return parent::__toString();
	}
}


/**
 *	@todo To document
 */
class Natural extends XPiDDoc
{
	/**
	 *	@todo To document
	 */
	const sEncoding = 'UTF-8';


	/**
	 *	@todo To document
	 */
	private $_avContent;
	
	
	/**
	 *	@todo To document
	 */
	private $_avSbContent;
	
	
	/**
	 *	@todo To document
	 */
	private $_bContentsSet;
	
	
	/**
	 *	@todo To document
	 */
	public function __construct($sTitle = "XPiD Library - Natural Template", $sLanguage = "en")
	{
		parent::__construct($sTitle, sEncoding, $Language);
		
		$this->_avContent = array();
		$this->_avSbContent = array();
		
		$this->_bContentsSet = false;
	}
	
	
	/**
	 *	@todo To document
	 */
	public function SetContent($avContent)
	{
		$oDiv = new CXHDiv();

		foreach ($avContent as $vContent)
		{
			$oDiv->AppendContent($vContent);
		}

		parent::IntegrateObject($oDiv, XPiDDoc::sClassSpan, 15, true, false);
	}
	
	
	/**
	 *	 @todo To document
	 */
	public function SetSidebarContent($avContent)
	{
		$oDiv = new CXHDiv();

		foreach ($avContent as $vContent)
		{
			$oDiv->AppendContent($vContent);
		}

		parent::IntegrateObject($oDiv, XPiDDoc::sClassSpan, 8, false, true);	
	}
	
	
	/**
	 *	@todo To document
	 */
	public function AppendContent($vContent)
	{
		$this->_avContent[] = $vContent;
	}
	
	
	/**
	 *	@todo To document
	 */
	public function AppendToSidebar($vContent)
	{
		$this->_avSbContent[] = $vContent;
	}
	
	
	/**
	 *	@todo To document
	 */
	public function SetAppendedContents()
	{
		$this->SetContent($this->_avContent);
		
		$this->SetSidebarContent($this->_avSbContent);
		
		$this->_bContentsSet = true;
	}
	

	/**
	 *	@todo To document
	 */
	public function __toString()
	{
		if (!$this->_bContentsSet)
			$this->SetAppendedContents();
	
		return parent::__toString();
	}
}


?>