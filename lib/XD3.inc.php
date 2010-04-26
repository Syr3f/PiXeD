<?php

/**
 *
 *	@package XD[3]XHTML-Entities
 *	@version 0.1
 *	@license MIT License
 *
 *	@copyright Copyright (c) 2010 Serafim Junior Dos Santos Fagundes Cyb3r Network
 *	@author Serafim Junior Dos Santos Fagundes <serafim@cyb3r.ca>
 *
 *
 *	The third level of abstraction of the XD Library.
 *	
 *	This file contains the code elements of the third level of abstraction of the XD Library.
 *
 *	The idea of this level is to extend the 2th level of the XD library, XHTML base entity definitions, to allow existence and support of the XHTML entity classes/objects. It defines XHTML markup entities as defined in the strict DTD of the XHTML specification of the W3C recommendation available at the http://www.w3.org/TR/xhtml1/.
 *
 *	The terms element and entity are interchangibly used to mean a DTD declared entity for the XHTML document.
 *
 *	Some of the class documentation is taken from the xhtml.com website: http://xhtml.com/.
 */


/**
 *	Links the second level file
 */
require_once("XD2.inc.php");


/**
 *  Creates an HTML/XHTML comment
 */
class CXHComment extends CMLObject
{
	/**
	 *	@var string Holds the comment content
	 *	@access private
	 */
	private $_sContent;
	
	
	/**
	 *	@var string Holds the new line caracters
	 *	@access private
	 */
	private $sNL;
	
	
	/**
	 *	@var string Holds the tab caracter
	 *	@access private
	 */
	private $sTAB;


	/**
	 *	@param string $sContent String passed as the initial content of the class
	 */
	public function __construct($sContent = "")
	{
		self::_Create($sContent);
	}
	
	
	/**
	 *	@param string $sContent String passed as the initial content of the class
	 */
	protected function _Create($sContent)
	{
		$this->sNL = chr(13).chr(10);
		$this->sTAB = chr(9);
		
		if (strlen($sContent) > 0)
			$this->_sContent = $this->sNL.$this->sTAB.$sContent;
	}


	/**
	 *	Adds a comment line
	 *
	 *	@param string $sContent Text to be added in the comment
	 */
	public function AddLine($sContent)
	{
		$this->_sContent .= $this->sNL.$this->sTAB.$sContent;
	}
	
	
	/**
	 *	Generates the comment
	 *
	 *	@return string
	 */
	protected function _Generate()
	{
		$sML = $this->sNL."<!--".$this->_sContent.$this->sNL."//-->".$this->sNL;

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



# <!--================ Document Structure ==================================-->

##
#
# <!ELEMENT html (head, body)>
# <!ATTLIST html
#   %i18n
#   xmlns       CDATA          #FIXED 'http://www.w3.org/1999/xhtml'
#   >
/**
 *	Creates a html element.
 *
 *	The html element is the root element that contains all other elements. It must appear only once and usually follows the document declaration.
 */
class CXHHTML extends CXHEntityIntl
{
	/**
	 *	@param string $sLang Language of the html entity content
	 */
	public function __construct($sLang)
	{
		parent::__construct("html");
		
		$this->SetLang($sLang);
		
		$this->AddAttr("xmlns", "http://www.w3.org/1999/xhtml");
	}
}


# <!--================ Document Head =======================================-->

##
#
# <!ELEMENT head 	(%head.misc;,
#							(
#								(
#									title, %head.misc;,
#									(base, %head.misc;)?
#								) | (
#										base, %head.misc;,
#										(title, %head.misc;)
#									)
#							)
#					)>
##
#
# <!ATTLIST head
#   %i18n
#   profile     CDATA          #IMPLIED
#   >
/**
 *	Creates a head element.
 *
 *	The head element contains information about the current document, such as its title, keywords that may be useful to search engines, and other data that is not considered to be document content. This information is usually not displayed by browsers.
 */
class CXHHead extends CXHEntityIntl
{
	/**
	 *	@param string $sProfile Profile of comma separated URIs for link and meta references
	 */
	public function __construct($sProfile = PXH_EMPTY_STRING)
	{
		parent::__construct("head");
		
		if (_sl($sProfile))
			$this->SetProfile($sProfile);
	}
	
	
	/**
	 *	Sets the profile attribute
	 *
	 *	@param string $sProfile Profile of comma separated URIs for link and meta references
	 */
	public function SetProfile($sProfile)
	{
		parent::AddAttr("profile", $sProfile);
	}
}


##
#
# <!ELEMENT title (#PCDATA)>
# <!ATTLIST title %i18n>
##
/**
 *	Creates a title element.
 *
 *	The title element is used to identify the document.
 */
class CXHTitle extends CMLEntity
{
	/**
	 *	@param string $sTitle Title of the document
	 */
	public function __construct($sTitle = PXH_EMPTY_STRING)
	{
		parent::__construct("title", true, $sTitle);
	}
	
	
	/**
	 *	@param string $sContent Content of the title entity; Title of the document
	 */
	public function AppendContent($sContent)
	{
		parent::ReplaceContent($sContent);
	}
}


#
# <!ELEMENT base EMPTY>
# <!ATTLIST base
#   href        CDATA          #IMPLIED
#   >
/**
 *	Creates a base element.
 *
 *	To resolve relative URLs, Web browsers will use the base URL from where the Web page was downloaded. In some circumstances, it is necessary to instruct the Web browser to use a different base URL, in which case the base element is used.
 *	@todo To test
 */
class CXHBase extends CMLEntity
{
	/**
	 *	@param string $sBaseHref Base URL for relative paths references
	 */
	public function __construct($sBaseHref)
	{
		parent::__construct("base");
		
		parent::AddAttr("href", $sBaseHref);
	}
}


##
#
# <!ELEMENT meta EMPTY>
# <!ATTLIST meta
#   %i18n
#   http-equiv  CDATA          #IMPLIED
#   name        CDATA          #IMPLIED
#   content     CDATA          #REQUIRED
#   scheme      CDATA          #IMPLIED
#   >
/**
 *	Creates a meta element.
 *
 *	The meta element is a generic mechanism for specifying metadata for a Web page. Some search engines use this information.
 */
class CXHMeta extends CXHEntityIntl
{
	/**
	 *	@param string $sHttpEquiv HTTP header name; Used in place of the $sName parameter
	 *	@param string $sName Name of the meta information
	 *	@param string $sContent Value of the HTTP-quiv or name parameter
	 */
	public function __construct($sHttpEquiv = PXH_EMPTY_STRING, $sName = PXH_EMPTY_STRING, $sContent = PXH_EMPTY_STRING)
	{
		parent::__construct("meta", false);
		
		if (_sl($sHttpEquiv))
			$this->SetHTTPEquiv($sHttpEquiv);
			
		if (_sl($sName))
			$this->SetName($sName);
			
		if (_sl($sContent))
			$this->SetContent($sContent);
	}
	
	
	/**
	 *	@param string $sHttpEquiv HTTP header name; Used in place of the $sName parameter
	 */
	public function SetHTTPEquiv($sHttpEquiv)
	{
		$this->AddAttr("http-equiv", $sHttpEquiv);
	}
	
	
	/**
	 *	@param string $sName Name of the meta information
	 */
	public function SetName($sName)
	{
		$this->AddAttr("name", $sName);
	}
	
	
	/**
	 *	@param string $sContent Value of the HTTP-quiv or name parameter
	 */
	public function SetContent($sContent)
	{
		$this->AddAttr("content", $sContent);
	}
	
	
	/**
	 *	@param string $sScheme Scheme name of the property's value to be interpreted
	 */
	public function SetScheme($sScheme)
	{
		$this->AddAttr("scheme", $sScheme);
	}
}


##
#
# <!ELEMENT link EMPTY>
# <!ATTLIST link
#   %attrs
#   charset     CDATA    #IMPLIED
#   href        CDATA    #IMPLIED
#   hreflang    CDATA    #IMPLIED
#   type        CDATA    #IMPLIED
#   rel         CDATA    #IMPLIED
#   rev         CDATA    #IMPLIED
#   media       CDATA    #IMPLIED
#   >
/**
 *	Creates a link element.
 *
 *	The link element conveys relationship information that can be used by Web browsers and search engines. You can have multiple link elements that link to different resources or describe different relationships. The link elements can be contained in the head element.
 */
class CXHLink extends CXHEntityAttrs
{
	/**
	 *	@param string $sHref Location of a Web ressource
	 *	@param string $sType Type of the link
	 *	@param string $sRel Relationship of the Web ressource to the document
	 */
	public function __construct($sHref, $sType, $sRel)
	{
		parent::__construct("link", false);
		
		$this->AddAttr("href", $sHref);
		$this->AddAttr("type", $sType);
		$this->AddAttr("rel", $sRel);
	}
}


##
#
# <!ELEMENT style (#PCDATA)>
# <!ATTLIST style
#   %i18n
#   type        CDATA  #REQUIRED
#   media       CDATA    #IMPLIED
#   title       CDATA         #IMPLIED
#   xml:space   (preserve)     #FIXED 'preserve'
#   >
/**
 *	Creates a style element.
 *
 *	The style element can contain CSS rules (called embedded CSS) or a URL that leads to a file containing CSS rules (called external CSS).
 *	@todo To test
 */
class CXHStyle extends CXHEntityIntl
{
	/**
	 *	@param string $sType Type of style
	 *	@param string $sMedia Media target of the style
	 *	@param string $sTitle Title of the entity
	 */
	public function __construct($sType = PXH_EMPTY_STRING, $sMedia = PXH_EMPTY_STRING, $sTitle = PXH_EMPTY_STRING)
	{
		parent::__construct("style");
		
		if (_sl($sType))
			$this->SetType($sType);
		
		if (_sl($sMedia))
			$this->SetMedia($sMedia);
			
		if (_sl($sTitle))
			$this->SetTitle($sTitle);
	}
	
	
	/**
	 *	@param string $sType Type of style
	 */
	public function SetType($sType)
	{
		parent::AddAttr("type", $sType);
	}
	
	
	/**
	 *	@param string $sMedia Media target of the style
	 */
	public function SetMedia($sMedia)
	{
		parent::AddAttr("media", $sMedia);
	}
	
	
	/**
	 *	@param string $sTitle Title of the entity
	 */
	public function SetTitle($sTitle)
	{
		parent::AddAttr("title", $sTitle);
	}
}


##
#
# <!ELEMENT script (#PCDATA)>
# <!ATTLIST script
#   charset     CDATA      #IMPLIED
#   type        CDATA  #REQUIRED
#   src         CDATA          #IMPLIED
#   defer       (defer)        #IMPLIED
#   xml:space   (preserve)     #FIXED 'preserve'
#   >
/**
 *	Creates a script element.
 *
 *	The script element places a client-side script, such as JavaScript, within a document. This element may appear any number of times in the head or body of a Web page. The script element may contain a script (called an embedded script) or point via the src attribute to a file containing a script (an external script).
 */
class CXHScript extends CMLEntity
{
	/**
	 *	@param string $sScriptLanguage Language of the script entity
	 *	@param string $sFileURL File reference of the script entity
	 */
	public function __construct($sScriptLanguage, $sFileURL = PXH_EMPTY_STRING)
	{
		parent::__construct("script");
		
		$this->AddAttr("type", "text/".$sScriptLanguage);
		$this->AddAttr("language", $sScriptLanguage);
		
		if (_sl($sFileURL))
		{
			$this->AddAttr("src", $sFileURL);
		}
	}


	/**
	 *	Adds the file content to the script entity
	 *
	 *	@param string $sFileName File reference of the script
	 */
	public function AddFileContent($sFileName)
	{
		ob_start();

			include($sFileName);
		
			$sCode = $this->sNL.$this->sTAB."//<![CDATA[".$this->sNL.ob_get_contents().$this->sNL.$this->sTAB."//]]>";
			
		ob_end_clean();
		
		parent::AppendContent($sCode);
	}
}


##
#
# <!ELEMENT noscript %Block;>
# <!ATTLIST noscript
#   %attrs
#   >
/**
 *	Creates a noscript element.
 *
 *	The noscript element allows authors to provide alternate content when a script is not executed. This can be because the Web browser is configured not to process scripts, or because the given script language is not supported.
 */
class CXHNoScript extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Content of the noscript entity
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("noscript");
		
		if (_sl((string) $vContent))
			parent::AppendContent($vContent);
		else
			parent::AppendContent("This document uses a script. If you see this message it means that your user agent/browser doesn't run scripts and this document may not render as appropriate. Please enable scripts or use a user agent/browser that has scripting functionality enabled.");
	}
}
# <!--=================== Document Body ====================================-->

##
#
# <!ELEMENT body %Block;>
# <!ATTLIST body
#   %attrs
#   onload          CDATA   #IMPLIED
#   onunload        CDATA   #IMPLIED
#   >
/**
 *	Creates a body element.
 *
 *	The body element contains the contents of a Web page.
 */
class CXHBody extends CXHEntityAttrs
{
	public function __construct()
	{
		parent::__construct("body");
	}
}


##
#
# <!ELEMENT div %Flow;>  <!-- generic language/style container -->
# <!ATTLIST div
#   %attrs
#   >
/**
 *	Creates a div element.
 *
 *	The div element offers a generic way of grouping areas of content.
 */
class CXHDiv extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Content of the div entity
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("div", true, $vContent);
	}
}


# <!--=================== Paragraphs =======================================-->

##
#
# <!ELEMENT p %Inline;>
# <!ATTLIST p
#   %attrs
#   >
/**
 *	Creates a p element.
 *
 *	The p element represents a paragraph.
 */
class CXHParagraph extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Content of the p entity
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("p", true, $vContent);
	}
}

# <!--=================== Headings =========================================-->

##
#
# <!ELEMENT h1  %Inline;>
# <!ATTLIST h1
#    %attrs
#    >
##
#
# <!ELEMENT h2 %Inline;>
# <!ATTLIST h2
#    %attrs
#    >
##
#
# <!ELEMENT h3 %Inline;>
# <!ATTLIST h3
#    %attrs
#    >
##
#
# <!ELEMENT h4 %Inline;>
# <!ATTLIST h4
#    %attrs
#    >
##
#
# <!ELEMENT h5 %Inline;>
# <!ATTLIST h5
#    %attrs
#    >
##
#
# <!ELEMENT h6 %Inline;>
# <!ATTLIST h6
#    %attrs
#    >
/**
 *	Creates one of the 6 headings h1 to h6
 *
 *	The elements h1 to h6 group the contents of a document into sections, and briefly describe the topic of each section. There are six levels of headings, h1 being the most important and h6 the least important.
 */
class CXHHeading extends CXHEntityAttrs
{
	/**
	 *	@var int Constant for the first level of document heading
	 */
	const iLvl1 = 1;


	/**
	 *	@var int Constant for the second level of document heading
	 */
	const iLvl2 = 2;


	/**
	 *	@var int Constant for the third level of document heading
	 */
	const iLvl3 = 3;


	/**
	 *	@var int Constant for the fourth level of document heading
	 */
	const iLvl4 = 4;


	/**
	 *	@var int Constant for the fifth level of document heading
	 */
	const iLvl5 = 5;


	/**
	 *	@var int Constant for the sixth level of document heading
	 */
	const iLvl6 = 6;
	

	/**
	 *	@param int $ciLevel Class constant value of the heading level
	 *	@param mixed $vContent Content of the heading
	 */
	public function __construct($ciLevel = self::iLvl1, $vContent = PXH_EMPTY_STRING)
	{
		if ($ciLevel >= self::iLvl1 && $ciLevel <= self::iLvl6)
		{
			switch ($ciLevel)
			{
				case self::iLvl1:
					parent::__construct("h1", true, $vContent);
				break;
				case self::iLvl2:
					parent::__construct("h2", true, $vContent);
				break;
				case self::iLvl3:
					parent::__construct("h3", true, $vContent);
				break;
				case self::iLvl4:
					parent::__construct("h4", true, $vContent);
				break;
				case self::iLvl5:
					parent::__construct("h5", true, $vContent);
				break;
				case self::iLvl6:
					parent::__construct("h6", true, $vContent);
				break;
			}
		}
		else
			throw new XHException("\$ciLevel of CXHHeading is not an inner constant");
	}
}


# <!--=================== Lists ============================================-->

##
#
# <!ELEMENT ul (li)+>
# <!ATTLIST ul
#   %attrs
#   >
/**
 *	Creates a ul element and can internaly add li elements
 *
 *	The ul element is used to create unordered lists. An unordered list is a grouping of items whose sequence in the list is not important. For example, the order in which ingredients for a recipe are presented will not affect the outcome of the recipe.
 *	The ul element must contain one or more li elements, used to define a list item. To create sublists (ordered or unordered), place ul or ol inside a li element.
 *
 *	@todo To test[3]
 */
class CXHUnorderedList extends CXHList
{
	public function __construct()
	{
		parent::__construct("ul");
	}
}


##
#
# <!ELEMENT ol (li)+>
# <!ATTLIST ol
#   %attrs
#   >
/**
 *	Creates an ol element and can internaly add li elements
 *
 *	The ol element is used to create ordered lists. An ordered list is a grouping of items whose sequence in the list is important. For example, the sequence of steps in a recipe is important if the result is to be the intended one.
 *	The ol element must contain one or more li elements, used to define a list item. To create sublists (ordered or unordered), put ol or ul inside a li element.
 *
 *	@todo To test[3]
 */
class CXHOrderedList extends CXHList
{
	public function __construct()
	{
		parent::__construct("ol");
	}
}


##
#
# <!ELEMENT li %Flow;>
# <!ATTLIST li
#   %attrs
#   >
/**
 *	Creates an li element
 *
 *	The li element represents a list item in ordered lists and unordered lists.
 *
 *	@todo To test[3]
 */
class CXHItem extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Content of the li element
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("li");
		
		if (_sl((string) $vContent))
			$this->AppendContent($vContent);
	}
}


##
#
# <!ELEMENT dl (dt|dd)+>
# <!ATTLIST dl
#   %attrs
#   >
/**
 *	Creates a dl element and can internaly add dt and dd elements
 *
 *	The dl element is used to create a list where each item in the list comprises two parts: a term and a description. A glossary of terms is a typical example of a definition list, where each item consists of the term being defined and a definition of the term.
 *
 *	@todo To test[3]
 */
class CXHDefList extends CXHEntityAttrs
{
	public function __construct()
	{
		parent::__construct("dl");
	}


	/**
	 *	Adds a dt element
	 *
	 *	@param mixed $vContent Content of the dt element
	 */
	public function AddTerm($vContent)
	{
		$oCXHTerm = new CXHTerm($vContent);
		
		$this->AppendContent($oCXHTerm);
	}
	

	/**
	 *	Inserts a dt element
	 *
	 *	@param object $oCXHTerm A dt element
	 */
	public function InsertTerm($oCXHTerm)
	{
		$this->AppendContent($oCXHTerm);
	}
	

	/**
	 *	Adds a dd element
	 *
	 *	@param mixed $vContent Content of the dd element
	 */
	public function AddDef($vContent)
	{
		$oCXHDef = new CXHDef($vContent);
		
		$this->AppendContent($oCXHDef);
	}
	

	/**
	 *	Inserts 
	 *
	 *	@param object $oCXHDef A dd element
	 */
	public function InsertDef($oCXHDef)
	{
		$this->AppendContent($oCXHDef);
	}
	

	/**
	 *	Appends a dt or a dd element
	 *
	 *	@param mixed $oContent A dt or dd element
	 */
	public function AppendContent($oContent)
	{
		if (_io($oContent, 'CXHTerm'))
			parent::AppendContent($oContent);
		else
			if (_io($oContent, 'CXHDef'))
				parent::AppendContent($oContent);
			else
				throw new XHException("Parameter is not an instance of CXHTerm or CXHDef");
	}
}
##
#
# <!ELEMENT dt %Inline;>
# <!ATTLIST dt
#   %attrs
#   >
/**
 *	Creates a dt element
 *
 *	The dt element is a definition term for an item in a definition list.
 *
 *	@todo To test[3]
 */
class CXHTerm extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Content of the dt element
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("dt", true, $vContent);
	}
}
##
#
# <!ELEMENT dd %Flow;>
# <!ATTLIST dd
#   %attrs
#   >
/**
 *	Creates a dd element
 *
 *	The dd element is a definition description for an item in a definition list.
 *
 *	@todo To test[3]
 */
class CXHDef extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Content of the dd element
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("dd", true, $vContent);
	}
}
# <!--=================== Address ==========================================-->

##
#
# <!ELEMENT address %Inline;>
# <!ATTLIST address
#   %attrs
#   >
/**
 *	Creates an address element
 *
 *	The address element is used to supply contact information. This element often appears at the beginning or end of a document.
 *
 *	@todo To test[3]
 */
class CXHAddress extends CXHEntityAttrs
{
	public function __construct()
	{
		parent::__construct("address");
	}
}


# <!--=================== Horizontal Rule ==================================-->

##
#
# <!ELEMENT hr EMPTY>
# <!ATTLIST hr
#   %attrs
#   >
/**
 *	Creates an hr element
 *
 *	he hr element is used to separate sections of content. Though the name of the hr element is "horizontal rule", most visual Web browsers render hr as a horizontal line.
 */
class CXHHRule extends CXHEntityAttrs
{
	public function __construct()
	{
		parent::__construct("hr", false);
	}
}


# <!--=================== Preformatted Text ================================-->

##
#
# <!ELEMENT pre %pre.content;>
# <!ATTLIST pre
#   %attrs
#   xml:space (preserve) #FIXED 'preserve'
#   >
/**
 *	Creates a pre element
 *
 *	The pre element instructs visual Web browsers to render content in a pre-formatted fashion. Most Web browsers will render pre-formatted content in a monospace font while preserving white space (spaces, tabs and hard returns).
 */
class CXHPre extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Content of the pre element
	 *	@param bool $bPreserve Indicates space is preserved when true; defaults to false
	 */
	public function __construct($vContent = PXH_EMPTY_STRING, $bPreserve = false)
	{
		parent::__construct("pre", true, $vContent);
		
		if ($bPreserve)
			parent::AddAttr("preserve", "preserve");
	}
}


# <!--=================== Block-like Quotes ================================-->

##
#
# <!ELEMENT blockquote %Block;>
# <!ATTLIST blockquote
#   %attrs
#   cite        CDATA          #IMPLIED
#   >
/**
 *	Creates the blockquote element
 *
 *	The blockquote element is used to identify larger amounts of quoted text.
 *
 *	@todo To test[3]
 */
class CXHBlockquote extends CXHEntityAttrs
{
	public function __construct($vContent = PXH_EMPTY_STRING, $sCiteURI = PXH_EMPTY_STRING)
	{
		parent::__construct("blockquote", true, $vContent);
			
		if (_sl($sCiteURI))
			$this->SetCite($sCiteURI);
	}
	
	
	/**
	 *	Sets the quote URI citation
	 *
	 *	@param string $sCiteURI Quote URI source
	 */
	public function SetCite($sCiteURI)
	{
		parent::AddAttr("cite", $sCiteURI);
	}
}
 
 
# <!--=================== Inserted/Deleted Text ============================-->

##
#
# <!ELEMENT ins %Flow;>
# <!ATTLIST ins
#   %attrs
#   cite        CDATA          #IMPLIED
#   datetime    CDATA     #IMPLIED
#   >
/**
 *	Creates a ins element
 *
 *	The ins element is used to mark up content that has been inserted into the current version of a document. The ins element indicates that content in the previous version of the document has been changed, and that the changes are found inside the ins element.
 *	By default, most Web browsers render content found inside the ins element with underline formatting.
 *	The ins element can be used as either a block element or an inline element. When used as a block element, the ins element can contain block elements, inline elements or text. When used as an inline element, the ins element can only contain inline elements or text.
 *
 *	@todo To test[3]
 */
class CXHInsertion extends CXHEntityAttrs
{
	/**
	 *	@param string $sCiteURI Insertion URI citation
	 *	@param string $sDateTime Insertion date/time
	 *	@param mixed $vContent Content of the insertion
	 */
	public function __construct($sCiteURI = PXH_EMPTY_STRING, $sDateTime = PXH_EMPTY_STRING, $vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("ins", true, $vContent);
		
		if (_sl($sCiteURI))
			$this->SetCite($sCiteURI);
			
		if (_sl($sDateTime))
			$this->SetDateTime($sDateTime);
	}
	
	
	/**
	 *	Sets the insertion URI citation
	 *
	 *	@param string $sCiteURI Insertion URI citation
	 */
	public function SetCite($sCiteURI)
	{
		$this->AddAttr("cite", $sCiteURI);
	}
	
	
	/**
	 *	Sets the date/time of the insertion
	 *
	 *	@param string $sDateTime Date/time insertion
	 */
	public function SetDateTime($sDateTime)
	{
		$this->AddAttr("datetime", $sDateTime);
	}
}


##
#
# <!ELEMENT del %Flow;>
# <!ATTLIST del
#   %attrs
#   cite        CDATA          #IMPLIED
#   datetime    CDATA     #IMPLIED
#   >
/**
 *	Creates a del element
 *
 *	The del element is used to mark up modifications made to a document. Specifically, the del element is used to indicate that a section of content has changed and has therefore been removed.
 *	By default, most Web browsers render content inside the del element with strike-through formatting.
 *	The del element can be used as either a block element, or as an inline element. When used as a block element, the del element can contain block elements, inline elements, or text. When used as an inline element, the del element can only contain inline elements, or text.
 *
 *	@todo To test[3]
 */
class CXHDeletion extends CXHEntityAttrs
{
	/**
	 *	@param string $sCiteURI Deletion URI citation
	 *	@param string $sDateTime Deletion date/time
	 *	@param mixed $vContent Content of the deletion
	 */
	public function __construct($sCiteURI = PXH_EMPTY_STRING, $sDateTime = PXH_EMPTY_STRING, $vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("ins", true, $vContent);
		
		if (_sl($sCiteURI))
			$this->SetCite($sCiteURI);
			
		if (_sl($sDateTime))
			$this->SetDateTime($sDateTime);
	}
	
	
	/**
	 *	Sets the deletion URI citation
	 *
	 *	@param string $sCiteURI Deletion URI citation
	 */
	public function SetCite($sCiteURI)
	{
		$this->AddAttr("cite", $sCiteURI);
	}
	
	
	/**
	 *	Sets the date/time of the deletion
	 *
	 *	@param string $sDateTime Date/time deletion
	 */
	public function SetDateTime($sDateTime)
	{
		$this->AddAttr("datetime", $sDateTime);
	}
}


# <!--================== The Anchor Element ================================-->

##
#
# <!ELEMENT a %a.content;>
# <!ATTLIST a
#   %attrs
#   charset     CDATA       #IMPLIED
#   type        CDATA       #IMPLIED
#   name        NMTOKEN     #IMPLIED
#   href        CDATA       #IMPLIED
#   hreflang    CDATA       #IMPLIED
#   rel         CDATA       #IMPLIED
#   rev         CDATA       #IMPLIED
#   accesskey   CDATA       #IMPLIED
#   shape       (rect|circle|poly|default)        "rect"
#   coords      CDATA       #IMPLIED
#   tabindex    CDATA       #IMPLIED
#   onfocus     CDATA       #IMPLIED
#   onblur      CDATA       #IMPLIED
#   >
/**
 *	Creates an a element
 *
 *	The a element is used to create a hyperlink. The destination of the hyperlink is specified in the href attribute, and the text or image for the hyperlink is specified between the opening <a> and closing </a> tags.
 */
class CXHAnchor extends CXHEntityAttrs
{
	/**
	 *	@param string $sHRef Hyperlink reference
	 *	@param mixed $vContent Initial element content
	 *	@param string $sTitle Title of the element
	 *	@param string $sTarget Target of the hyperlink
	 */
	public function __construct($sHRef, $vContent = PXH_EMPTY_STRING, $sTitle = PXH_EMPTY_STRING, $sTarget = PXH_EMPTY_STRING)
	{
		parent::__construct("a");
		
		$this->AddAttr("href", $sHRef);

		if (_sl($vContent)) $this->AppendContent($vContent);
		if (_sl($sTitle)) $this->SetTitle($sTitle);
		if (_sl($sTarget)) $this->SetTarget($sTarget);
	}


	/**
	 *	Sets the target of the hyperlink
	 *
	 *	@param string $sTarget Target of the hyperlink
	 */
	public function SetTarget($sTarget)
	{
		$this->AddEvent("onclick", "window.open(this.href,'".$sTarget."'); return false;");
		$this->AddEvent("onkeypress", "window.open(this.href,'".$sTarget."'); return false;");
	}
}
# <!--===================== Inline Elements ================================-->

##
#
# <!ELEMENT span %Inline;> <!-- generic language/style container -->
# <!ATTLIST span
#   %attrs
#   >
/**
 *	Creates a span element
 *
 *	The span element offers a generic way of adding structure to content.
 */
class CXHSpan extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Content of the element
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("span", true, $vContent);
	}
}


##
#
# <!ELEMENT bdo %Inline;>  <!-- I18N BiDi over-ride -->
# <!ATTLIST bdo
#   %attrs
#   >
/**
 *	Creates a bdo element
 *
 *	Unlike English, which is written from left-to-right (LTR), some languages, such as Arabic and Hebrew, are written from right-to-left (RTL). When the same paragraph contains both RTL and LTR text, this is known as bidirectional text or "bidi" text for short.
 *	Most Web browsers will correctly display bidirectional text. However, situations may arise when the browser's bidirectional algorithm results in incorrect presentation. To correct this, the bdo element allows authors to turn off the bidirectional algorithm for selected fragments of text.
 */
class CXHBDO extends CXHEntityAttrs
{
	/**
	 *	@var string Defines a left to right command
	 */
	const sLTR = 'ltr';


	/**
	 *	@var string Defines a right to left command
	 */
	const sRTL = 'rtl';


	/**
	 *	@param string $csDir Class constant indicating the direction of text
	 */
	public function __construct($csDir)
	{
		parent::__construct("bdo");
		
		parent::AddAttr("dir", $csDir);
	}
}


##
#
# <!ELEMENT br EMPTY>   <!-- forced line break -->
# <!ATTLIST br
#   %coreattrs
#   >
/**
 *	Creates a br element
 *
 *	The br element forcibly breaks (ends) the current line of text. Web browsers render these line breaks as hard returns.
 */
class CXHBreak extends CXHEntityCoreAttrs
{
	public function __construct()
	{
		parent::__construct("br", false);
	}
}


##
#
# <!ELEMENT em %Inline;>   <!-- emphasis -->
# <!ATTLIST em %attrs>
/**
 *	Creates a em element
 *
 *	The em element is used to indicate emphasis.
 *
 *	@todo To test[3]
 */
class CXHEmphasis extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Content of the element
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("em", true, $vContent);
	}
}


##
#
# <!ELEMENT strong %Inline;>   <!-- strong emphasis -->
# <!ATTLIST strong %attrs>
/**
 *	Creates a strong element
 *
 *	The strong element is used to indicate stronger emphasis.
 *
 *	@todo To test[3]
 */
class CXHStrong extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Initial content of the element
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("strong", true, $vContent);
	}
}


##
#
# <!ELEMENT dfn %Inline;>   <!-- definitional -->
# <!ATTLIST dfn %attrs>
/**
 *	Creates a dfn element
 *
 *	The dfn element contains the defining instance of the enclosed term.
 *
 *	@todo To test[3]
 */
class CXHDefining extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Initial defining instance content
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("dfn", true, $vContent);
	}
}


##
#
# <!ELEMENT code %Inline;>   <!-- program code -->
# <!ATTLIST code %attrs>
/**
 *	Creates a code element
 *
 *	The code element contains a fragment of computer code.
 *
 *	@todo To test[3]
 */
class CXHCode extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Initial code content
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("code", true, $vContent);
	}
}


##
#
# <!ELEMENT samp %Inline;>   <!-- sample -->
# <!ATTLIST samp %attrs>
/**
 *	Creates a samp element
 *
 *	The samp element is used to designate sample output from programs, scripts, etc.
 *
 *	@todo To test[3]
 */
class CXHSample extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Initial sample content
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("samp", true, $vContent);

	}
}


##
#
# <!ELEMENT kbd %Inline;>  <!-- something user would type -->
# <!ATTLIST kbd %attrs>
/**
 *	Creates a kbd element
 *
 *	The kbd element indicates input to be entered by the user.
 *
 *	@todo To test[3]
 */
class CXHKeyboard extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Initial element content
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("kbd", true, $vContent);
	}
}


##
#
# <!ELEMENT var %Inline;>   <!-- variable -->
# <!ATTLIST var %attrs>
/**
 *	Creates a var element
 *
 *	The var element is used to indicate an instance of a computer code variable or program argument.
 *
 *	@todo To test[3]
 */
class CXHVar extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Initial element content
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("var", true, $vContent);
	}
}


##
#
# <!ELEMENT cite %Inline;>   <!-- citation -->
# <!ATTLIST cite %attrs>
/**
 *	Creates a cite element
 *
 *	The cite element contains a citation or reference to another source.
 *
 *	@todo To test[3]
 */
class CXHCite extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Initial citation content
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("cite", true, $vContent);
	}
}


##
#
# <!ELEMENT abbr %Inline;>   <!-- abbreviation -->
# <!ATTLIST abbr %attrs>
/**
 *	Creates a abbr element
 *
 *	An abbreviation is a shortened form of a word or phrase. The abbr element is used to identify an abbreviation, and can help assistive technologies to correctly pronounce abbreviated text.
 *
 *	@todo To test[3]
 */
class CXHAbbreviation extends CXHEntityAttrs
{
	/**
	 *	@param string $sFullForm Full or expanded form of the abbreviation
	 *	@param mixed $vContent Initial content of the element
	 */
	public function __construct($sFullForm = PXH_EMPTY_STRING, $vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("abbr", true, $vContent);
		
		if (_sl($sFullForm))
			parent::SetTitle($sFullForm);
	}
}


##
#
# <!ELEMENT acronym %Inline;>   <!-- acronym -->
# <!ATTLIST acronym %attrs>
/**
 *	Creates a acronym element
 *
 *	An acronym is a word formed from the initial letters of a series of words. The acronym element identifies acronyms, and can help assistive technologies to correctly pronounce the acronym.
 *
 *	@todo To test[3]
 */
class CXHAcronym extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Initial element content
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("acronym", true, $vContent);
	}
}


##
#
# <!ELEMENT q %Inline;>   <!-- inlined quote -->
# <!ATTLIST q
#   %attrs
#   cite        CDATA          #IMPLIED
#   >
/**
 *	Creates a q element
 *
 *	The q is used to identify short quoted text.
 *
 *	@todo To test[3]
 */
class CXHQuote extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Initial element content
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("q", true, $vContent);
	}
}


##
#
# <!ELEMENT sub %Inline;> <!-- subscript -->
# <!ATTLIST sub %attrs>
/**
 *	Creates a sub element
 *
 *	The sub element indicates that its contents should be regarded as a subscript.
 *
 *	@todo To test[3]
 */
class CXHSubScript extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Initial element content
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("sub", true, $vContent);
	}
}


##
#
# <!ELEMENT sup %Inline;> <!-- superscript -->
# <!ATTLIST sup %attrs>
/**
 *	Creates a sup element
 *
 *	The sup element indicates that its contents should regarded as superscript.
 *
 *	@todo To test[3]
 */
class CXHSuperScript extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Initial element content
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("sup", true, $vContent);
	}
}


##
#
# <!ELEMENT tt %Inline;>   <!-- fixed pitch font -->
# <!ATTLIST tt %attrs>
/**
 *	Creates a tt element
 *
 *	The tt element renders text in a teletype or a monospaced font.
 *
 *	@todo To test
 */
class CXHTeletype extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Initial content of the element
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("tt");
		
		if (_sl($vContent))
			parent::AppendContent($vContent);
	}
}


##
#
# <!ELEMENT i %Inline;>   <!-- italic font -->
# <!ATTLIST i %attrs>
/**
 *	Creates a i element
 *
 *	The i element renders text in italic style.
 *
 *	@todo To test[3]
 */
class CXHItalic extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Initial element content
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("i", true, $vContent);
	}
}


##
#
# <!ELEMENT b %Inline;>   <!-- bold font -->
# <!ATTLIST b %attrs>
/**
 *	Creates a b element
 *
 *	The b element renders text in bold style.
 *
 *	@todo To test[3]
 */
class CXHBold extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Initial element content
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("b", true, $vContent);
	}
}


##
#
# <!ELEMENT big %Inline;>   <!-- bigger font -->
# <!ATTLIST big %attrs>
/**
 *	Creates a big element
 *
 *	The big element renders text in a large font.
 *
 *	@todo To test[3]
 */
class CXHBig extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Initial element content
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("big", true, $vContent);
	}
}


##
#
# <!ELEMENT small %Inline;>   <!-- smaller font -->
# <!ATTLIST small %attrs>
/**
 *	Creates a small element
 *
 *	The small element renders text in a small font.
 *
 *	@todo To test[3]
 */
class CXHSmall extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Initial element content
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("small", true, $vContent);
	}
}


# <!--==================== Object ======================================-->

##
#
# <!ELEMENT object (#PCDATA | param | %block; | form | %inline; | %misc;)*>
# <!ATTLIST object
#   %attrs
#   declare     (declare)      #IMPLIED
#   classid     CDATA          #IMPLIED
#   codebase    CDATA          #IMPLIED
#   data        CDATA          #IMPLIED
#   type        CDATA  #IMPLIED
#   codetype    CDATA  #IMPLIED
#   archive     CDATA      #IMPLIED
#   standby     CDATA         #IMPLIED
#   height      CDATA       #IMPLIED
#   width       CDATA       #IMPLIED
#   usemap      CDATA          #IMPLIED
#   name        NMTOKEN        #IMPLIED
#   tabindex    CDATA       #IMPLIED
#   >
/**
 *	@todo To implement
 *	@todo To document
 *	@todo To test[3]
 */
class CXHObject extends CXHEntityAttrs
{
	public function __construct()
	{
	
	}
	
	
	public function AddParam()
	{
	
	}
	
	
	public function InsertParam()
	{
	
	}
	
	
	public function AppendContent()
	{
	
	}
}


##
#
# <!ELEMENT param EMPTY>
# <!ATTLIST param
#   id          ID             #IMPLIED
#   name        CDATA          #IMPLIED
#   value       CDATA          #IMPLIED
#   valuetype   (data|ref|object) "data"
#   type        CDATA  #IMPLIED
#   >
/**
 *	@todo To implement
 *	@todo To document
 *	@todo To test[3]
 */
class CXHParam extends CXHEntityAttrs
{
	public function __construct()
	{
	
	}
}


# <!--=================== Images ===========================================-->

##
#
# <!ELEMENT img EMPTY>
# <!ATTLIST img
#   %attrs
#   src         CDATA          #REQUIRED
#   alt         CDATA         #REQUIRED
#   longdesc    CDATA          #IMPLIED
#   height      CDATA       #IMPLIED
#   width       CDATA       #IMPLIED
#   usemap      CDATA          #IMPLIED
#   ismap       (ismap)        #IMPLIED
#   >
/**
 *	Creates a img element
 *
 *	The img element is used to define an image.
 */
class CXHImage extends CXHEntityAttrs
{
	/**
	 *	@param string $sSrc URI reference of the image
	 *	@param string $sDesc Alternate text of the element
	 *	@param string $sWidth Width of the image
	 *	@param string $sHeight Height of the image
	 */
	public function __construct($sSrc, $sDesc, $sWidth = PXH_EMPTY_STRING, $sHeight = PXH_EMPTY_STRING)
	{
		parent::__construct("img", false);
		
		$this->AddAttr("src", $sSrc);
		$this->AddAttr("alt",$sDesc);
		
		if (_sl($sWidth)) $this->SetWidth($sWidth);
		if (_sl($sHeight)) $this->SetHeight($sHeight);
	}


	/**
	 *	Sets the width of the image
	 *
	 *	@param string $sWidth Width of the image
	 */
	public function SetWidth($sWidth)
	{
		$this->AddAttr("width",$sWidth);
	}


	/**
	 *	Sets the height of the image
	 *	@param string $sHeight Height of the image
	 */
	public function SetHeight($sHeight)
	{
		$this->AddAttr("height",$sHeight);
	}
	

	/**
	 *	Sets the id reference of a map element
	 *
	 *	@param string $sMapId Id of the map element
	 */
	public function SetUseMap($sMapId)
	{
		$this->AddAttr("usemap", "#".$sMapId);
	}
}


# <!--================== Client-side image maps ============================-->

##
#
# <!ELEMENT map ((%block; | form | %misc;)+ | area+)>
# <!ATTLIST map
#   %attrs
#   name        NMTOKEN        #IMPLIED
#   >
/**
 *	Creates a map element
 *
 *	The map element specifies a client-side image map that may be referenced by elements such as img, select and object.
 *
 *	@todo Watch the usage of the class through the interactivity of the base class; technicaly it shouldn't inherit from CXHEntityAttrs
 *	@todo Retest and find the bug and reason for not working
 */
class CXHMap extends CXHEntityAttrs
{
	/**
	 *	@param string $sId Id of the element
	 */
	public function __construct($sId)
	{
		parent::__construct("map");
		
		parent::SetId($sId);
	}
	

	/**
	 *	Adds an area element
	 *
	 *	@param string $sHRef URI reference of the area
	 *	@param string $sAlt Description of the area
	 *	@param string $sShape CXHArea class constant defining the shape of the area
	 *	@param string $sCoords Coordinates of the area
	 */
	public function AddArea($sHRef, $sAlt, $csShape, $sCoords)
	{
		$oCXHArea = new CXHArea($sHRef, $sAlt, $csShape, $sCoords);
	
		$this->AppendContent($oCXHArea);
	}
	

	/**
	 *	Inserts an area element
	 *
	 *	@param object $oCXHArea An area object
	 */
	public function InsertArea($oCXHArea)
	{
		$this->AppendContent($oCXHArea);
	}
	

	/**
	 *	Inserts an object in the element
	 *
	 *	@param object $oContent Content of the map
	 */
	public function AppendContent($oContent)
	{
		if (_io($oContent, 'CMLEntity'))
			parent::AppendContent($oContent);
		else
			throw new XHException("Parameter is not an instance of CMLEntity");
	}
}


##
#
# <!ELEMENT area EMPTY>
# <!ATTLIST area
#   %attrs
#   shape       (rect|circle|poly|default)        "rect"
#   coords      CDATA       #IMPLIED
#   href        CDATA          #IMPLIED
#   nohref      (nohref)       #IMPLIED
#   alt         CDATA         #REQUIRED
#   tabindex    CDATA       #IMPLIED
#   accesskey   CDATA    #IMPLIED
#   onfocus     CDATA       #IMPLIED
#   onblur      CDATA       #IMPLIED
#   >
/**
 *	Creates an area element
 *
 *	The area element identifies geometric regions of a client-side image map, and provides a hyperlink for each region.
 */
class CXHArea extends CXHEntityAttrs
{
	/**
	 *	@var string URI reference of the area
	 *	@access private
	 */
	private $_sHRef;


	/**
	 *	@var string Alternate text of the area
	 *	@access private
	 */
	private $_sAlt;


	/**
	 *	@var string Shape of the area
	 *	@access private
	 */
	private $_sShape;


	/**
	 *	@var string Coordinates of the area
	 *	@access private
	 */
	private $_sCoords;


	/**
	 *	@var string Defines the rectangle shape
	 */
	const sShapeRect =		'rect';


	/**
	 *	@var string Defines the circle shape
	 */
	const sShapeCircle =	'circle';


	/**
	 *	@var string Defines the polyline shape
	 */
	const sShapePoly =		'poly';


	/**
	 *	@var string Defines the default shape; 'rect' as defined in the XHTML DTD specification
	 */
	const sShapeDefault =	'default';


	/**
	 *	@param string $sHRef URI reference of the area
	 *	@param string $sAlt Alternate text of the area
	 *	@param string $sShape Class constant value of the shape of the area
	 *	@param string $sCoords Coordinates of the area
	 */
	public function __construct($sHRef = PXH_EMPTY_STRING, $sAlt = PXH_EMPTY_STRING, $csShape = PXH_EMPTY_STRING, $sCoords = PXH_EMPTY_STRING)
	{
		parent::__construct("area", false);
		
		if (_sl($sHRef)) $this->SetHRef($sHRef);
		if (_sl($sAlt)) $this->SetAlt($sAlt);
		if (_sl($csShape)) $this->SetShape($csShape);
		if (_sl($sCoords)) $this->SetCoords($sCoords);
		
		parent::_RegisterEvent("onfocus");
		parent::_RegisterEvent("onblur");
	}
	

	/**
	 *	Sets the URI reference of the element
	 *
	 *	@param string $sHRef URI reference of the element
	 */
	public function SetHRef($sHRef)
	{
		$this->_sHRef = $sHRef;
		
		parent::AddAttr("href", $sHRef);
	}
	

	/**
	 *	Sets the alternate text of the element
	 *
	 *	@param string $sAlt Alternate text of the element
	 */
	public function SetAlt($sAlt)
	{
		$this->_sAlt = $sAlt;
		
		parent::AddAttr("alt", $sAlt);
	}
	

	/**
	 *	Sets the shape of the element
	 *
	 *	@param string $csShape Class constant value of the shape of the element
	 */
	public function SetShape($csShape)
	{
		$this->_sShape = $csShape;
		
		parent::AddAttr("shape", $csShape);
	}
	

	/**
	 *	Sets the coordinates of the element
	 *
	 *	@param string $sCoords Coordinates of the element
	 */
	public function SetCoords($sCoords)
	{
		$this->_sCoords = $sCoords;
		
		parent::AddAttr("coords", $sCoords);
	}
}


# <!--================ Forms ===============================================-->

##
#
# <!ELEMENT form %form.content;>   <!-- forms shouldn't be nested -->
# <!ATTLIST form
#   %attrs
#   action      CDATA          #REQUIRED
#   method      (get|post)     "get"
#   enctype     CDATA  "application/x-www-form-urlencoded"
#   onsubmit    CDATA       #IMPLIED
#   onreset     CDATA       #IMPLIED
#   accept      CDATA #IMPLIED
#   accept-charset CDATA  #IMPLIED
#   >
/**
 *	Creates a form element
 *
 *	The form element is used to create data entry forms. Data collected in the form is sent to the server for processing by server-side scripts such as PHP, ASP, etc.
 */
class CXHForm extends CXHEntityAttrs
{
	/**
	 *	@param string $sAction URI reference for form processing
	 *	@param string $sMethod Method used for data processing
	 *	@param string $sName Name of the element
	 *	@param string $sEnctype Encryption type of the submitted data
	 */
	public function __construct($sAction, $sMethod = "get", $sName = PXH_EMPTY_STRING, $sEnctype = "application/x-www-form-urlencoded")
	{
		parent::__construct("form");
		
		$this->AddAttr("action",$sAction);
		$this->AddAttr("method",$sMethod);
		
		if (_sl($sName)) $this->AddAttr("name",$sName);

		$this->AddAttr("enctype",$sEnctype);
		
		parent::_RegisterEvent("onsubmit");
		parent::_RegisterEvent("onreset");
	}
}


##
#
# <!ELEMENT label %Inline;>
# <!ATTLIST label
#   %attrs
#   for         IDREF          #IMPLIED
#   accesskey   CDATA          #IMPLIED
#   onfocus     CDATA          #IMPLIED
#   onblur      CDATA          #IMPLIED
#   >
/**
 *	Creates a label element
 *
 *	The label element associates a label with form controls such as input, textarea, select and object. This association enhances the usability of forms. For example, when users of visual Web browsers click in a label, focus is automatically set in the associated form control. For users of assistive technology, establishing associations between labels and controls helps clarify the spatial relationships found in forms and makes them easier to navigate.
 */
class CXHLabel extends CXHEntityAttrs
{
	/**
	 *	@param string $sForId Id of the input referenced
	 *	@param string $vContent Initial content io the element
	 */
	public function __construct($sForId, $vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("label");
		
		$this->AddAttr("for", $sForId);
		
		if (_sl($vContent))
			$this->AppendContent($vContent);
		
		parent::_RegisterEvent("onfocus");
		parent::_RegisterEvent("onblur");
	}
}


##
#
# <!ELEMENT input EMPTY>     <!-- form control -->
# <!ATTLIST input
#   %attrs
#   type        (text | password | checkbox | radio | submit | reset | file | hidden | image | button)    "text"
#   name        CDATA          #IMPLIED
#   value       CDATA          #IMPLIED
#   checked     (checked)      #IMPLIED
#   disabled    (disabled)     #IMPLIED
#   readonly    (readonly)     #IMPLIED
#   size        CDATA          #IMPLIED
#   maxlength   CDATA          #IMPLIED
#   src         CDATA          #IMPLIED
#   alt         CDATA          #IMPLIED
#   usemap      CDATA          #IMPLIED
#   tabindex    CDATA          #IMPLIED
#   accesskey   CDATA          #IMPLIED
#   onfocus     CDATA          #IMPLIED
#   onblur      CDATA          #IMPLIED
#   onselect    CDATA          #IMPLIED
#   onchange    CDATA          #IMPLIED
#   accept      CDATA          #IMPLIED
#   >


##
#
# <!ELEMENT textarea (#PCDATA)>     <!-- multi-line text field -->
# <!ATTLIST textarea
#   %attrs
#   name        CDATA          #IMPLIED
#   rows        CDATA          #REQUIRED
#   cols        CDATA          #REQUIRED
#   disabled    (disabled)     #IMPLIED
#   readonly    (readonly)     #IMPLIED
#   tabindex    CDATA          #IMPLIED
#   accesskey   CDATA          #IMPLIED
#   onfocus     CDATA          #IMPLIED
#   onblur      CDATA          #IMPLIED
#   onselect    CDATA          #IMPLIED
#   onchange    CDATA          #IMPLIED
#   >
/**
 *	Creates a text type input or a textarea
 *
 *	Text type input: Creates a single-line text input control.
 *	Textarea: The textarea element is used to create a multi-line text input form control.
 */
class CXHFieldText extends CXHFieldAttrs
{
	/**
	 *	@var bool Defines if it's an text type input or textarea
	 *	@access private
	 */
	private $_bIsMultiline;


	/**
	 *	@param string $sIdName Id and name of the element
	 *	@param string $sValue Initial value or content of the element
	 *	@param bool $bIsDisabled Indicates if element is disabled
	 *	@param bool $bMultiline If element is a text type input or textarea
	 *	@param string $sRows Number of rows of the textarea
	 *	@param string $sCols Number of columns of the textarea
	 */
	public function __construct($sIdName, $sValue = PXH_EMPTY_STRING, $bIsDisabled = false, $bMultiline = false, $sRows = "5", $sCols = "10")
	{
		$this->_bIsMultiline = $bMultiline;
	
		if ($bMultiline == false)
		{
			parent::__construct("input", PXH_EMPTY_STRING, $bIsDisabled, false);	
			
			parent::AddAttr("type", "text");

			parent::AddAttr("value", $sValue);
		}
		else
		{
			parent::__construct("textarea", $sValue, $bIsDisabled, true);
			
			parent::AddAttr("rows", $sRows);
			parent::AddAttr("cols", $sCols);
		}

		parent::AddAttr("name", $sIdName);
		parent::SetId($sIdName);
		
		parent::_RegisterEvent("onselect");
		parent::_RegisterEvent("onchange");
	}


	/**
	 *	Append content to the element
	 *
	 *	@param mixed $vContent Content of the element
	 */
	public function AppendContent($vContent)
	{
		if ($this->_bIsMultiline)
			parent::AppendContent($vContent);
		else
			throw new XHExcception("Cannot append content in non full ended input text");
	}


	/**
	 *	Replaces the element content
	 *
	 *	@param mixed $vContent Content of the element
	 */
	public function ReplaceContent($vContent)
	{
		if ($this->_bIsMultiline)
			parent::ReplaceContent($vContent);
		else
			throw new XHExcception("Cannot replace content in non full ended input text");
	}
}


/**
 *	Creates a password input type element
 *
 *	Creates a single-line text input control with masked input (characters appear as asterisks). Note, this control hides what the user is typing from casual observers (someone looking over your shoulder) but provides no more security than any other form control.
 */
class CXHFieldPassword extends CXHFieldInput
{
	/**
	 *	@param string $sIdName Id and name of the element
	 *	@param string $sValue Initial value of the element
	 *	@param bool $bIsDisabled Indicates if element is disabled
	 */
	public function __construct($sIdName, $sValue = PXH_EMPTY_STRING, $bIsDisabled = false)
	{
		parent::__construct($sIdName, $sValue, "password", PXH_EMPTY_STRING, $bIsDisabled);
	}
}


/**
 *	Creates a checkbox input type element
 */
class CXHFieldCheckbox extends CXHFieldInput
{
	/**
	 *	@param string $sName Name of the element
	 *	@param string $sId Id of the element
	 *	@param string $sValue Initial value of the element
	 *	@param bool $bChecked Indicates if input is checked
	 *	@param bool $bIsDisabled Indicates if element is disabled
	 */
	public function __construct($sName, $sId, $sValue = PXH_EMPTY_STRING, $bChecked = false, $bIsDisabled = false)
	{
		parent::__construct($sName, $sValue, "checkbox", PXH_EMPTY_STRING, $bIsDisabled);
		
		parent::SetId($sId);
		
		if ($bChecked) $this->AddAttr("checked", "checked");
	}
}


/**
 *	Creates a radio input type element
 */
class CXHFieldRadio extends CXHFieldInput
{
	/**
	 *	@param string $sName Name of the element
	 *	@param string $sId Id of the element
	 *	@param string $sValue Initial value of the element
	 *	@param bool $bChecked Indicates if input is checked
	 *	@param bool $bIsDisabled Indicates if element is disabled
	 */
	public function __construct($sName, $sId, $sValue = PXH_EMPTY_STRING, $bChecked = false, $bIsDisabled = false)
	{
		parent::__construct($sName, $sValue, "radio", PXH_EMPTY_STRING, $bIsDisabled);
		
		parent::SetId($sId);
		
		if ($bChecked) $this->AddAttr("checked", "checked");
	}
}


/**
 *	Creates a submit button input type element
 *	@todo To test[3]
 */
class CXHButtonSubmit extends CXHFieldInput
{
	/**
	 *	@param string $sIdName Id and name of the element
	 *	@param string $sValue Value display of the button
	 *	@param bool $bIsDisabled Indicates if element is disabled
	 */
	public function __construct($sIdName, $sValue = "Submit", $bIsDisabled = false)
	{
		parent::__construct($sIdName, $sValue, "submit", PXH_EMPTY_STRING, $bIsDisabled);
	}
}


/**
 *	Creates a reset button input type element
 *
 *	Restores the value of all controls on the form to their initial state.
 *	@todo To test[3]
 */
class CXHButtonReset extends CXHFieldInput
{
	/**
	 *	@param string $sIdName Id and name of the element
	 *	@param string $sValue Value display of the element
	 *	@param bool $bIsDisabled Indicates if element is disabled
	 */
	public function __construct($sIdName, $sValue = "Reset", $bIsDisabled = false)
	{
		parent::__construct($sIdName, $sValue, "reset", PXH_EMPTY_STRING, $bIsDisabled);
	}
}


/**
 *	Creates a file input type element
 */
class CXHFieldFile extends CXHFieldInput
{
	/**
	 *	@param string $sIdName Id and name of the element
	 *	@param bool $bIsDisabled Indicates if element is disabled
	 */
	public function __construct($sIdName, $bIsDisabled = false)
	{
		parent::__construct($sIdName, PXH_EMPTY_STRING, "file", PXH_EMPTY_STRING, $bIsDisabled);
	}
}


/**
 *	Creates a hidden input type element
 *
 *	Hidden controls are useful for passing additional information back and forth between the server and the Web browser.
 */
class CXHFieldHidden extends CXHFieldInput
{
	/**
	 *	@param string $sIdName Id and name of the element
	 *	@param string $sValue Initial value of the element
	 *	@param bool $bIsDisabled Indicates if element is disabled
	 */
	public function __construct($sIdName, $sValue = PXH_EMPTY_STRING, $bIsDisabled = false)
	{
		parent::__construct($sIdName, $sValue, "hidden", PXH_EMPTY_STRING, $bIsDisabled);
	}
}


/**
 *	Creates an image input type element
 */
class CXHFieldImage extends CXHFieldInput
{
	/**
	 *	@param string $sImageURL URI reference of the image
	 *	@param string $sAltText Alternate text of the image
	 *	@param string $sIdName Id and name of the element
	 *	@param string $sValue Initial value of the element
	 *	@param bool $bIsDisabled Indicates if element is disabled
	 */
	public function __construct($sImageURL, $sAltText, $sIdName, $sValue, $bIsDisabled = false)
	{
		parent::__construct($sIdName, $sValue, "image", PXH_EMPTY_STRING, $bIsDisabled);

		$this->AddAttr("src", $sImageURL);
		$this->AddAttr("alt", $sAltText);
	}
}


/**
 *	Creates a button input type element
 *	@todo To test[3]
 */
class CXHButton extends CXHFieldInput
{
	/**
	 *	@param string $sIdName Id and name of the element
	 *	@param string $sValue Value display of the button
	 *	@param bool $bIsDisabled indicates if element is disabled
	 */
	public function __construct($sIdName, $sValue, $bIsDisabled = false)
	{
		parent::__construct($sIdName, $sValue, "button", PXH_EMPTY_STRING, $bIsDisabled);
	}
}


##
#
# <!ELEMENT select (optgroup|option)+>  <!-- option selector -->
# <!ATTLIST select
#   %attrs
#   name        CDATA       #IMPLIED
#   size        CDATA       #IMPLIED
#   multiple    (multiple)  #IMPLIED
#   disabled    (disabled)  #IMPLIED
#   tabindex    CDATA       #IMPLIED
#   onfocus     CDATA       #IMPLIED
#   onblur      CDATA       #IMPLIED
#   onchange    CDATA       #IMPLIED
#   >
/**
 *	Creates a select element
 *
 *	The select element is used to create an option selector form control which most Web browsers render as a listbox control. The list of values for this control is created using option elements. These values can be grouped together using the optgroup element.
 */
class CXHSelectbox extends CXHOptionsInsertions
{
	/**
	 *	@var bool Indicates if multiple options can be selected
	 *	@access private
	 */
	private $_bIsMultiple;


	/**
	 *	@param string $sIdName Name and id of the element
	 *	@param int $iSize Number options shown
	 *	@param bool $bIsMultiple Indicates if multiple options can be selected
	 *	@param bool $bIsDisabled Indicates if element is disabled
	 */
	public function __construct($sIdName, $iSize = 1, $bIsMultiple = false, $bIsDisabled = false)
	{
		parent::__construct("select", $bIsDisabled);
		
		$this->AddAttr("name", $sIdName);
		$this->SetId($sIdName);

		if ($iSize > 1)
			$this->AddAttr("size", "$iSize");
		
		$this->_bIsMultiple = $bIsMultiple;
		
		if ($bIsMultiple)
			$this->AddAttr("multiple", "multiple");
		
		parent::_RegisterEvent("onchange");
	}
	

	/**
	 *	@access private
	 */
	private function _validateNumSelections()
	{
		if (!$this->_bIsMultiple && $this->_iNumSelected > 1)
			throw new XHException("Select is not multiple but many options are selected");
	}
	

	/**
	 *	Adds an option to the element
	 *
	 *	@param string $sValue Value of the option
	 *	@param string $sDisplay Text display of the option
	 *	@param bool $bSelected Indicates if option is selected
	 *	@param bool $bIsDisabled Indicates if option is disabled
	 */
	public function AddOption($sValue, $sDisplay, $bSelected = false, $bIsDisabled = false)
	{
		parent::AddOption($sValue, $sDisplay, $bSelected, $bIsDisabled);
		
		if ($bSelected)
			$this->IncrementSelections();
			
		$this->_validateNumSelections();
	}
	

	/**
	 *	Inserts an option to the element
	 *
	 *	@param object $oOption Instance of class CXHOption
	 */
	public function InsertOption($oOption)
	{
		parent::InsertOption($oOption);
		
		if ($oOption->IsSelected())
			$this->IncrementSelections();
		
		$this->_validateNumSelections();
	}
	

	/**
	 *	Inserts an option to the element
	 *
	 *	@param object $oOption Instance of class CXHOption
	 */
	public function AppendContent($oOption)
	{
		$this->InsertOption($oOption);
	}
	

	/**
	 *	Inserts an optgroup element
	 *
	 *	@param object $oOptionGroup Instance of class CXHOptionGroup
	 */
	public function InsertOptionGroup($oOptionGroup)
	{
		if (_io($oOptionGroup, 'CXHOptionGroup'))
		{
			for ($i = 0; $i < $oOptionGroup->GetNumSelections(); $i++)
				$this->IncrementSelections();
		
			$this->_validateNumSelections();
			
			parent::AppendContent($oOptionGroup);
		}
		else
		{
			throw new XHException("option is not an instance of class CXHOptionGroup");
		}
	}
}


##
#
# <!ELEMENT optgroup (option)+>   <!-- option group -->
# <!ATTLIST optgroup
#   %attrs
#   disabled    (disabled)     #IMPLIED
#   label       CDATA          #REQUIRED
#   >
/**
 *	Creates a optgroup element
 *
 *	The optgroup element is used to group the choices offered in select form controls. Users find it easier to work with long lists if related sections are grouped together.
 */
class CXHOptionGroup extends CXHOptionsInsertions
{
	/**
	 *	@param string $sLabel Label of the element
	 *	@param bool $bIsDisabled Indicates if the element is disabled
	 */
	public function __construct($sLabel, $bIsDisabled = false)
	{
		parent::__construct("optgroup", $sDisplay);
		
		$this->AddAttr("label",$sLabel);
		
		if ($bIsDisabled) $this->AddAttr("disabled", "disabled");
	}
	

	/**
	 *	Appends an option element
	 *
	 *	@param object $oOption Instance of class CXHOption
	 */
	public function AppendContent($oOption)
	{
		parent::InsertOption($oOption);
	}
}


##
#
# <!ELEMENT option (#PCDATA)>     <!-- selectable choice -->
# <!ATTLIST option
#   %attrs
#   selected    (selected)     #IMPLIED
#   disabled    (disabled)     #IMPLIED
#   label       CDATA         #IMPLIED
#   value       CDATA          #IMPLIED
#   >
/**
 *	Creates a option element
 *
 *	The option element represents a choice offered by select form controls.
 */
class CXHOption extends CXHEntityAttrs
{
	/**
	 *	@var bool Indicates if element is selected
	 *	@access private
	 */
	private $_bIsSelected;
	

	/**
	 *	@param string $sValue Value of the option
	 *	@param string $sDisplay Text display of the option
	 *	@param bool $bSelected Indicates if option is selected
	 *	@param bool $bIsDisabled Indicates if option is disabled
	 */
	public function __construct($sValue, $sDisplay, $bSelected = false, $bIsDisabled = false)
	{
		parent::__construct("option", true, $sDisplay, $bIsDisabled);
		
		$this->AddAttr("value",$sValue);
		
		$this->_bIsSelected = $bSelected;
		
		if ($bIsDisabled) $this->AddAttr("disabled", "disabled");
	}
	

	/**
	 *	Tells if element is selected
	 *
	 *	@return bool
	 */
	public function IsSelected()
	{
		return $this->_bIsSelected;
	}
}


##
#
# <!ELEMENT fieldset (#PCDATA | legend | %block; | form | %inline; | %misc;)*>
# <!ATTLIST fieldset
#   %attrs
#   >
/**
 *	Creates a fieldset element
 *
 *	The fieldset element adds structure to forms by grouping together related controls and labels.
 */
class CXHFieldSet extends CXHEntityAttrs
{
	/**
	 *	@param string $sLegend Initial legend element
	 */
	public function __construct($sLegend = PXH_EMPTY_STRING)
	{
		parent::__construct("fieldset");
		
		if (_sl($sLegend)) $this->AddLegend($sLegend);
	}
	

	/**
	 *	Adds a legend to the element
	 *
	 *	@param mixed $vLegend Legend of the element
	 */
	public function AddLegend($vLegend)
	{
		$oLegend = new CXHLegend($vLegend);
		
		parent::AppendContent($oLegend);
	}
}


##
#
# <!ELEMENT legend %Inline;>     <!-- fieldset label -->
# <!ATTLIST legend
#   %attrs
#   accesskey   CDATA    #IMPLIED
#   >
/**
 *	Creates a legend element
 *
 *	The legend element is a caption to a fieldset element.
 */
class CXHLegend extends CXHEntityAttrs
{
	public function __construct($vLegend = PXH_EMPTY_STRING)
	{
		parent::__construct("legend", true, $vLegend);
	}
	
	
	/**
	 *	To insert content in the legend element.
	 *
	 *	@param mixed $vContent Content of the legend
	 */
	public function AppendContent($vContent)
	{
		parent::ReplaceContent($vContent);
	}
}


##
#
# <!ELEMENT button %button.content;>  <!-- push button -->
# <!ATTLIST button
#   %attrs
#   name        CDATA          #IMPLIED
#   value       CDATA          #IMPLIED
#   type        (button|submit|reset) "submit"
#   disabled    (disabled)     #IMPLIED
#   tabindex    CDATA       #IMPLIED
#   accesskey   CDATA    #IMPLIED
#   onfocus     CDATA       #IMPLIED
#   onblur      CDATA       #IMPLIED
#   >
/**
 *	Creates a button element
 *
 *	The button element is used to create button controls for forms. Buttons created using the button element are similar in functionality to buttons created using the input element, but offer greater rendering options.
 *	Like other form controls, the button element sends data to the server when a form is submitted. Data is sent as a key-value pair. The key comes from the name attribute and the value comes from the value attribute.
 */
class CXHPushButton extends CXHFieldAttrs
{
	/**
	 *	@var string Holds the value of the default content
	 *	@access private
	 */
	private $_sDefaultContent;


	/**
	 *	@var string Class constant defining a generic button
	 */
	const sTypeButton = 'button';


	/**
	 *	@var string Class constant defining a submit button
	 */
	const sTypeSubmit = 'submit';


	/**
	 *	@var string Class constant defining a reset button
	 */
	const sTypeReset = 'reset';
	

	/**
	 *	@param string $csType Class constant defining the type of the button
	 *	@param string $sIdName Id and name of the element
	 *	@param string $sValue Value of the element
	 *	@param bool $bIsDisabled Indicates if the element is disabled
	 *	@param mixed $vContent Initial content of the element
	 */
	public function __construct($csType, $sIdName, $sValue, $bIsDisabled = false, $vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("button", $vContent, $bIsDisabled, true);
		
		switch ($csType)
		{
			case self::sTypeButton:
			case self::sTypeSubmit:
			case self::sTypeReset:
				$this->_sDefaultContent = $csType;
			break;
			default:
				throw new XHException("Type of button is not one of the class constants");
		}
		
		parent::AddAttr("type", $csType);
		parent::AddAttr("name", $sIdName);
		parent::AddAttr("value", $sValue);
		
		parent::SetId($sIdName);
		
		if (!_sl($vContent))
			parent::AppendContent($this->_sDefaultContent);
	}	
}


# <!--======================= Tables =======================================-->

##
#
# <!ELEMENT table
#      (caption?, (col*|colgroup*), thead?, tfoot?, (tbody+|tr+))>
# <!ATTLIST table
#   %attrs
#   summary     CDATA         #IMPLIED
#   width       CDATA       #IMPLIED
#   border      CDATA       #IMPLIED
#   frame       (void|above|below|hsides|lhs|rhs|vsides|box|border)       #IMPLIED
#   rules       (none | groups | rows | cols | all)       #IMPLIED
#   cellspacing CDATA       #IMPLIED
#   cellpadding CDATA       #IMPLIED
#   >
/**
 *	Creates a table element
 *
 *	The table element is used to define a table. A table is a construct where data is organized into rows and columns of cells.
 *
 *	@todo To test[3]
 */
class CXHTable extends CXHEntityAttrs
{
	/**
	 *	@param object $oCXHTableContent A content of the table
	 *	@param object $oCXHCaption The table caption
	 */
	public function __construct($oCXHTableContent = PXH_NULL_OBJECT, $oCXHCaption = PXH_NULL_OBJECT)
	{
		parent::__construct("table");

		$this->_oCaption = PXH_NULL_OBJECT;
		$this->_aCols = array();
		$this->_oTHead = PXH_NULL_OBJECT;
		$this->_oTFoot = PXH_NULL_OBJECT;
		$this->_aTBody = array();
		
		if (!_in($oCXHTableContent))
			$this->AppendContent($oCXHTableContent);

		if (!_in($oCXHCaption))
			$this->AppendContent($oCXHCaption);
	}
	

	/**
	 *	Replaces the table caption
	 *
	 *	@param object $oCXHTableCaption The table caption
	 */
	public function ReplaceCaption($oCXHTableCaption)
	{
		$this->AppendContent($oCXHTableCaption);
	}
	

	/**
	 *	Appends a col element
	 *
	 *	@param object $oCXHCol An instance of CXHCol or CXHColGroup
	 */
	public function AppendCols($oCXHCol)
	{
		$this->AppendContent($oCXHCol);
	}
	

	/**
	 *	Replaces the thead element
	 *
	 *	@param object $oCXHTableHead An instance of CXHTableHead
	 */
	public function ReplaceHead($oCXHTableHead)
	{
		$this->AppendContent($oCXHTableHead);
	}
	

	/**
	 *	Appends a tbody element
	 *
	 *	@param object $oCXHTableBody An instance of CXHTableBody
	 */
	public function AppendBody($oCXHTableBody)
	{
		$this->AppendContent($oCXHTableBody);
	}
	

	/**
	 *	Replaces a tfoot element
	 *
	 *	@param object $oCXHTableFoot An instance of CXHTableFoot
	 */
	public function ReplaceFoot($oCXHTableFoot)
	{
		$this->AppendContent($oCXHTableFoot);
	}
	

	/**
	 *	Appends table content elements
	 *
	 *	@param mixed $vContent A table content element 
	 */
	public function AppendContent($vContent)
	{
		if (_io($vContent, 'CXHRow'))
		{
			$this->_aTBody[] = $vContent;
		}
		else if (_io($vContent, 'CXHCaption'))
		{
			$this->_oCaption = $vContent;
		}
		else if (_io($vContent, 'CXHColGroup'))
		{
			$this->_aCols[] = $vContent;
		}
		else if (_io($vContent, 'CXHCol'))
		{
			$this->_aCols[] = $vContent;
		}
		else if (_io($vContent, 'CXHTableHead'))
		{
			$this->_oTHead = $vContent;
		}
		else if (_io($vContent, 'CXHTableBody'))
		{
			$this->_aTBody[] = $vContent;
		}
		else if (_io($vContent, 'CXHTableFoot'))
		{
			$this->_oTFoot = $vContent;
		}
		else
		{
			throw new XHException("Parameter is not a valid type");
		}
	}
	

	/**
	 *	Sets table cell spacing
	 *
	 *	@param string $sValue Value of spacing
	 */
	public function SetCellspacing($sValue)
	{
		$this->AddAttr("cellspacing", $sValue);
	}
	

	/**
	 *	Sets table cell padding
	 *
	 *	@param string $sValue Value of padding
	 */
	public function SetCellpadding($sValue)
	{
		$this->AddAttr("cellpadding", $sValue);
	}
	
	
	/**
	 *	Generates markup
	 *
	 *	@return string
	 */
	protected function _Generate()
	{
		if (!_in($this->_oCaption))
			parent::AppendContent($this->_oCaption);

		foreach ($this->_aCols as $oCol)
		{
			parent::AppendContent($oCol);
		}

		if (!_in($this->_oTHead))
			parent::AppendContent($this->_oTHead);

		if (!_in($this->_oTFoot))
			parent::AppendContent($this->_oTFoot);

		foreach ($this->_aTBody as $oBody)
		{
			parent::AppendContent($oBody);
		}
		
		return parent::__toString();
	}
	
	/**
	 *  (caption?, (col*|colgroup*), thead?, tfoot?, (tbody+|tr+))
	 *
	 *	@return string
	 */
	public function __toString()
	{
		return self::_Generate();
	}
}


##
#
# <!ELEMENT caption  %Inline;>
# <!ATTLIST caption
#   %attrs
#   >
/**
 *	Creates a caption element
 *
 *	The caption element creates a caption for a table. If a caption is to be used, it should be the first element after the opening table element.
 *
 *	@todo To test[3]
 */
class CXHCaption extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Initial content of the caption element
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("caption", true, $vContent);
	}
}


##
#
# <!ELEMENT thead    (tr)+>
# <!ATTLIST thead
#   %attrs
#   %cellhalign
#   %cellvalign
#   >
/**
 *	Creates a thead element
 *
 *	The thead element can be used to group table rows that contain table header information. This can be useful when printing long tables that span several printed pages, since the data in thead will be repeated on each page.
 *
 *	@todo To test[3]
 */
class CXHTableHead extends CXHTableAlignAttrs
{
	/**
	 *	@param object $oCXHRow An instance of CXHRow
	 */
	public function __construct($oCXHRow = PXH_NULL_OBJECT)
	{
		parent::__construct("thead");
		
		if (!_in($oCXHRow))
		{
			$this->AppendContent($oCXHRow);
		}
	}
	

	/**
	 *	Appends a tr element
	 *
	 *	@param object $oCXHRow An instance of CXHRow
	 */
	public function AppendRow($oCXHRow)
	{
		$this->AppendContent($oCXHRow);
	}
	

	/**
	 *	Appends a tr element
	 *
	 *	@param object $oCXHRow An instance of CXHRow
	 */
	public function AppendContent($oContent)
	{
		if (_io($oContent, 'CXHRow'))
		{
			parent::AppendContent($oContent);
		}
		else
			throw new XHException("Parameter is not of type CXHRow");
	}
}


##
#
# <!ELEMENT tfoot    (tr)+>
# <!ATTLIST tfoot
#   %attrs
#   %cellhalign
#   %cellvalign
#   >
/**
 *	Creates a tfoot elelement
 *
 *	The tfoot element can be used to group table rows that contain table footer information. This may be useful when printing longer tables that span several printed pages, since the data in tfoot is repeated on each page. The tfoot element should appear before tbody elements.
 *
 *	@todo To test[3]
 */
class CXHTableFoot extends CXHTableAlignAttrs
{
	/**
	 *	@param object $oCXHRow An instance of CXHRow
	 */
	public function __construct($oCXHRow = PXH_NULL_OBJECT)
	{
		parent::__construct("tfoot");
		
		if (!_in($oCXHRow))
		{
			$this->AppendContent($oCXHRow);
		}
	}
	

	/**
	 *	Appends a tr element
	 *
	 *	@param object $oCXHRow An instance of CXHRow
	 */
	public function AppendRow($oCXHRow)
	{
		$this->AppendContent($oCXHRow);
	}
	

	/**
	 *	Appends a tr element
	 *
	 *	@param object $oCXHRow An instance of CXHRow
	 */
	public function AppendContent($vContent)
	{
		if (_io($vContent, 'CXHRow'))
		{
			parent::AppendContent($vContent);
		}
		else
			throw new XHException("Parameter is not of type CXHRow");
	}
}


##
#
# <!ELEMENT tbody    (tr)+>
# <!ATTLIST tbody
#   %attrs
#   %cellhalign
#   %cellvalign
#   >
/**
 *	Creates a tbody element
 *
 *	The tbody element can be used to group table data rows. This can be useful when a Web browser supports scrolling of table rows in longer tables. Multiple tbody elements can be used for independent scrolling.
 */
class CXHTableBody extends CXHTableAlignAttrs
{
	/**
	 *	@param object $oCXHRow An instance of CXHRow
	 */
	public function __construct($oCXHRow = PXH_NULL_OBJECT)
	{
		parent::__construct("tbody");
		
		if (!_in($oCXHRow))
		{
			$this->AppendContent($oCXHRow);
		}
	}
	

	/**
	 *	Appends a tr element
	 *
	 *	@param object $oCXHRow An instance of CXHRow
	 */
	public function AppendRow($oCXHRow)
	{
		$this->AppendContent($oCXHRow);
	}


	/**
	 *	Appends a tr element
	 *
	 *	@param object $oCXHRow An instance of CXHRow
	 */
	public function AppendContent($vContent)
	{
		if (_io($vContent, 'CXHRow'))
		{
			parent::AppendContent($vContent);
		}
		else
			throw new XHException("Parameter is not of type CXHRow");
	}
}


##
#
# <!ELEMENT colgroup (col)*>
# <!ATTLIST colgroup
#   %attrs
#   span        CDATA       "1"
#   width       CDATA  #IMPLIED
#   %cellhalign
#   %cellvalign
#   >
/**
 *	Creates a colgroup element
 *
 *	The colgroup element provides a mechanism to apply attributes to a logical conception of a column. The colgroup element is most commonly used to apply table cell alignment using the align and valign attributes, to apply column width using the width attribute, and CSS formatting using the class attribute.
 *	The colgroup element contains col elements that represent individual columns.
 *
 *	@todo To test[3]
 */
class CXHColGroup extends CXHColAttrs
{
	public function __construct()
	{
		parent::__construct("colgroup");
	}
	

	/**
	 *	Appends a col element
	 *
	 *	@param object $oCXHCol An instance of CXHCol
	 */
	public function AppendCol($oCXHCol)
	{
		$this->AppendContent($oCXHCol);
	}
	

	/**
	 *	Appends a col element
	 *
	 *	@param object $oContent An instance of CXHCol
	 */
	public function AppendContent($oContent)
	{
		if (_io($oContent, 'CXHCol'))
			parent::AppendContent($oContent);
		else
			throw new XHException("Parameter is not of type CXHCol");
	}
}


##
#
# <!ELEMENT col      EMPTY>
# <!ATTLIST col
#   %attrs
#   span        CDATA       "1"
#   width       CDATA  #IMPLIED
#   %cellhalign
#   %cellvalign
#   >
/**
 *	Creates a col element
 *
 *	The col element provides a mechanism to apply attributes to a logical conception of a column. The col element is most commonly used to apply table cell alignment using the align and valign attributes, to apply column width using the width attribute, and CSS formatting using the class attribute.
 *
 *	@todo To test[3]
 */
class CXHCol extends CXHColAttrs
{
	/**
	 *	@param string $sHAlign Horizontal alignment value
	 *	@param string $sVAlign Vertical alignment value
	 *	@param string $sWidth Column width
	 *	@param string $sSpan Column spanning value
	 */
	public function __construct($csHAlign = CXHTableAlignAttrs::sHALeft, $csVAlign = CXHTableAlignAttrs::sVAMiddle, $sWidth = PXH_EMPTY_STRING, $sSpan = "1")
	{
		parent::__construct("col", false);
		
		parent::SetHAlign($csHAlign);
		parent::SetVAlign($csVAlign);
		if (_sl((string) $sWidth)) parent::SetWidth($sWidth);
		parent::SetSpan($sSpan);
	}
}


##
#
# <!ELEMENT tr       (th|td)+>
# <!ATTLIST tr
#   %attrs
#   %cellhalign
#   %cellvalign
#   >
/**
 *	Creates a tr element
 *
 *	The tr element defines a table row.
 */
class CXHRow extends CXHEntityAttrs
{
	/**
	 *	@param object $oCXHCell An instance of CXHCell
	 */
	public function __construct($oCXHCell = PXH_NULL_OBJECT)
	{
		parent::__construct("tr");
		
		if (!_in($oCXHCell))
		{
			$this->AppendContent($oCXHCell);
		}
	}
	

	/**
	 *	Appends a td element
	 *
	 *	@param object $oCXHCell An instance of CXHCell
	 */
	public function AppendCell($oCXHCell)
	{
		$this->AppendContent($oCXHCell);
	}
	

	/**
	 *	Appends a td element
	 *
	 *	@param object $oContent An instance of CXHCell
	 */
	public function AppendContent($oContent)
	{	
		if (_io($oContent, 'CXHCell') || _io($oContent, 'CXHCellHead'))
		{
			parent::AppendContent($oContent);
		}
		else
			throw new XHExcecption("Parameter is not of type CXHCell or CXHCellHeader");
	}
}


##
#
# <!ELEMENT th       %Flow;>
# <!ATTLIST th
#   %attrs
#   abbr        CDATA         #IMPLIED
#   axis        CDATA          #IMPLIED
#   headers     IDREFS         #IMPLIED
#   scope       (row|col|rowgroup|colgroup)        #IMPLIED
#   rowspan     CDATA       "1"
#   colspan     CDATA       "1"
#   %cellhalign
#   %cellvalign
#   >
/**
 *	Creates a th element
 *
 *	The th element defines a table header cell.
 *
 *	@todo To test[3]
 */
class CXHCellHead extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Initial content of the element
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("th");
		
		if (!_es($vContent)) parent::AppendContent($vContent);
	}
	

	/**
	 *	Sets the row spanning
	 *
	 *	@param string $sValue Row spanning value
	 */
	public function SetRowspan($sValue)
	{
		$this->AddAttr("rowspan", $sValue);
	}
	

	/**
	 *	Sets the Column spanning
	 *
	 *	@param string $sValue Col spanning value
	 */
	public function SetColspan($sValue)
	{
		$this->AddAttr("colspan", $sValue);
	}
}


##
#
# <!ELEMENT td       %Flow;>
# <!ATTLIST td
#   %attrs
#   abbr        CDATA         #IMPLIED
#   axis        CDATA          #IMPLIED
#   headers     IDREFS         #IMPLIED
#   scope       (row|col|rowgroup|colgroup)        #IMPLIED
#   rowspan     CDATA       "1"
#   colspan     CDATA       "1"
#   %cellhalign
#   %cellvalign
#   >
/**
 *	Creates a td element
 *
 *	The td element defines a data cell in a table (i.e. cells that are not header cells).
 */
class CXHCell extends CXHEntityAttrs
{
	/**
	 *	@param mixed $vContent Initial content of the element
	 */
	public function __construct($vContent = PXH_EMPTY_STRING)
	{
		parent::__construct("td");
		
		if (!_es($vContent)) parent::AppendContent($vContent);
	}
	

	/**
	 *	Sets the row spanning
	 *
	 *	@param string $sValue Row spanning value
	 */
	public function SetRowspan($sValue)
	{
		$this->AddAttr("rowspan", $sValue);
	}
	

	/**
	 *	Sets the Column spanning
	 *
	 *	@param string $sValue Col spanning value
	 */
	public function SetColspan($sValue)
	{
		$this->AddAttr("colspan", $sValue);
	}
}


?>