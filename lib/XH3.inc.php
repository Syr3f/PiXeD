<?php


/**
 *
 *	@package [3]XHTMLDocs
 *	@version 0.0.1
 *	@license MIT License
 *
 *	@copyright Copyright (c) 2010 Serafim Junior Dos Santos Fagundes Cyb3r Networks
 *	@author Serafim Junior Dos Santos Fagundes <serafim@cyb3r.ca>
 *
 *
 *	The third level of abstraction of the XPiD Library.
 *	
 *	This file contains the code elements of the third level of abstraction of the XPiD Library.
 *
 *	The idea of this level is to extend the 2th level, .
 */

 
require_once("XH2.inc.php");


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
	 *	@return string
	 */
	public function __toString()
	{
		if (!_sl($this->_sHead))
			throw new XHException("Document has no head");
			
		parent::AppendContent($this->_sHead);

		if (!_sl($this->_sBody))
			throw new XHException("Document has no body");

		parent::AppendContent($this->_sBody);

		return $this->_sDoctype.chr(13).chr(10).parent::__toString();
	}
}




/**
 *	Creates an XHTML document
 */
class CXHDoc extends CXHDocument
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
	public function AppendToHeader($oElement)
	{
		$this->_oHeader->AppendContent($oElement);
	}
	
	
	/**
	 *	Appends content in the body
	 *
	 *	@param mixed $vContent Content to be appended
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
		$this->_oBody->AppendContent($vContent);
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


?>