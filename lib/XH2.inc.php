<?php


/**
 *
 *	@package [2]XHTMLEntities
 *	@version 0.0
 *	@license http://creativecommons.org/licenses/by/3.0/ cc by
 *
 *	@copyright Copyright (c) 2010 Serafim Junior Dos Santos Fagundes Cyb3r Networks
 *	@author Serafim Junior Dos Santos Fagundes <serafim@cyb3r.ca>
 *
 *
 *	The second level of abstraction of the XPiD Library.
 *	
 *	This file contains the code elements of the second level of abstraction of the XPiD Library.
 *
 *	The idea of this level is to extend the 1st level, .
 */

 
require_once("XH1.inc.php");


/**
 *	Exception class for the XH level
*/
class XHException extends Exception
{
	/**
	 *	@param string $sMessage Message of the exception
	 */
 	public function __construct($sMessage)
	{
		parent::__construct($sMessage);
	}
}


/**
 *  Creates an HTML/XHTML comment
 */
class CXHComment
{
	/**
	 *	@var string Holds the comment content
	 */
	private $_sContent;
	
	
	/**
	 *	@var string Holds the new line caracters
	 */
	private $sNL;
	
	
	/**
	 *	@var string Holds the tab caracter
	 */
	private $sTAB;


	/**
	 *	@param string $sContent String passed as the initial content of the class
	 */
	public function __construct($sContent = "")
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
	 *	@return string
	 */
	public function __toString()
	{
		$sML = $this->sNL."<!--".$this->_sContent.$this->sNL."//-->".$this->sNL;

		return $sML;
	}
}


# <!--=================== Generic Attributes ===============================-->

# <!ENTITY % i18n
#  "lang        CDATA #IMPLIED
#   xml:lang    CDATA #IMPLIED
#   dir         (ltr|rtl)      #IMPLIED"
#   >
/**
 *  Internationalization entity attributes abstraction class
 */
abstract class CXHEntityIntl extends CMLEntity
{
	/**
	 *	@var array Hash array holding the entity attributes; the keys holds the names and the values the attribute values
	 */
	private $_hAttrs1;
	
	
	/**
	 *	@var string Defines a left to right command
	 */
	const sDirLTR = 'ltr';
	
	
	/**
	 *	@var string Defines a right to left command
	 */
	const sDirRTL = 'rtl';
	
	
	/**
	 *	@param string $sTagName String for the entity tag name
	 *	@param bool $bHasEnd Variable defining if the entity has a full end or a self closed end
	 *	@param string $sContent Variable for the initial entity content
	 */
	public function __construct($sTagName, $bHasEnd = true, $sContent = PWL_EMPTY_STRING)
	{	
		parent::__construct($sTagName, $bHasEnd, $sContent);
		
		$this->_hAttrs1 = array();
	}
	
	
	/**
	 *	@param string $sLang String for the language of the document; short code
	 */
	public function SetLang($sLang)
	{
		$this->_hAttrs1["lang"] = $sLang;
		$this->_hAttrs1["xml:lang"] = $sLang;
	}
	
	
	/**
	 *	@param string $csDir String constant defining the text direction
	 */
	 public function SetDir($csDir)
	 {
		$this->_hAttrs1["dir"] = $cDir;
	 }
	
	
	/**
	 *	@return string
	 */
	public function __toString()
	{
		parent::AddAttrs($this->_hAttrs1);

		return parent::__toString();
	}
}


# <!ENTITY % coreattrs
#  "id          ID             #IMPLIED
#   class       CDATA          #IMPLIED
#   style       CDATA   #IMPLIED
#   title       CDATA         #IMPLIED"
#   >
/**
 *	Core entity attributes abstraction class
 */
abstract class CXHEntityCoreAttrs extends CMLEntity
{
	/**
	 *	@var array Holds the style list of the entity
	 */
	private $_asStyles1;


	/**
	 *	@var array Holds the attributes of the entity
	 */
	private $_hsAttrs3;


	/**
	 *	@param string $sTagName String for the entity tag name
	 *	@param bool $bHasEnd Variable defining if the entity has a full end or a self closed end
	 *	@param string $sContent Variable for the initial entity content
	 */
	public function __construct($sTagName, $bHasEnd = true, $sContent = PWL_EMPTY_STRING)
	{
		parent::__construct($sTagName, $bHasEnd, $sContent);
		
		$this->_asStyles1 = array();
		$this->_hsAttrs3 = array();
	}


	/**
	 *	Adds a style to the entity
	 *
	 *	@param string Name of the style
	 *	@param string Value of the style
	 */
	public function AddStyle($sName, $sValue)
	{
		$this->_asStyles1[$sName] = $sValue;
	}
	
	
	/**
	 *	Sets the id of the entity
	 *
	 *	@param string Id of the entity
	 */
	public function SetId($sId)
	{
		$this->_hsAttrs3["id"] = $sId;
	}
	
	
	/**
	 *	@todo To document
	 */
	public function GetId()
	{
		$sId = PWL_EMPTY_STRING;
		
		if (array_key_exists("id", $this->_hsAttrs3))
			$sId = $this->_hsAttrs3["id"];
			
		return $sId;
	}


	/**
	 *	Sets the class of the entity
	 *
	 *	@param string Class of the entity
	 */
	public function SetClass($sClass)
	{
		$this->_hsAttrs3["class"] = $sClass;
	}
	
	
	/**
	 *	@todo To document
	 */
	public function GetClass()
	{
		$sClass = PWL_EMPTY_STRING;
	
		if (array_key_exists("class", $this->_hsAttrs3))
			$sClass = $this->_hsAttrs3["class"];
		
		return $sClass;
	}


	/**
	 *	Sets the title of the entity
	 *
	 *	@param string Title of the entity
	 */
	public function SetTitle($sTitle)
	{
		$this->_hsAttrs3["title"] = $sTitle;
	}


	/**
	 *	Assembles the style attribute and adds the attribute to the attribute array $_hsAttrs2
	 */
	private function _generateStylesString()
	{
		$sTemp = PWL_EMPTY_STRING;

		foreach ($this->_asStyles1 as $sN => $sV)
		{
			if (_sl($sV))
			{
				$sTemp .= $sN.":".$sV.";";
			}
		}

		if (_sl($sTemp))
		{
			$this->_hsAttrs3["style"] = $sTemp;
		}
	}


	/**
	 *	@return string
	 */
	public function __toString()
	{
		$this->_generateStylesString();
	
		parent::AddAttrs($this->_hsAttrs3);

		return parent::__toString();
	}
}


##
# <!ENTITY % events
#  "onclick     CDATA       #IMPLIED
#   ondblclick  CDATA       #IMPLIED
#   onmousedown CDATA       #IMPLIED
#   onmouseup   CDATA       #IMPLIED
#   onmouseover CDATA       #IMPLIED
#   onmousemove CDATA       #IMPLIED
#   onmouseout  CDATA       #IMPLIED
#   onkeypress  CDATA       #IMPLIED
#   onkeydown   CDATA       #IMPLIED
#   onkeyup     CDATA       #IMPLIED"
#   >
##
# <!ENTITY % attrs "%coreattrs %i18n %events">
/**
 *  Entity attributes abstraction class
 */
abstract class CXHEntityAttrs extends CXHEntityIntl
{
	/**
	 *	@var array Holds the style list of the entity
	 */
	private $_asStyles;


	/**
	 *	@var array Holds the attributes of the entity
	 */
	private $_hsAttrs2;


	/**
	 *	@param string $sTagName String for the entity tag name
	 *	@param bool $bHasEnd Variable defining if the entity has a full end or a self closed end
	 *	@param string $sContent Variable for the initial entity content
	 */
	public function __construct($sTagName, $bHasEnd = true, $sContent = PWL_EMPTY_STRING)
	{	
		parent::__construct($sTagName, $bHasEnd, $sContent);
		
		$this->_asStyles = array();
		$this->_hsAttrs2 = array();
		
		$this->_aValidEvents = array("onclick","ondblclick","onmousedown","onmouseup","onmouseover","onmousemove","onmouseout","onkeypress","onkeydown","onkeyup");
	}


	/**
	 *	Registers an event for late validation
	 *
	 *	@param string Event name
	 */
	protected function _RegisterEvent($sEventName)
	{
		$this->_aValidEvents[] = $sEvventName;
	}


	/**
	 *	Adds a style to the entity
	 *
	 *	@param string Name of the style
	 *	@param string Value of the style
	 */
	public function AddStyle($sName, $sValue)
	{
		$this->_asStyles[$sName] = $sValue;
	}


	/**
	 *	Adds an event to the entity
	 *
	 *	@param string Name of the event
	 *	@param string Value of the event
	 */
	public function AddEvent($sName, $sValue)
	{
		if (in_array($sName, $this->_aValidEvents))
		{
			$this->_hsAttrs2[$sName] = $sValue;
		}
		else
			throw new XHException("Event $sName is not a valid XHTML strict event");
	}


	/**
	 *	Sets the id of the entity
	 *
	 *	@param string Id of the entity
	 */
	public function SetId($sId)
	{
		$this->_hsAttrs2["id"] = $sId;
	}
	
	
	/**
	 *	@todo To document
	 */
	public function GetId()
	{
		$sId = PWL_EMPTY_STRING;
		
		if (array_key_exists("id", $this->_hsAttrs2))
			$sId = $this->_hsAttrs2["id"];
			
		return $sId;
	}
	

	/**
	 *	Sets the class of the entity
	 *
	 *	@param string Class of the entity
	 */
	public function SetClass($sClass)
	{
		$this->_hsAttrs2["class"] = $sClass;
	}
	
	
	/**
	 *	@todo To document
	 */
	public function GetClass()
	{
		$sClass = PWL_EMPTY_STRING;
	
		if (array_key_exists("class", $this->_hsAttrs2))
			$sClass = $this->_hsAttrs2["class"];
		
		return $sClass;
	}
	

	/**
	 *	Sets the title of the entity
	 *
	 *	@param string Title of the entity
	 */
	public function SetTitle($sTitle)
	{
		$this->_hsAttrs2["title"] = $sTitle;
	}


	/**
	 *	Assembles the style attribute and adds the attribute to the attribute array $_hsAttrs2
	 */
	private function _generateStylesString()
	{
		$sTemp = PWL_EMPTY_STRING;

		foreach ($this->_asStyles as $sN => $sV)
		{
			if (_sl($sV))
			{
				$sTemp .= $sN.":".$sV.";";
			}
		}

		if (_sl($sTemp))
		{
			$this->_hsAttrs2["style"] = $sTemp;
		}
	}


	/**
	 *	@return string
	 */
	public function __toString()
	{
		$this->_generateStylesString();
		
		parent::AddAttrs($this->_hsAttrs2);

		return parent::__toString();
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
	 *	@todo To document
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
##
#
# <!ELEMENT title (#PCDATA)>
# <!ATTLIST title %i18n>
##
/**
 *	Creates a title element.
 */
class CXHTitle extends CMLEntity
{
	public function __construct($sTitle = PWL_EMPTY_STRING)
	{
		parent::__construct("title", true, $sTitle);
	}
	
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
 *	Creates a head element.
 *
 *	The head element contains information about the current document, such as its title, keywords that may be useful to search engines, and other data that is not considered to be document content. This information is usually not displayed by browsers.
 */
class CXHHead extends CXHEntityIntl
{
	/**
	 *	@todo To document
	 */
	public function __construct($sEncoding, $sTitle = PWL_EMPTY_STRING, $sBaseHref = PWL_EMPTY_STRING)
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
		
		$oEncoding = new CXHMeta("Content-Type", PWL_EMPTY_STRING, "text/html;charset=".$sEncoding);		
		
		$this->AppendContent($oEncoding);
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
	 *	@todo To document
	 */
	public function __construct($sHttpEquiv = PWL_EMPTY_STRING, $sName = PWL_EMPTY_STRING, $sContent = PWL_EMPTY_STRING)
	{
		parent::__construct("meta", false);
		
		if (_sl($sHttpEquiv)) $this->AddAttr("http-equiv", $sHttpEquiv);
		if (_sl($sName)) $this->AddAttr("name", $sName);
		if (_sl($sContent)) $this->AddAttr("content", $sContent);
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
	 *	@todo To document
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
 *	Creates a link or a style element.
 *
 *	The link element conveys relationship information that can be used by Web browsers and search engines. You can have multiple link elements that link to different resources or describe different relationships. The link elements can be contained in the head element.
 *	The style element can contain CSS rules (called embedded CSS) or a URL that leads to a file containing CSS rules (called external CSS).
 *	
 *	@todo Put this class in H2 and create element style
 */
class CXHCSS extends CXHEntityIntl
{
	/**
	 *	@todo To document
	 */
	public function __construct($sFileURL = PWL_EMPTY_STRING, $sMedia = "screen")
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
	 *	@todo To document
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
	 *	@todo To document
	 */
	public function __construct($sScriptLanguage, $sFileURL = PWL_EMPTY_STRING)
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
	 *	@todo To document
	 */
	public function AppendFileContent($sFileName)
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
	 *	@todo To document
	 */
	private $_sContent;


	/**
	 *	@todo To document
	 */
	public function __construct($sContent = PWL_EMPTY_STRING)
	{
		parent::__construct("noscript");
		
		if (_sl((string) $sContent))
			parent::AppendContent($sContent);
		else
			parent::AppendContent("This document uses a script. If you see this message it means that your user agent/browser doesn't run scripts and this document may not render as appropriate. Please enable scripts or use a user agent/browser that has scripting functionality enabled.");
	}
	

	/**
	 *	@todo To document
	 */
	public function AppendContent($sContent)
	{
		throw new XHException("Cannot use AppendContent with CXHNoScript");
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
	/**
	 *	@todo To document
	 */
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
	 *	@todo To document
	 */
	public function __construct($vContent = PWL_EMPTY_STRING)
	{
		parent::__construct("div");
		
		if (_sl((string) $vContent))
			$this->AppendContent($vContent);
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
	 *	@todo To document
	 */
	public function __construct($sContent = PWL_EMPTY_STRING)
	{
		parent::__construct("p");
		
		if (_sl((string) $sContent))
			$this->AppendContent($sContent);
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
	 *	@todo To document
	 */
	const iLvl1 = 1;


	/**
	 *	@todo To document
	 */
	const iLvl2 = 2;


	/**
	 *	@todo To document
	 */
	const iLvl3 = 3;


	/**
	 *	@todo To document
	 */
	const iLvl4 = 4;


	/**
	 *	@todo To document
	 */
	const iLvl5 = 5;


	/**
	 *	@todo To document
	 */
	const iLvl6 = 6;
	

	/**
	 *	@todo To document
	 */
	public function __construct($iLevel = self::iLvl1, $sContent = PWL_EMPTY_STRING)
	{
		if ($iLevel >= self::iLvl1 && $iLevel <= self::iLvl6)
		{
			switch ($iLevel)
			{
				case self::iLvl1:
					parent::__construct("h1", true, $sContent);
				break;
				case self::iLvl2:
					parent::__construct("h2", true, $sContent);
				break;
				case self::iLvl3:
					parent::__construct("h3", true, $sContent);
				break;
				case self::iLvl4:
					parent::__construct("h4", true, $sContent);
				break;
				case self::iLvl5:
					parent::__construct("h5", true, $sContent);
				break;
				case self::iLvl6:
					parent::__construct("h6", true, $sContent);
				break;
			}
		}
		else
			throw new XHException("\$iLevel of CXHHeading is not an inner constant");
	}
}


# <!--=================== Lists ============================================-->
/**
 *	@todo To document
 *	@todo To test
 */
abstract class CXHList extends CXHEntityAttrs
{
	/**
	 *	@todo To document
	 */
	public function __construct($sTagName)
	{
		parent::__construct($sTagName);
	}
	
	
	/**
	 *	@todo To document
	 */
	public function AddItem($vContent)
	{
		$oCXHItem = new CXHItem($vContent);
	
		$this->AppendContent($vContent);
	}
	
	
	/**
	 *	@todo To document
	 */
	public function InsertItem($oCXHItem)
	{
		$this->AppendContent($oCXHItem);
	}
	
	
	/**
	 *	@todo To document
	 */
	public function AppendContent($vContent)
	{
		if (_io($vContent, 'CXHItem'))
			parent::AppendContent($vContent);
		else
			throw new XHException("Parameter is not an instance of CXHItem");
	}
}


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
 *	@todo To test
 */
class CXHUnorderedList extends CXHList
{
	/**
	 *	@todo To document
	 */
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
 *	@todo To test
 */
class CXHOrderedList extends CXHList
{
	/**
	 *	@todo To document
	 */
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
 *	@todo To test
 */
class CXHItem extends CXHEntityAttrs
{
	/**
	 *	@todo To document
	 */
	public function __construct($vContent = PWL_EMPTY_STRING)
	{
		parent::__construct("li");
		
		if (_sl((string) $vContent))
			parent::AppendContent($vContent);
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
 *	@todo To test
 */
class CXHDefList extends CXHEntityAttrs
{
	/**
	 *	@todo To document
	 */
	public function __construct()
	{
		parent::__construct("dl");
	}


	/**
	 *	@todo To document
	 */
	public function AddTerm($vContent)
	{
		$oCXHTerm = new CXHTerm($vContent);
		
		$this->AppendContent($oCXHTerm);
	}
	

	/**
	 *	@todo To document
	 */
	public function InsertTerm($oCXHTerm)
	{
		$this->AppendContent($oCXHTerm);
	}
	

	/**
	 *	@todo To document
	 */
	public function AddDef($vContent)
	{
		$oCXHDef = new CXHDef($vContent);
		
		$this->AppendContent($oCXHDef);
	}
	

	/**
	 *	@todo To document
	 */
	public function InsertDef($oCXHDef)
	{
		$this->AppendContent($oCXHDef);
	}
	

	/**
	 *	@todo To document
	 */
	public function AppendContent($vContent)
	{
		if (_io($vContent, 'CXHTerm'))
			parent::AppendContent($vContent);
		else
			if (_io($vContent, 'CXHDef'))
				parent::AppendContent($vContent);
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
 *	@todo To test
 */
class CXHTerm extends CXHEntityAttrs
{
	/**
	 *	@todo To document
	 */
	public function __construct($vContent = PWL_EMPTY_STRING)
	{
		parent::__construct("dt");
		
		if (_sl((string) $vContent))
			parent::AppendContent($vContent);
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
 *	@todo To test
 */
class CXHDef extends CXHEntityAttrs
{
	/**
	 *	@todo To document
	 */
	public function __construct($vContent = PWL_EMPTY_STRING)
	{
		parent::__construct("dd");
		
		if (_sl((string) $vContent))
			parent::AppendContent($vContent);
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
 *	@todo To test
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
class CXHSep extends CXHEntityAttrs
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
	 *	@param bool $bPreserve Indicates space is preserved when true; defaults to false
	 */
	public function __construct($vContent = PWL_EMPTY_STRING, $bPreserve = false)
	{
		parent::__construct("pre");

		if (_sl($vContent))
			parent::AppendContent($vContent);
		
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

# <!--=================== Inserted/Deleted Text ============================-->

##
#
# <!ELEMENT ins %Flow;>
# <!ATTLIST ins
#   %attrs
#   cite        CDATA          #IMPLIED
#   datetime    CDATA     #IMPLIED
#   >

##
#
# <!ELEMENT del %Flow;>
# <!ATTLIST del
#   %attrs
#   cite        CDATA          #IMPLIED
#   datetime    CDATA     #IMPLIED
#   >

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
	public function __construct($sHRef, $vContent = PWL_EMPTY_STRING, $sTitle = PWL_EMPTY_STRING, $sTarget = PWL_EMPTY_STRING)
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
	public function __construct()
	{
		parent::__construct("span");
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
	 *	@param string $sDir One of the constants indicating the direction of text
	 */
	public function __construct($sDir)
	{
		parent::__construct("bdo");
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
 */
class CXHEmphasis extends CXHEntityAttrs
{
	public function __construct($vContent)
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
 */
class CXHStrong extends CXHEntityAttrs
{
	public function __construct($vContent)
	{
		parent::__construct("strong", true, $vContent);
	}
}


##
#
# <!ELEMENT dfn %Inline;>   <!-- definitional -->
# <!ATTLIST dfn %attrs>

##
#
# <!ELEMENT code %Inline;>   <!-- program code -->
# <!ATTLIST code %attrs>

##
#
# <!ELEMENT samp %Inline;>   <!-- sample -->
# <!ATTLIST samp %attrs>

##
#
# <!ELEMENT kbd %Inline;>  <!-- something user would type -->
# <!ATTLIST kbd %attrs>

##
#
# <!ELEMENT var %Inline;>   <!-- variable -->
# <!ATTLIST var %attrs>

##
#
# <!ELEMENT cite %Inline;>   <!-- citation -->
# <!ATTLIST cite %attrs>

##
#
# <!ELEMENT abbr %Inline;>   <!-- abbreviation -->
# <!ATTLIST abbr %attrs>

##
#
# <!ELEMENT acronym %Inline;>   <!-- acronym -->
# <!ATTLIST acronym %attrs>

##
#
# <!ELEMENT q %Inline;>   <!-- inlined quote -->
# <!ATTLIST q
#   %attrs
#   cite        CDATA          #IMPLIED
#   >

##
#
# <!ELEMENT sub %Inline;> <!-- subscript -->
# <!ATTLIST sub %attrs>

##
#
# <!ELEMENT sup %Inline;> <!-- superscript -->
# <!ATTLIST sup %attrs>

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
	public function __construct()
	{
		parent::__construct("tt");
	}
}


##
#
# <!ELEMENT i %Inline;>   <!-- italic font -->
# <!ATTLIST i %attrs>

##
#
# <!ELEMENT b %Inline;>   <!-- bold font -->
# <!ATTLIST b %attrs>

##
#
# <!ELEMENT big %Inline;>   <!-- bigger font -->
# <!ATTLIST big %attrs>

##
#
# <!ELEMENT small %Inline;>   <!-- smaller font -->
# <!ATTLIST small %attrs>

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
 *	@todo To test
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
 *	@todo To test
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
 *	@todo To document
 */
class CXHImage extends CXHEntityAttrs
{
	/**
	 *	@todo To document
	 */
	public function __construct($sSrc, $sDesc, $sWidth = PWL_EMPTY_STRING, $sHeight = PWL_EMPTY_STRING)
	{
		parent::__construct("img", false);
		
		$this->AddAttr("src", $sSrc);
		$this->AddAttr("alt",$sDesc);
		
		if (_sl($sWidth)) $this->SetWidth($sWidth);
		if (_sl($sHeight)) $this->SetHeight($sHeight);
	}


	/**
	 *	@todo To document
	 */
	public function SetWidth($iWidth)
	{
		$this->AddAttr("width",$iWidth);
	}


	/**
	 *	@todo To document
	 */
	public function SetHeight($iHeight)
	{
		$this->AddAttr("height",$iHeight);
	}
	

	/**
	 *	@todo To document
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
 *	@todo To document
 *	@todo Watch the usage of the class through the interactivity of the base class; technicaly it shouldn't inherit from CXHEntityAttrs
 *	@todo Retest and find the bug and reason for not working
 */
class CXHMap extends CXHEntityAttrs
{
	/**
	 *	@todo To document
	 */
	public function __construct($sId)
	{
		parent::__construct("map");
		
		parent::SetId($sId);
	}
	

	/**
	 *	@todo To document
	 */
	public function AddArea($sHRef, $sAlt, $sShape, $sCoords)
	{
		$oCXHArea = new CXHArea($sHRef, $sAlt, $sShape, $sCoords);
	
		$this->AppendContent($oCXHArea);
	}
	

	/**
	 *	@todo To document
	 */
	public function InsertArea($oCXHArea)
	{
		$this->AppendContent($oCXHArea);
	}
	

	/**
	 *	@todo To document
	 */
	public function AppendContent($vContent)
	{
		if (_io($vContent, 'CMLEntity'))
			parent::AppendContent($vContent);
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
 *	@todo To document
 */
class CXHArea extends CXHEntityAttrs
{
	/**
	 *	@todo To document
	 */
	private $_sHRef;


	/**
	 *	@todo To document
	 */
	private $_sAlt;


	/**
	 *	@todo To document
	 */
	private $_sShape;


	/**
	 *	@todo To document
	 */
	private $_sCoords;


	/**
	 *	@todo To document
	 */
	const sShapeRect =		'rect';


	/**
	 *	@todo To document
	 */
	const sShapeCircle =	'circle';


	/**
	 *	@todo To document
	 */
	const sShapePoly =		'poly';


	/**
	 *	@todo To document
	 */
	const sShapeDefault =	'default';


	/**
	 *	@todo To document
	 */
	public function __construct($sHRef = PWL_EMPTY_STRING, $sAlt = PWL_EMPTY_STRING, $sShape = PWL_EMPTY_STRING, $sCoords = PWL_EMPTY_STRING)
	{
		parent::__construct("area", false);
		
		if (_sl($sHRef)) $this->SetHRef($sHRef);
		if (_sl($sAlt)) $this->SetAlt($sAlt);
		if (_sl($sShape)) $this->SetShape($sShape);
		if (_sl($sCoords)) $this->SetCoords($sCoords);
		
		parent::_RegisterEvent("onfocus");
		parent::_RegisterEvent("onblur");
	}
	

	/**
	 *	@todo To document
	 */
	public function SetHRef($sHRef)
	{
		$this->_sHRef = $sHRef;
		
		parent::AddAttr("href", $sHRef);
	}
	

	/**
	 *	@todo To document
	 */
	public function SetAlt($sAlt)
	{
		$this->_sAlt = $sAlt;
		
		parent::AddAttr("alt", $sAlt);
	}
	

	/**
	 *	@todo To document
	 */
	public function SetShape($sShape)
	{
		$this->_sShape = $sShape;
		
		parent::AddAttr("shape", $sShape);
	}
	

	/**
	 *	@todo To document
	 */
	public function SetCoords($sCoords)
	{
		$this->_sCoords = $sCoords;
		
		parent::AddAttr("coords", $sCoords);
	}
}


# <!--================ Forms ===============================================-->
/**
 *	@todo To document
 */
class CXHFieldAttrs extends CXHEntityAttrs
{
	/**
	 *	@todo To document
	 */
	public function __construct($sTagName, $bHasEnd, $sContent, $bIsDisabled)
	{
		parent::__construct($sTagName, $bHasEnd, $sContent);
		
		parent::_RegisterEvent("onfocus");
		parent::_RegisterEvent("onblur");
		
		if ($bIsDisabled) $this->AddAttr("disabled", "disabled");
	}
}


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
 *	@todo To document
 */
class CXHForm extends CXHEntityAttrs
{
	/**
	 *	@todo To document
	 */
	public function __construct($sAction, $sMethod, $sName = PWL_EMPTY_STRING, $sEnctype = "application/x-www-form-urlencoded")
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
 *	@todo To document
 */
class CXHLabel extends CXHEntityAttrs
{
	/**
	 *	@todo To document
	 */
	public function __construct($sForId, $sContent = PWL_EMPTY_STRING)
	{
		parent::__construct("label");
		
		$this->AddAttr("for", $sForId);
		
		if (_sl($sContent))
			$this->AppendContent($sContent);
		
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
/**
 *	@todo To document
 */
class CXHFieldInput extends CXHFieldAttrs
{
	/**
	 *	@todo To document
	 */
	public function __construct($sIdName, $sValue, $sTagName, $bIsDisabled = false)
	{
		parent::__construct($sTagName, false, "", $bIsDisabled);

		parent::AddAttr("name", $sIdName);
		parent::AddAttr("value", $sValue);
		
		parent::SetId($sIdName);
		
		parent::_RegisterEvent("onselect");
		parent::_RegisterEvent("onchange");
	}
}


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
 *	@todo To document
 */
class CXHFieldText extends CXHFieldAttrs
{
	/**
	 *	@todo To document
	 */
	private $_bIsMultiline;


	/**
	 *	@todo To document
	 */
	public function __construct($sIdName, $sValue = PWL_EMPTY_STRING, $bIsDisabled = false, $bMultiline = false, $sRows = "5", $sCols = "10")
	{
		$this->_bIsMultiline = $bMultiline;
	
		if ($bMultiline == false)
		{
			parent::__construct("input", false, PWL_EMPTY_STRING, $bIsDisabled);	
			
			parent::AddAttr("type", "text");

			parent::AddAttr("value", $sValue);
		}
		else
		{
			parent::__construct("textarea", true, PWL_EMPTY_STRING, $bIsDisabled);
			
			parent::AddAttr("rows", $sRows);
			parent::AddAttr("cols", $sCols);
			
			if (_sl($sValue)) parent::AppendContent($sValue);
		}

		parent::AddAttr("name", $sIdName);
		parent::SetId("id", $sIdName);
		
		parent::_RegisterEvent("onselect");
		parent::_RegisterEvent("onchange");
	}


	/**
	 *	@todo To document
	 */
	public function AppendContent($sContent)
	{
		if ($this->_bIsMultiline)
			parent::AppendContent($sContent);
		else
			throw new XHExcception("Cannot append content in non full ended input text");
	}


	/**
	 *	@todo To document
	 */
	public function ReplaceContent()
	{
		if ($this->_bIsMultiline)
			$this->_oText->AppendContent($sContent);
		else
			throw new XHExcception("Cannot replace content in non full ended input text");
	}
}


/**
 *	@todo To document
 */
class CXHFieldPassword extends CXHFieldInput
{
	/**
	 *	@todo To document
	 */
	public function __construct($sIdName, $sValue = PWL_EMPTY_STRING, $bIsDisabled = false)
	{
		parent::__construct($sIdName, $sValue, "input", PWL_EMPTY_STRING, $bIsDisabled);
		
		$this->AddAttr("type", "password");
	}
}


/**
 *	@todo To document
 */
class CXHFieldCheckbox extends CXHFieldInput
{
	/**
	 *	@todo To document
	 */
	public function __construct($sName, $sId, $sValue = PWL_EMPTY_STRING, $bChecked = false, $bIsDisabled = false)
	{
		parent::__construct($sName, $sValue, "input", PWL_EMPTY_STRING, $bIsDisabled);
		
		parent::SetId($sId);
		
		$this->AddAttr("type", "checkbox");
		
		if ($bChecked) $this->AddAttr("checked", "checked");
	}
}


/**
 *	@todo To document
 */
class CXHFieldRadio extends CXHFieldInput
{
	/**
	 *	@todo To document
	 */
	public function __construct($sName, $sId, $sValue = PWL_EMPTY_STRING, $bChecked = false, $bIsDisabled = false)
	{
		parent::__construct($sName, $sValue, "input", PWL_EMPTY_STRING, $bIsDisabled);
		
		parent::SetId($sId);
		
		$this->AddAttr("type", "radio");
		
		if ($bChecked) $this->AddAttr("checked", "checked");
	}
}


/**
 *	@deprecated
 *	@todo To document
 */
class CXHButtonSubmit extends CXHFieldInput
{
	/**
	 *	@todo To document
	 */
	public function __construct($sIdName, $sValue = "Submit", $bIsDisabled = false)
	{
		parent::__construct($sIdName, $sValue, "input", PWL_EMPTY_STRING, $bIsDisabled);
		
		$this->AddAttr("type", "submit");
	}
}


/**
 *	@deprecated
 *	@todo To document
 */
class CXHButtonReset extends CXHFieldInput
{
	/**
	 *	@todo To document
	 */
	public function __construct($sIdName, $sValue = "Reset", $bIsDisabled = false)
	{
		parent::__construct($sIdName, $sValue, "input", PWL_EMPTY_STRING, $bIsDisabled);
		
		$this->AddAttr("type", "reset");
	}
}


/**
 *	@todo To document
 */
class CXHFieldFile extends CXHFieldInput
{
	/**
	 *	@todo To document
	 */
	public function __construct($sIdName, $bIsDisabled = false)
	{
		parent::__construct($sIdName, PWL_EMPTY_STRING, "input", PWL_EMPTY_STRING, $bIsDisabled);
		
		$this->AddAttr("type", "file");
	}
}


/**
 *	@todo To document
 */
class CXHFieldHidden extends CXHFieldInput
{
	/**
	 *	@todo To document
	 */
	public function __construct($sIdName, $sValue = PWL_EMPTY_STRING, $bIsDisabled = false)
	{
		parent::__construct($sIdName, $sValue, "input", PWL_EMPTY_STRING, $bIsDisabled);
		
		$this->AddAttr("type", "hidden");
	}
}


/**
 *	@todo To document
 */
class CXHFieldImage extends CXHFieldInput
{
	/**
	 *	@todo To document
	 */
	public function __construct($sImageURL, $sAltText, $sIdName, $sValue, $bIsDisabled = false)
	{
		parent::__construct($sIdName, $sValue, "input", PWL_EMPTY_STRING, $bIsDisabled);
		
		$this->AddAttr("type", "image");
		$this->AddAttr("src", $sImageURL);
		$this->AddAttr("alt", $sAltText);
	}
}


/**
 *	@deprecated
 *	@todo To document
 */
class CXHButton extends CXHFieldInput
{
	/**
	 *	@todo To document
	 */
	public function __construct($sIdName, $sValue = PWL_EMPTY_STRING, $bIsDisabled = false)
	{
		parent::__construct($sIdName, $sValue, "input", PWL_EMPTY_STRING, $bIsDisabled);
		
		$this->AddAttr("type", "button");
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
 *	@todo To document
 */
class CXHOptionsInsertions extends CXHFieldAttrs
{
	/**
	 *	@todo To document
	 */
	private $_iNumSelected;


	/**
	 *	@todo To document
	 */
	public function __construct($sTagName, $bIsDisabled = false)
	{
		parent::__construct($sTagName, true, PWL_EMPTY_STRING, $bIsDisabled);
		
		$this->_iNumSelected = 0;
	}


	/**
	 *	@todo To document
	 */
	public function AddOption($sValue, $sDisplay, $bSelected = false, $bIsDisabled = false)
	{
		$oOption = new CXHOption($sValue,$sDisplay, $bSelected, $bIsDisabled);

		if ($bSelected)
			$this->_iNumSelected++;

		parent::AppendContent($oOption);
	}
	

	/**
	 *	@todo To document
	 */
	public function InsertOption($oOption)
	{
		if (_io($oOption, 'CXHOption'))
		{
			if ($oOption->IsSelected())
				$this->_iNumSelected++;
		
			parent::AppendContent($oOption);
		}
		else
		{
			throw new XHException("option is not an instance of class CXHOption");
		}
	}
	

	/**
	 *	@todo To document
	 */
	public function GetNumSelections()
	{
		return $this->_iNumSelected;
	}
}


/**
 *	@todo To document
 */
class CXHSelectbox extends CXHOptionsInsertions
{
	/**
	 *	@todo To document
	 */
	private $_bIsMultiple;


	/**
	 *	@todo To document
	 */
	private $_iNumSelected;


	/**
	 *	@todo To document
	 */
	public function __construct($sIdName, $iSize = 1, $bIsMultiple = false, $bIsDisabled = false)
	{
		parent::__construct("select", $bIsDisabled);
		
		$this->AddAttr("name", $sIdName);
		$this->SetId($sIdName);

		if ($iSize > 1)
			$this->AddAttr("size", "$iSize");
		
		$this->_bIsMultiple = $bIsMultiple;
		$this->_iNumSelected = 0;
		
		if ($bIsMultiple)
			$this->AddAttr("multiple", "multiple");
		
		parent::_RegisterEvent("onchange");
	}
	

	/**
	 *	@todo To document
	 */
	private function _validateNumSelections()
	{
		if (!$this->_bIsMultiple && $this->_iNumSelected > 1)
			throw new XHException("Select is not multiple but many options are selected");
	}
	

	/**
	 *	@todo To document
	 */
	public function AddOption($sValue, $sDisplay, $bSelected = false, $bIsDisabled = false)
	{
		parent::AddOption($sValue, $sDisplay, $bSelected, $bIsDisabled);
		
		if ($bSelected)
			$this->_iNumSelected++;
			
		$this->_validateNumSelections();
	}
	

	/**
	 *	@todo To document
	 */
	public function InsertOption($oOption)
	{
		parent::InsertOption($oOption);
		
		$this->_iNumSelected += parent::GetNumSelections();
		
		$this->_validateNumSelections();
	}
	

	/**
	 *	@todo To document
	 */
	public function AppendContent($oOption)
	{
		$this->InsertOption($oOption);
	}
	

	/**
	 *	@todo To document
	 */
	public function InsertOptionGroup($oOptionGroup)
	{
		if (_io($oOptionGroup, 'CXHOptionGroup'))
		{
			$this->_iNumSelected += $oOptionGroup->GetNumSelections();
		
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
 *	@todo To document
 */
class CXHOptionGroup extends CXHOptionsInsertions
{
	/**
	 *	@todo To document
	 */
	public function __construct($sLabel, $bIsDisabled = false)
	{
		parent::__construct("optgroup", $sDisplay);
		
		$this->AddAttr("label",$sLabel);
		
		if ($bIsDisabled) $this->AddAttr("disabled", "disabled");
	}
	

	/**
	 *	@todo To document
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
 *	@todo To document
 */
class CXHOption extends CXHEntityAttrs
{
	/**
	 *	@todo To document
	 */
	private $_bIsSelected;
	

	/**
	 *	@todo To document
	 */
	public function __construct($sValue, $sDisplay, $bSelected = false, $bIsDisabled = false)
	{
		parent::__construct("option", true, $sDisplay, $bIsDisabled);
		
		$this->AddAttr("value",$sValue);
		
		$this->_bIsSelected = $bSelected;
		
		if ($bIsDisabled) $this->AddAttr("disabled", "disabled");
	}
	

	/**
	 *	@todo To document
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
 *	XHTML fieldset element class
 */
class CXHFieldSet extends CXHEntityAttrs
{
	/**
	 *	@todo To document
	 */
	public function __construct($sLegend = PWL_EMPTY_STRING)
	{
		parent::__construct("fieldset");
		
		if (_sl($sLegend)) $this->AddLegend($sLegend);
	}
	

	/**
	 *	@todo To document
	 */
	public function AddLegend($sLegend)
	{
		$oLegend = new CXHLegend($sLegend);
		
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
 */
class CXHLegend extends CXHEntityAttrs
{
	public function __construct($vLegend = PWL_EMPTY_STRING)
	{
		parent::__construct("legend", true, $vLegend);
	}
	
	
	/**
	 *	To insert content in the legend element.
	 *	
	 *	Method overloaded for restrictions. Makes a call to the parent's ReplaceContent
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
 *	@todo To document
 */
class CXHPushButton extends CXHFieldAttrs
{
	/**
	 *	@todo To document
	 */
	private $_sDefaultContent;


	/**
	 *	@todo To document
	 */
	const sTypeButton = 'button';


	/**
	 *	@todo To document
	 */
	const sTypeSubmit = 'submit';


	/**
	 *	@todo To document
	 */
	const sTypeReset = 'reset';
	

	/**
	 *	@todo To document
	 */
	public function __construct($sType, $sIdName, $sValue, $bIsDisabled = false, $sContent = PWL_EMPTY_STRING)
	{
		parent::__construct("button", true, $sContent, $bIsDisabled);
		
		$this->_sDefaultContent = $sType;
		
		$this->AddAttr("type", $sType);
		$this->AddAttr("name", $sIdName);
		$this->AddAttr("value", $sValue);
		
		$this->SetId($sIdName);
		
		$this->_sContent = $sContent;
	}
	

	/**
	 *	@todo To document
	 */
	public function AppendContent($sContent)
	{
		$this->_sContent .= $sContent;
	}
	

	/**
	 *	@todo To document
	 */
	public function ReplaceContent($sContent)
	{
		$this->_sContent = $sContent;
	}
	

	/**
	 *	@todo To document
	 */
	public function __toString()
	{
		if (_sl($this->_sContent))
			parent::AppendContent($this->_sContent);
		else
			parent::AppendContent($this->_sDefaultContent);
		
		return parent::__toString();
	}
}


# <!--======================= Tables =======================================-->

# <!ENTITY %CAlign "(top|bottom|left|right)">
#
# <!ENTITY % cellhalign
#   "align      (left|center|right|justify|char) #IMPLIED
#    char       CDATA    #IMPLIED
#    charoff    CDATA       #IMPLIED"
#   >
#
# <!ENTITY % cellvalign
#   "valign     (top|middle|bottom|baseline) #IMPLIED"
#   >
/**
 *	@todo To document
 */
class CXHTableAlignAttrs extends CXHEntityAttrs
{
	/**
	 *	@todo To document
	 */
	const sHALeft =		'left';


	/**
	 *	@todo To document
	 */
	const sHACenter =	'center';


	/**
	 *	@todo To document
	 */
	const sHARight =	'right';


	/**
	 *	@todo To document
	 */
	const sHAJustify = 	'justify';


	/**
	 *	@todo To document
	 */
	const sHAChar =		'char';
	

	/**
	 *	@todo To document
	 */
	const sVATop = 		'top';


	/**
	 *	@todo To document
	 */
	const sVAMiddle =	'middle';


	/**
	 *	@todo To document
	 */
	const sVABottom =	'bottom';


	/**
	 *	@todo To document
	 */
	const sVABaseline =	'baseline';
	

	/**
	 *	@todo To document
	 */
	public function __construct($sTagName, $bHasEnd = true)
	{
		parent::__construct($sTagName, $bHasEnd);
	}
	

	/**
	 *	@todo To document
	 */
	public function SetHAlign($sHAlign)
	{
		parent::AddAttr("align", $sHAlign);
	}
	

	/**
	 *	@todo To document
	 */
	public function SetVAlign($sVAlign)
	{
		parent::AddAttr("valign", $sVAlign);
	}
}


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
 *	@todo To document
 */
class CXHTable extends CXHEntityAttrs
{
	/**
	 *	@todo To document
	 */
	public function __construct($oCXHTableContent = PWL_NULL_OBJECT, $oCXHCaption = PWL_NULL_OBJECT)
	{
		parent::__construct("table");

		$this->_oCaption = PWL_NULL_OBJECT;
		$this->_aCols = array();
		$this->_oTHead = PWL_NULL_OBJECT;
		$this->_oTFoot = PWL_NULL_OBJECT;
		$this->_aTBody = array();
		
		if (!_in($oCXHTableContent))
			$this->AppendContent($oCXHTableContent);

		if (!_in($oCXHCaption))
			$this->AppendContent($oCXHCaption);
	}
	

	/**
	 *	@todo To document
	 */
	public function ReplaceCaption($oCXHTableCaption)
	{
		$this->AppendContent($oCXHTableCaption);
	}
	

	/**
	 *	@todo To document
	 */
	public function AppendCols($oCXHCols)
	{
		$this->AppendContent($oCXHCols);
	}
	

	/**
	 *	@todo To document
	 */
	public function ReplaceHead($oCXHTableHead)
	{
		$this->AppendContent($oCXHTableHead);
	}
	

	/**
	 *	@todo To document
	 */
	public function AppendBody($oCXHTableBody)
	{
		$this->AppendContent($oCXHTableBody);
	}
	

	/**
	 *	@todo To document
	 */
	public function ReplaceFoot($oCXHTableFoot)
	{
		$this->AppendContent($oCXHTableFoot);
	}
	

	/**
	 *	@todo To document
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
			$this->_oTBody[] = $vContent;
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
	 *	@todo To document
	 */
	public function SetCellspacing($vValue)
	{
		$this->AddAttr("cellspacing", $vValue);
	}
	

	/**
	 *	@todo To document
	 */
	public function SetCellpadding($vValue)
	{
		$this->AddAttr("cellpadding", $vValue);
	}
	
	/**
	 *   (caption?, (col*|colgroup*), thead?, tfoot?, (tbody+|tr+))>
	 */
	public function __toString()
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
		
		parent::__toString();
	}
}


##
#
# <!ELEMENT caption  %Inline;>
# <!ATTLIST caption
#   %attrs
#   >
/**
 *	@todo To document
 */
class CXHCaption extends CXHEntityAttrs
{
	/**
	 *	@todo To document
	 */
	public function __construct($sContent = PWL_EMPTY_STRING)
	{
		parent::__construct("caption", true, $sContent);
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
 *	@todo To document
 */
class CXHTableHead extends CXHTableAlignAttrs
{
	/**
	 *	@todo To document
	 */
	public function __construct($oCXHRow = PWL_NULL_OBJECT)
	{
		parent::__construct("thead");
		
		if (!_in($oCXHRow))
		{
			$this->AppendContent($oCXHRow);
		}
	}
	

	/**
	 *	@todo To document
	 */
	public function AppendRow($oCXHRow)
	{
		$this->AppendContent($oCXHRow);
	}
	

	/**
	 *	@todo To document
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
# <!ELEMENT tfoot    (tr)+>
# <!ATTLIST tfoot
#   %attrs
#   %cellhalign
#   %cellvalign
#   >
/**
 *	@todo To document
 */
class CXHTableFoot extends CXHTableAlignAttrs
{
	/**
	 *	@todo To document
	 */
	public function __construct($oCXHRow = PWL_NULL_OBJECT)
	{
		parent::__construct("tfoot");
		
		if (!_in($oCXHRow))
		{
			$this->AppendContent($oCXHRow);
		}
	}
	

	/**
	 *	@todo To document
	 */
	public function AppendRow($oCXHRow)
	{
		$this->AppendContent($oCXHRow);
	}
	

	/**
	 *	@todo To document
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
 *	@todo To document
 */
class CXHTableBody extends CXHTableAlignAttrs
{
	/**
	 *	@todo To document
	 */
	public function __construct($oCXHRow = PWL_NULL_OBJECT)
	{
		parent::__construct("tbody");
		
		if (!_in($oCXHRow))
		{
			$this->AppendContent($oCXHRow);
		}
	}
	

	/**
	 *	@todo To document
	 */
	public function AppendRow($oCXHRow)
	{
		$this->AppendContent($oCXHRow);
	}


	/**
	 *	@todo To document
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
 *	@todo To document
 */
class CXHColAttrs extends CXHTableAlignAttrs
{
	/**
	 *	@todo To document
	 */
	public function __construct($sTagName, $bHasEnd = true)
	{
		parent::__construct($sTagName, $bHasEnd);
	}
	

	/**
	 *	@todo To document
	 */
	public function SetSpan($iSpanVal)
	{
		parent::AddAttr("span", (string) $iSpanVal);
	}
	

	/**
	 *	@todo To document
	 */
	public function SetWidth($vWidth)
	{
		parent::AddAttr("width", (string) $vWidth);
	}
}


/**
 *	@todo To document
 */
class CXHColGroup extends CXHColAttrs
{
	/**
	 *	@todo To document
	 */
	public function __construct()
	{
		parent::__construct("colgroup");
	}
	

	/**
	 *	@todo To document
	 */
	public function AppendCol($oCXHCol)
	{
		$this->AppendContent($oCXHCol);
	}
	

	/**
	 *	@todo To document
	 */
	public function AppendContent($vContent)
	{
		if (_io($vContent, 'CXHCol'))
			parent::AppendContent($vContent);
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
 *	@todo To document
 */
class CXHCol extends CXHColAttrs
{
	/**
	 *	@todo To document
	 */
	public function __construct($sHAlign = CXHTableAlignAttrs::sHALeft, $sVAlign = CXHTableAlignAttrs::sVAMiddle, $vWidth = PWL_EMPTY_STRING, $iSpan = 1)
	{
		parent::__construct("col", false);
		
		parent::SetHAlign($sHAlign);
		parent::SetVAlign($sVAlign);
		if (_sl((string) $vWidth)) parent::SetWidth($vWidth);
		parent::SetSpan($iSpan);
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
 *	@todo To document
 */
class CXHRow extends CXHEntityAttrs
{
	/**
	 *	@todo To document
	 */
	public function __construct($oCXHCell = PWL_NULL_OBJECT)
	{
		parent::__construct("tr");
		
		if (!_in($oCXHCell))
		{
			$this->AppendContent($oCXHCell);
		}
	}
	

	/**
	 *	@todo To document
	 */
	public function AppendCell($oCXHCell)
	{
		$this->AppendContent($oCXHCell);
	}
	

	/**
	 *	@todo To document
	 */
	public function AppendContent($vContent)
	{	
		if (_io($vContent, 'CXHCell') || _io($vContent, 'CXHCellHead'))
		{
			parent::AppendContent($vContent);
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
 *	@todo To document
 */
class CXHCellHead extends CXHEntityAttrs
{
	/**
	 *	@todo To document
	 */
	public function __construct($vContent = PWL_EMPTY_STRING)
	{
		parent::__construct("th");
		
		if (!_es($vContent)) parent::AppendContent($vContent);
	}
	

	/**
	 *	@todo To document
	 */
	public function SetRowspan($vValue)
	{
		$this->AddAttr("rowspan", $vValue);
	}
	

	/**
	 *	@todo To document
	 */
	public function SetColspan($vValue)
	{
		$this->AddAttr("colspan", $vValue);
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
 *	@todo To document
 */
class CXHCell extends CXHEntityAttrs
{
	/**
	 *	@todo To document
	 */
	public function __construct($vContent = PWL_EMPTY_STRING)
	{
		parent::__construct("td");
		
		if (!_es($vContent)) parent::AppendContent($vContent);
	}
	

	/**
	 *	@todo To document
	 */
	public function SetRowspan($vValue)
	{
		$this->AddAttr("rowspan", $vValue);
	}
	

	/**
	 *	@todo To document
	 */
	public function SetColspan($vValue)
	{
		$this->AddAttr("colspan", $vValue);
	}
}


?>