<?php


/**
 *
 *	@package [4]Docs&Templates
 *	@version 0.0.1
 *	@license MIT License
 *
 *	@copyright Copyright (c) 2010 Serafim Junior Dos Santos Fagundes Cyb3r Networks
 *	@author Serafim Junior Dos Santos Fagundes <serafim@cyb3r.ca>
 *
 *
 *	The fourth level of abstraction of the XPiD Library.
 *	
 *	This file contains the code elements of the fourth level of abstraction of the XPiD Library.
 *
 *	The idea of this level is to extend the 3th level, XHTML blocks and components, and builds an higher level of absctraction for component integration within documents and templates.
 */
 

/**
 *	Links the third level file
 */
require_once("XH3.inc.php");


/**
 *	Creates an XHTML document
 */
class CXH2Doc extends CXHDocument
{
	/**
	 *	@var object Holds the XHTML document head object
	 *	@access private
	 */
	private $_oHeader;


	/**
	 *	@var object Holds the XHTML document body object
	 *	@access private
	 */
	private $_oBody;
	
	
	/**
	 *	@var string Holds the content to be appended at the end of the body content
	 *	@access private
	 */
	private $_sAfterBody;
	
	
	/**
	 *	@param string $sTitle Title of the document
	 *	@param string $sEncoding Encoding of the document; defaults to UTF-8
	 *	@param string $sLanguage Language used in the document; defaults to en: English
	 */
	public function __construct($sTitle = "My XHTML Document", $sEncoding = "UTF-8", $sLanguage = "en")
	{
		parent::__construct($sLanguage);
		
		$this->_oHeader = new CXHHead($sEncoding, $sTitle);
		$this->_oBody = new CXHBody();
		
		$this->_sAfterBody = "";
	}
	
	
	/**
	 *	Appends an XHTML element to the head of the document
	 *
	 *	@param object $oElement Element to be appended to the head document
	 */
	public function AppendToHead($oElement)
	{
		$this->_oHeader->AppendContent($oElement);
	}
	
	
	/**
	 *	Appends content in the body
	 *
	 *	@param mixed $vContent Content to be appended
	 *	@todo Switch method content with AppendContent
	 */
	public function AppendToBody($vContent)
	{
		$this->_oBody->AppendContent($vContent);
	}
	
	
	/**
	 *	Add a style to the document body
	 *
	 *	@param string $sName Style name to be attributed to the document body
	 *	@param string $sStyle Style value to be attributed to the document body
	 */
	public function AddStyle($sName, $sStyle)
	{
		$this->_oBody->AddStyle($sName, $sStyle);
	}
	
	
	/**
	 *	Sets the class value of the document body
	 *
	 *	@param string $sClass Class string to be attributed to the document body
	 */
	public function SetClass($sClass)
	{
		$this->_oBody->SetClass($sClass);
	}
	
	
	/**
	 *	Sets the id of the document body
	 *
	 *	@param string $sId Id value to be attributed to the document body
	 */
	public function SetId($sId)
	{
		$this->_oBody->SetId($sId);
	}
	
	
	/**
	 *	Appends content to the body
	 *
	 *	@param mixed $vContent Content to be appended
	 */
	public function AppendContent($vContent)
	{
		$this->AppendToBody($vContent);
	}
	
	
	/**
	 *	Appends elements and strings at the end of the body
	 *
	 *	@param mixed $vContent Content to be appended
	 */
	public function AppendAtEnd($vContent)
	{
		switch (getType($vContent))
		{
			case "object":
				if (_io($vContent, 'CXHEntityAttrs'))
				{
					$this->_sAfterBody .= (string) $vContent;
				}
				break;
			case "string":
				$this->_sAfterBody .= $vContent;
				break;
		}
	}
	
	/**
	 *	Sets the document onload event
	 *
	 *	@param string $sEvent Event to be called on document load
	 */
	public function SetOnloadEvent($sEvent)
	{
		$this->_oBody->AddEvent("onload", $sEvent);
	}
	
	
	/**
	 *	@return string
	 */
	public function __toString()
	{
		$this->ReplaceHead($this->_oHeader);
		
		$sBody = (string) $this->_oBody;
		
		$this->ReplaceBody($sBody.$this->_sAfterBody);
	
		return parent::__toString();
	}
}


/**
 *	Creates a document with default style and Blueprint grid mechanism
 */
class CBpDoc extends CXH2Doc
{
	/**
	 *	@var array Top band content element array
	 *	@access private
	 */
	private $_avTopBandContents;


	/**
	 *	@var array Header content element array
	 *	@access private
	 */
	private $_avHeaderContents;


	/**
	 *	@var array Main content element array
	 *	@access private
	 */
	private $_avMainContents;


	/**
	 *	@param string $sTitle Title of the document
	 *	@param string $sLanguage Language of the document
	 */
	public function __construct($sTitle = "Blueprint Document", $sLanguage = "en")
	{
		parent::__construct($sTitle, "UTF-8", $sLanguage);

		$this->_avTopBandContents = array();
		$this->_avHeaderContents = array();
		$this->_avMainContents = array();
		
			$oCSS = new CXHCSS(CSS_BLUEPRINT_RESET);
		
		parent::AppendToHead($oCSS);

			$oCSS = new CXHCSS(CSS_BLUEPRINT_GRID);
		
		parent::AppendToHead($oCSS);

			$oCSS = new CXHCSS(CSS_BLUEPRINT_TYPO);
		
		parent::AppendToHead($oCSS);

		if ($this->_isIE())
		{
				$oCSS = new CXHCSS(CSS_BLUEPRINT_IE);
		
			parent::AppendToHead($oCSS);
		}

		parent::AddStyle("font-family", "Georgia, serif");
		
		parent::AddStyle("background", "#4cd04c url(".LIBBASEURL."/lib/images/bg-g.jpg) repeat-x scroll center top");
	}
	
	
	/**
	 *	Tells if browser is Internet Explorer
	 *	@return bool
	 *	@access private
	 */
	public function _isIE()
	{
		$sUA = $_SERVER['HTTP_USER_AGENT'];
		
		return (preg_match('/msie/', $userAgent) ? true : false);
	}
	
	
	/**
	 *	Appends elements to top band
	 *
	 *	Top band height is 50 pixels
	 *
	 *	@param mixed $vContent Element to be appended
	 */
	public function AppendTopBand($vContent)
	{
		$this->_avTopBandContents[] = $vContent;
	}


	/**
	 *	Appends elements to page header
	 *
	 *	Header height is 224 pixels
	 *
	 *	@param mixed $vContent Element to be appended
	 */
	public function AppendToHeader($vContent)
	{
		$this->_avHeaderContents[] = $vContent;
	}
	
	
	/**
	 *	Appends elements to page main content container
	 *
	 *	@param mixed $vContent Element to be appended
	 */
	public function AppendContent($vContent)
	{
		$this->_avMainContents[] = $vContent;
	}
	
	
	/**
	 *	@return string
	 */
	public function __toString()
	{
		/*
		 *	Container class width is 950 pixels
		 */
		$oDiv = new CXHDiv();
		$oDiv->SetClass("container");
		
		foreach ($this->_avTopBandContents as $vContent)
		{
			$vContent->AddStyle("height", "48px");
			$oDiv->AppendContent($vContent);
		}

		foreach ($this->_avHeaderContents as $vContent)
		{
			$vContent->AddStyle("height", "218px");
			$oDiv->AppendContent($vContent);
		}
		
		foreach ($this->_avMainContents as $vContent)
		{
			$oDiv->AppendContent($vContent);
		}
		
		parent::AppendContent($oDiv);
		
		return parent::__toString();
	}
}


















/**
 *	Creates a document with default style and Blueprint grid.
 */
class XH3BpDoc extends CXH2Doc
{
	/**
	 *	@todo To document
	 */
	const sClassSpan = 'span';


	/**
	 *	@todo To document
	 */
	const sClassAppend = 'append';


	/**
	 *	@todo To document
	 */
	const sClassPrepend = 'prepend';

	
	/**
	 *	@todo To document
	 */
	const sClassPull = 'pull';


	/**
	 *	@todo To document
	 */
	const sClassPush = 'push';


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
	public function __construct($sTitle = "My Blueprint Document", $sEncoding = "UTF-8", $sLanguage = "en")
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
		
		parent::AppendToHead($oCSS);

			$oCSS = new CXHCSS(CSS_BLUEPRINT_PRINT, "print");
		
		parent::AppendToHead($oCSS);

		if ($this->_isIE())
		{
				$oCSS = new CXHCSS(CSS_BLUEPRINT_IE);
		
			parent::AppendToHead($oCSS);
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
			case self::sClassSpan:
			case self::sClassAppend:
			case self::sClassPrepend:
				if ($this->_iRowColCount > self::iMaxCols)
					throw new XHException("Column ".$csClassType." is above the grid limit of ".self::iMaxCols." (".$this->iRowColCount.")");
			break;
			case self::sClassPull:
				if ($iCols > self::iMaxPull)
					throw new XHException("Column pull is above the limit of ".self::iMaxPull." (".$iCols.")");
			break;
			case self::sClassPush:
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


/**
 *	@todo To document
 */
class Maternal extends XH3BpDoc
{
	/**
	 *	@todo To document
	 */
	public function __construct($sTitle = "Maternal Template", $sLanguage = "en")
	{
		parent::__construct($sTitle, "UTF-8", $sLanguage);
		
		parent::AddStyle("font-family", "Georgia");
		parent::AddStyle("background", "#4cd04c url(".LIBBASEURL."/lib/images/bg-g.jpg) repeat-x scroll center top");

	}
	
	
	/**
	 *	@todo To document
	 */
	public function SetTopBand($vContent = PXH_EMPTY_STRING)
	{
		$oContent = new CXHDiv();
		$oContent->AddStyle("height", "50px");
		
		$oContent->AppendContent($vContent);
			
		parent::ContainerAppend($oContent);
	}
	

	/**
	 *	@todo To document
	 */
	public function SetHeader($vContent = PXH_EMPTY_STRING)
	{
			$oContent = new CXHDiv();
			$oContent->AddStyle("height", "224px");
			$oContent->AddStyle("vertical-align", "middle");

				$vContent = parent::AdaptObject($vContent, XH3BpDoc::sClassSpan, 24, false, true);
			
			$oContent->AppendContent($vContent);
		
		parent::ContainerAppend($oContent);
	}
	
	
	/**
	 *	@todo To document
	 */
	public function SetContent($vContent)
	{
			$oContent = new CXHDiv();
								
				$vContent = parent::AdaptObject($vContent, XH3BpDoc::sClassSpan, 24, false, true);
				
			$oContent->AppendContent($vContent);
			
		parent::ContainerAppend($oContent);
	}
	
	
	/**
	 *	@todo To document
	 */
	public function __toString()
	{
		return parent::__toString();
	}
}


/**
 *	@todo To document
 */
class Paternal extends XH3BpDoc
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

		$this->IntegrateObject($oDiv, XH3BpDoc::sClassSpan, 24, false, true);
		
		$this->_iContentCount++;
	}
	

	/**
	 *	@todo To document
	 */
	public function SetTitleHeader($sTitle1 = "XPiD Library", $sTitle2 = "Paternal Template", $sColor1 = sDefTitleColor, $sColor2 = sDefTitleColor)
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

		parent::IntegrateObject($oDiv, XH3BpDoc::sClassSpan, 24, false, true);
		
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

		$this->IntegrateObject($oBand, XH3BpDoc::sClassSpan, 24, false, true);

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

		$this->IntegrateObject($oDiv, XH3BpDoc::sClassSpan, 24, false, true);
		
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
class Natural extends XH3BpDoc
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

		parent::IntegrateObject($oDiv, XH3BpDoc::sClassSpan, 15, true, false);
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

		parent::IntegrateObject($oDiv, XH3BpDoc::sClassSpan, 8, false, true);	
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