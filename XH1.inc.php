<?php

/**
 *	The XHTML 1.0 PHPWebLib document generator classes.
 *
 *	@author Serafim Junior Dos Santos Fagundes <serafim@cyb3r.ca>
 *	@copyright Copyright (c) 2010 Serafim Junior Dos Santos Fagundes Cyb3r Networks
 *	@license http://creativecommons.org/licenses/by/3.0/ cc by
 *  
 *	@version 1.0
 *
 *	@package XHTML
 */

include("XH0.inc.php");


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
	 */
	private $_sHead;
	
	
	/**
	 *	@var string String holding the body of the document
	 */
	private $_sBody;
	
	
	/**
	 *	@var string String holding the doctype of the document
	 */
	private $_sDoctype;

	
	/**
	 *	@param string $sLanguage Language abbreviation used in document
	 *	@param int $iType Integer defining the type of document; use type XHTYPE constants; STRICT type is the only one implemented
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
			
		$this->AppendContent($this->_sHead);

		if (!_sl($this->_sBody))
			throw new XHException("Document has no body");

		$this->AppendContent($this->_sBody);

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
	 */
	private $_oHeader;


	/**
	 *	@var object Holds the XHTML document body object
	 */
	private $_oBody;
	
	
	/**
	 *	@var string Holds the content to be appended at the end of the body content
	 */
	private $_sAfterBody;
	
	
	/**
	 *	@param string $sTitle Title of the document
	 *	@param string $sEncoding Encoding of the document; defaults to UTF-8
	 *	@param string $sLanguage Language used in the document; defaults to en: English
	 */
	public function __construct($sTitle = "My PWL Doc", $sEncoding = "UTF-8", $sLanguage = "en")
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