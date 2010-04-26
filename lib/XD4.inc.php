<?php


/**
 *
 *	@package XD[4]XHTML-Blocks
 *	@version 0.1
 *	@license MIT License
 *
 *	@copyright Copyright (c) 2010 Serafim Junior Dos Santos Fagundes Cyb3r Network
 *	@author Serafim Junior Dos Santos Fagundes <serafim@cyb3r.ca>
 *
 *
 *	The fourth level of abstraction of the XD Library.
 *	
 *	This file contains the code elements of the fourth level of abstraction of the XD Library.
 *
 *	The idea of this level is to extend the 3th level, XHTML entities, and builds an higher level of absctraction for component integration within documents and templates. It generally contains combinations or extentions of XD3 XHTML entities.
 */
 
 
/**
 *	Links the third level file
 */
require_once("XD3.inc.php");



define("XHTYPE_XHTML_1_0_STRICT",1);
define("XHTYPE_XHTML_1_0_TRANS", 2);
define("XHTYPE_XHTML_1_0_FRAMS", 3);


/**
 *	Creates a XHTML document structure
 */
class CXHDocument extends CXHHTML
{
	/**
	 *	@var string String holding the head of the document
	 *	@access private
	 */
	private $_sHead;
	
	
	/**
	 *	@var string String holding the body of the document
	 *	@access private
	 */
	private $_sBody;
	
	
	/**
	 *	@var string String holding the doctype of the document
	 *	@access private
	 */
	private $_sDoctype;

	
	/**
	 *	@param string $sLanguage Language abbreviation used in document
	 *	@param int $iType Type of the document; defaults to XHTML strict, only implementation
	 */
	public function __construct($sLanguage, $iType = XHTYPE_XHTML_1_0_STRICT)
	{
		parent::__construct($sLanguage);

		self::_Create($iType);
	}


	/**
	 *	Creates the internal necessities of the class
	 *	@access protected
	 *
	 *	@param int $iType Type of the document; defaults to XHTML strict, only implementation
	 */
	protected function _Create($iType)
	{
		$this->_sHead = "";
		$this->_sBody = "";

		switch ($iType)
		{
			case XHTYPE_XHTML_1_0_FRAMS:
			//break;
			case XHTYPE_XHTML_1_0_TRANS:
			//	$this->_sDoctype = "<!DOCTYPE html PUBLIC ".chr(13).chr(10).chr(9).chr(34)."-//W3C//DTD XHTML 1.0 Transitional//EN".chr(34).chr(13).chr(10).chr(9).chr(34)."http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd".chr(34).">";
			//break;
			case XHTYPE_XHTML_1_0_STRICT:
			//break;
			default:
				$this->_sDoctype = "<!DOCTYPE html PUBLIC ".chr(13).chr(10).chr(9).chr(34)."-//W3C//DTD XHTML 1.0 Strict//EN".chr(34).chr(13).chr(10).chr(9).chr(34)."http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd".chr(34).">";
		}
	}


	/**
	 *	Sets the head of the XHTML document
	 *
	 *	@param mixed $vHead Head string or object for the XHTML document
	 */
	public function ReplaceHead($vHead)
	{
		switch (getType($vHead))
		{
			case "object":
				if (_io($vHead, 'CXHHead'))
				{
					$this->_sHead = (string) $vHead;
				}
				break;
			case "string":
				$this->_sHead = $vHead;
				break;
			default:
				throw new XHException("\$vHead is not of type CXHHead");

		}
	}


	/**
	 *	Sets the body to the XHTML document
	 *
	 *	@param mixed $vBody Body string or object for the XHTML document
	 */
	public function ReplaceBody($vBody)
	{
		switch (getType($vBody))
		{
			case "object":

				if (_io($vBody, 'CXHBody'))
				{
					$this->_sBody = (string) $vBody;
				}

				break;
			case "string":
				$this->_sBody = $vBody;
				break;
			default:
				throw new XHException("\$vBody is not of type CXHBody");

		}
	}
	
	
	/**
	 *	Generates markup
	 *
	 *	@return string
	 */
	protected function _Generate()
	{
		if (!_sl($this->_sHead))
			throw new XHException("Document has no head");
			
		parent::AppendContent($this->_sHead);

		if (!_sl($this->_sBody))
			throw new XHException("Document has no body");

		parent::AppendContent($this->_sBody);

		return $this->_sDoctype.chr(13).chr(10).parent::__toString();
	}


	/**
	 *	@return string
	 */
	public function __toString()
	{
		return self::_Generate();
	}
}



/**
 *	Creates an XHTML document. Eases the XHTML document generation by extending the CXHDocument class.
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
		
		self::_Create($sTitle, $sEncoding);
	}


	/**
	 *	Builds the internal necessities of the class
	 *	@access protected
	 *
	 *	@param string $sTitle Title of the document
	 *	@param string $sEncoding Encoding of the document; defaults to UTF-8
	 */
	protected function _Create($sTitle, $sEncoding)
	{
		$this->_oHeader = new CXH2Head($sEncoding, $sTitle);
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
	 *	Generates markup
	 *
	 *	@return string
	 */
	protected function _Generate()
	{
		$this->ReplaceHead($this->_oHeader);
		
		$sBody = (string) $this->_oBody;
		
		$this->ReplaceBody($sBody.$this->_sAfterBody);
	
		return parent::__toString();
	}
	
	/**
	 *	@return string
	 */
	public function __toString()
	{
		return self::_Generate();
	}
}


/**
 *	Creates a head element.
 *
 *	The head element contains information about the current document, such as its title, keywords that may be useful to search engines, and other data that is not considered to be document content. This information is usually not displayed by browsers.
 */
class CXH2Head extends CXHEntityIntl
{
	/**
	 *	@param string $sEncoding Encoding of the document
	 *	@param string $sTitle Title of the document
	 *	@param string $sBaseHref Base URI of the document
	 */
	public function __construct($sEncoding, $sTitle = PXH_EMPTY_STRING, $sBaseHref = PXH_EMPTY_STRING)
	{
		parent::__construct("head");

		$oTitle = new CXHTitle($sTitle);

		$this->AppendContent($oTitle);

		if (_sl($sBaseHref))
		{
			$oBase = new CMLEntity("base", false);
			$oBase->AddAttr("href", $sBaseHref);

			$this->AppendContent($oBase);
		}
		
		$oEncoding = new CXHMeta("Content-Type", PXH_EMPTY_STRING, "text/html;charset=".$sEncoding);		
		
		$this->AppendContent($oEncoding);
	}
}


/**
 *	Creates a link or a style element.
 *
 *	The link element conveys relationship information that can be used by Web browsers and search engines. You can have multiple link elements that link to different resources or describe different relationships. The link elements can be contained in the head element.
 *	The style element can contain CSS rules (called embedded CSS) or a URL that leads to a file containing CSS rules (called external CSS).
 */
class CXH2CSS extends CXHEntityIntl
{
	/**
	 *	@param string $sFileURL URL reference of the style sheet
	 *	@param string $sMedia Intended destination of the referenced link or content
	 */
	public function __construct($sFileURL = PXH_EMPTY_STRING, $sMedia = "screen")
	{
		if (_sl($sFileURL))
		{
			parent::__construct("link", false);
		}
		else
		{
			parent::__construct("style");
		}
		
		$this->AddAttr("media", $sMedia);
		$this->AddAttr("type", "text/css");
		
		if (_sl($sFileURL))
		{
			$this->AddAttr("href", $sFileURL);
			$this->AddAttr("rel", "stylesheet");
		}
	}


	/**
	 *	Adds the content of the referenced file in the style entity content
	 *
	 *	@param string $sFileName File reference of the style content
	 */
	public function AddFileContent($sFileName)
	{
		ob_start();
		
			include($sFileName);
		
			$sCode = ob_get_contents();
			
		ob_end_clean();
		
		parent::AppendContent($sCode);
	}
}



/**
 *	Creates a table element
 *
 *	The CXH2TableBlock generates a table element and manages most of the table elements for its generation. The goal of this implementation is to ease the table implementation with XD and its diverse parts for less code management and reading.
 *
 *	@todo To test[3]
 */
class CXH2TableBlock extends CXHTable
{
	/**
	 *	@var int Head part of the table
	 */
	const iHead = 1;


	/**
	 *	@var int Body part of the table
	 */
	const iBody = 2;


	/**
	 *	@var int Foot part of the table
	 */
	const iFoot = 3;
	
	
	/**
	 *	@var array Holds the table body array
	 *	@access private
	 */
	private $_aTBody2;
	
	
	/**
	 *	@var object Holds the current table body index
	 *	@access private
	 */
	private $_iCurrentBody;
	
	
	/**
	 *	@var object Holds the current table head object
	 *	@access private
	 */
	private $_oTHead2;
	
	
	/**
	 *	@var object Holds the current table foot object
	 *	@access private
	 */
	private $_oTFoot2;
	
	
	/**
	 *	@var object Holds the current row object
	 *	@access private
	 */
	private $_oCurrentRow;
	
	
	/**
	 *	@var object Holds the current cell object
	 *	@access private
	 */
	private $_oCurrentCell;
	
	
	/**
	 *	@var bool Indicates if content has been appended to current cell
	 *	@access private
	 */
	private $_bAppendToCell;
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->_aTBody = array();
		
		$this->_iCurrentBody = 0;
		
		$this->_oTHead2 = PXH_NULL_OBJECT;
		$this->_aTBody2[] = new CXHTableBody();
		$this->_oTFoot2 = PXH_NULL_OBJECT;
		
		$this->_oCurrentRow = new CXHRow();
		
		$this->_oCurrentCell = new CXHCell();
		
		$this->_bAppendToCell = false;
	}

	
	/**
	 *	Generates a new body table part
	 */
	public function NewBody()
	{
		$this->AppendRowToPart(self::iBody);
	
		$this->_aTBody2[] = new CXHTableBody();
		
		$this->_iCurrentBody++;
	}
	
	
	/**
	 *	Appends the current cell to current row and current row to table part and generates a new current row and a new current cell
	 *
	 *	@param int $ciPart Constant class identifying the table part which the current row will be added
	 *	@param object $oCell Cell to be appended to the current row previous to its addition to the table part
	 */
	public function GenerateRow($ciPart, $oCell = PXH_NULL_OBJECT)
	{
		if (!_in($oCell))
			$this->AppendToRow($oCell);
		else
			$this->AppendToRow($this->_oCurrentCell);
			
		$this->AppendRowToPart($ciPart, $this->_oCurrentRow);
		
		$this->_oCurrentRow = new CXHRow();
		
		$this->_oCurrentCell = new CXHCell();
		
		$this->_bAppendToCell = false;
	}
	
	
	/**
	 *	Appends current cell or given cell to the current row
	 *
	 *	@param object $oCell Cell to be appended to the current row
	 */
	public function AppendToRow($oCell = PXH_NULL_OBJECT)
	{
		if (!_in($oCell))
			$this->_oCurrentCell = $oCell;
	
		$this->_oCurrentRow->AppendContent($this->_oCurrentCell);
		
		$this->_oCurrentCell = new CXHCell();
		
		$this->_bAppendToCell = false;
	}
	
	
	/**
	 *	Appends content to the current cell
	 *
	 *	@param mixed $vContent Content to be appended to current cell
	 */
	public function AppendToCell($vContent)
	{
		$this->_oCurrentCell->AppendContent($vContent);
		
		$this->_bAppendToCell = true;
	}
	
	
	/**
	 *	Appends current row or given row to the table part
	 *
	 *	@param object $oRow Row to be appended to the table part
	 *	@param int $ciPart Class constant identifying the table part
	 */
	public function AppendRowToPart($ciPart, $oRow = PXH_NULL_OBJECT)
	{
		if (!_in($oRow))
			$this->_oCurrentRow = $oRow;
					
		if ($this->_bAppendToCell)
			$this->AppendToRow();
			
		switch ($ciPart)
		{
			case self::iHead:
				if ($this->_oTHead2 == PXH_NULL_OBJECT)
					$this->_oTHead2 = new CXHTableHead();
				
				$this->_oTHead2->AppendContent($this->_oCurrentRow);
			break;
			case self::iBody:
				$this->_aTBody2[$this->_iCurrentBody]->AppendContent($this->_oCurrentRow);
			break;
			case self::iFoot:
				if ($this->_oTFoot2 == PXH_NULL_OBJECT)
					$this->_oTFoot2 = new CXHTableFoot();
				
				$this->_oTFoot2->AppendContent($this->_oCurrentRow);
			break;
			default:
				throw new XHException("Part value is not valid");
		}
	}
	
	
	/**
	 *	Appends content to the table
	 *
	 *	@param mixed $vContent Content to be appended to the table
	 */
	public function AppendContent($vContent)
	{
		if (_io($vContent, 'CXHCell'))
			$this->_oCurrentRow->AppendContent($oCell);
		else
			parent::AppendContent($vContent);
	}
	 
	
	/**
	 *	Generates markup
	 *
	 *	@return string
	 */
	protected function _Generate()
	{
		if ($this->_oTHead2 != PXH_NULL_OBJECT)
			parent::AppendBody($this->_oTHead2);
	
		if ($this->_oTFoot2 != PXH_NULL_OBJECT)
			parent::AppendBody($this->_oTFoot2);
		
		foreach ($this->_aTBody2 as $oTBody)
			parent::AppendBody($oTBody);
	
		return parent::__toString();
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