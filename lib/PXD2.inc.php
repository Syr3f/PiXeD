<?php


/**
 *
 *	@package XD[2]XHTML-Base
 *	@version 0.2
 *	@license MIT License
 *
 *	@copyright Copyright (c) 2010 Serafim Junior Dos Santos Fagundes Cyb3r Network
 *	@author Serafim Junior Dos Santos Fagundes <serafim@cyb3r.ca>
 *
 *
 *	The second level of abstraction of the PiXeD Library.
 *	
 *	This file contains the code elements of the second level of abstraction of the PiXeD Library.
 *
 *	The idea of this level is to extend the 1st level, Markup Identification, and build the foundation of the XHTML entities. It generally contains abstract classes where usage is directly related to the next level of abstraction.
 */


/**
 *	Links the first level file
 */
require_once("PXD1.inc.php");


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


# <!--=================== Generic Attributes ===============================-->

# <!ENTITY % i18n
#  "lang        CDATA #IMPLIED
#   xml:lang    CDATA #IMPLIED
#   dir         (ltr|rtl)      #IMPLIED"
#   >
/**
 *  Internationalization entity attributes abstraction class
 *
 *	@abstract
 */
abstract class CXHEntityIntl extends CMLEntity
{
	/**
	 *	@var array Hash array holding the entity attributes; the keys holds the names and the values the attribute values
	 *	@access private
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
	public function __construct($sTagName, $bHasEnd = true, $sContent = PXH_EMPTY_STRING)
	{	
		parent::__construct($sTagName, $bHasEnd, $sContent);
		
		$this->_hAttrs1 = array();
	}
	
	
	/**
	 *	Sets the entity's language
	 *
	 *	@param string $sLang String for the language of the document; short code
	 */
	public function SetLang($sLang)
	{
		$this->_hAttrs1["lang"] = $sLang;
		$this->_hAttrs1["xml:lang"] = $sLang;
	}
	
	
	/**
	 *	Sets the text direction
	 *
	 *	@param string $csDir Class constant defining the text direction
	 */
	public function SetDir($csDir)
	{
		$this->_hAttrs1["dir"] = $csDir;
	}
	
	
	/**
	 *	Generates the markup
	 *
	 *	@return string
	 */
	protected function _Generate()
	{
		parent::AddAttrs($this->_hAttrs1);

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


# <!ENTITY % coreattrs
#  "id          ID             #IMPLIED
#   class       CDATA          #IMPLIED
#   style       CDATA   #IMPLIED
#   title       CDATA         #IMPLIED"
#   >
/**
 *	Core entity attributes abstraction class
 *
 *	@abstract
 */
abstract class CXHEntityCoreAttrs extends CMLEntity
{
	/**
	 *	@var array Holds the style list of the entity
	 *	@access private
	 */
	private $_asStyles1;


	/**
	 *	@var array Holds the attributes of the entity
	 *	@access private
	 */
	private $_hsAttrs3;


	/**
	 *	@param string $sTagName String for the entity tag name
	 *	@param bool $bHasEnd Variable defining if the entity has a full end or a self closed end
	 *	@param string $sContent Variable for the initial entity content
	 */
	public function __construct($sTagName, $bHasEnd = true, $sContent = PXH_EMPTY_STRING)
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
	 *	Returns the id value of the entity
	 *
	 *	@return string
	 */
	public function GetId()
	{
		$sId = PXH_EMPTY_STRING;
		
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
	 *	Returns the class value of the entity
	 *
	 *	@return string
	 */
	public function GetClass()
	{
		$sClass = PXH_EMPTY_STRING;
	
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
	 *	@access private
	 */
	private function _generateStylesString()
	{
		$sTemp = PXH_EMPTY_STRING;

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
	 *	Generates the markup
	 *
	 *	@return string
	 */
	protected function _Generate()
	{
		$this->_generateStylesString();
	
		parent::AddAttrs($this->_hsAttrs3);

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
 *
 *	@abstract
 */
abstract class CXHEntityAttrs extends CXHEntityIntl
{
	/**
	 *	@var array Holds the style list of the entity
	 *	@access private
	 */
	private $_asStyles;


	/**
	 *	@var array Holds the attributes of the entity
	 *	@access private
	 */
	private $_hsAttrs2;


	/**
	 *	@param string $sTagName String for the entity tag name
	 *	@param bool $bHasEnd Variable defining if the entity has a full end or a self closed end
	 *	@param string $sContent Variable for the initial entity content
	 */
	public function __construct($sTagName, $bHasEnd = true, $sContent = PXH_EMPTY_STRING)
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
	 *
	 *	@access private
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
	 *	Returns the id value of the entity
	 *
	 *	@return string
	 */
	public function GetId()
	{
		$sId = PXH_EMPTY_STRING;
		
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
	 *	Returns the class value of the entity
	 *
	 *	@return string
	 */
	public function GetClass()
	{
		$sClass = PXH_EMPTY_STRING;
	
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
	 *
	 *	@access private
	 */
	private function _generateStylesString()
	{
		$sTemp = PXH_EMPTY_STRING;

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
	 *	Generates markup
	 *
	 *	@return string
	 */
	protected function _Generate()
	{
		$this->_generateStylesString();
		
		parent::AddAttrs($this->_hsAttrs2);

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
 *	Abstract class for the list elements ul and ol
 *
 *	Defines the base methods to be used by the ordered and unordered list elements
 *
 *	@abstract
 */
abstract class CXHList extends CXHEntityAttrs
{
	/**
	 *	@param string $sTagName Name of the entity
	 */
	public function __construct($sTagName)
	{
		parent::__construct($sTagName);
	}
	
	
	/**
	 *	Adds content to a li element
	 *
	 *	@param mixed $vContent Content of the entity
	 */
	public function AddItem($vContent)
	{
		$oCXHItem = new CXHListItem($vContent);
	
		$this->AppendContent($oCXHItem);
	}
	
	
	/**
	 *	@param object $oCXHItem Inserts a li element
	 */
	public function InsertItem($oCXHItem)
	{
		$this->AppendContent($oCXHItem);
	}
	
	
	/**
	 *	@param object $oCXHItem Inserts a li element
	 */
	public function AppendContent($oCXHItem)
	{
		if (_io($oCXHItem, 'CXHListItem'))
			parent::AppendContent($oCXHItem);
		else
			throw new XHException("Parameter is not an instance of CXHListItem");
	}
}


/**
 *	Defines the base class of the form fields
 *
 *	@abstract
 */
abstract class CXHFieldAttrs extends CXHEntityAttrs
{
	/**
	 *	@param string $sTagName Name of the element
	 *	@param mixed $vContent Initial content of the element
	 *	@param bool $bHasEnd If element has end; true for full end, false for self closed
	 *	@param bool $bIsDisabled indicates if element is disabled
	 */
	public function __construct($sTagName, $vContent, $bIsDisabled, $bHasEnd)
	{
		parent::__construct($sTagName, $bHasEnd, $vContent);
		
		parent::_RegisterEvent("onfocus");
		parent::_RegisterEvent("onblur");
		
		if ($bIsDisabled) $this->AddAttr("disabled", "disabled");
	}
}


/**
 *	Defines the base class of the input elements
 *
 *	The input element is a multi-purpose form control. The type attribute specifies the type of form control to be created.
 *
 *	@abstract
 */
abstract class CXHFieldInput extends CXHFieldAttrs
{
	/**
	 *	@param string $sIdName Id and name of the input element
	 *	@param string $sValue Initial value of the input element
	 *	@param string $sType Type of the input element
	 *	@param bool $bIsDisabled Indicates if element is disabled
	 */
	public function __construct($sIdName, $sValue, $sType, $bIsDisabled = false)
	{
		parent::__construct("input", PXH_EMPTY_STRING, $bIsDisabled, false);

		parent::AddAttr("type", $sType);

		parent::AddAttr("name", $sIdName);
		parent::AddAttr("value", $sValue);
		
		parent::SetId($sIdName);
		
		parent::_RegisterEvent("onselect");
		parent::_RegisterEvent("onchange");
	}
}


/**
 *	Defines an abstract class for options insertions
 *
 *	@abstract
 */
abstract class CXHOptionsInsertions extends CXHFieldAttrs
{
	/**
	 *	@var int Holds the number of items selected
	 *	@access private
	 */
	private $_iNumSelected;


	/**
	 *	@param string $sTagName Name of the entity
	 *	@param bool $bIsDisabled 
	 */
	public function __construct($sTagName, $bIsDisabled = false)
	{
		parent::__construct($sTagName, PXH_EMPTY_STRING, $bIsDisabled, true);
		
		$this->_iNumSelected = 0;
	}


	/**
	 *	Adds an option element
	 *
	 *	@param string $sValue Value of the option
	 *	@param string $sDisplay Text display of the option
	 *	@param bool $bSelected Indicates if option is selected
	 *	@param bool $bIsDisabled Indicates if option is disabled
	 */
	public function AddOption($sValue, $sDisplay, $bSelected = false, $bIsDisabled = false)
	{
		$oOption = new CXHOption($sValue,$sDisplay, $bSelected, $bIsDisabled);

		if ($bSelected)
			$this->IncrementSelections();

		parent::AppendContent($oOption);
	}
	

	/**
	 *	Inserts an option element
	 *
	 *	@param object $oOption Instance of class CXHOption
	 */
	public function InsertOption($oOption)
	{
		if (_io($oOption, 'CXHOption'))
		{
			if ($oOption->IsSelected())
				$this->IncrementSelections();
		
			parent::AppendContent($oOption);
		}
		else
		{
			throw new XHException("option is not an instance of class CXHOption");
		}
	}
	
	
	/**
	 *	Increments the number of selections
	 */
	protected function IncrementSelections()
	{
		$this->_iNumSelected++;
	}
	

	/**
	 *	Return the number of options selected
	 *
	 *	@return int
	 */
	public function GetNumSelections()
	{
		return $this->_iNumSelected;
	}
}


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
 *	Defines an abstract class for some table content elements
 *
 *	@abstract
 */
abstract class CXHTableAlignAttrs extends CXHEntityAttrs
{
	/**
	 *	@var string Class constant defining a left alignment
	 */
	const sHALeft =		'left';


	/**
	 *	@var string Class constant defining a center alignment
	 */
	const sHACenter =	'center';


	/**
	 *	@var string Class constant defining a right alignment
	 */
	const sHARight =	'right';


	/**
	 *	@var string Class constant defining a justified alignment
	 */
	const sHAJustify = 	'justify';


	/**
	 *	@var string Class constant defining a character alignment
	 */
	const sHAChar =		'char';
	

	/**
	 *	@var string Class constant defining a top alignment
	 */
	const sVATop = 		'top';


	/**
	 *	@var string Class constant defining a middle alignment
	 */
	const sVAMiddle =	'middle';


	/**
	 *	@var string Class constant defining a bottom alignment
	 */
	const sVABottom =	'bottom';


	/**
	 *	@var string Class constant defining a baseline alignment
	 */
	const sVABaseline =	'baseline';
	

	/**
	 *	@param string $sTagName Name of the element
	 *	@param bool $bHasEnd Indicates if element has end; true for foll end, false for self closed
	 */
	public function __construct($sTagName, $bHasEnd = true)
	{
		parent::__construct($sTagName, $bHasEnd);
	}
	

	/**
	 *	Sets the horizontal alignment
	 *
	 *	@param string $csHAlign Class constant defining an horizontal alignment
	 */
	public function SetHAlign($csHAlign)
	{
		switch ($csHAlign)
		{
			case self::sHALeft:
			case self::sHACenter:
			case self::sHARight:
			case self::sHAJustify:
			case self::sHAChar:
				parent::AddAttr("align", $csHAlign);
			break;
			default:
				throw new XHException("Value is not an horizontal alignment class constant");
		}
	}
	

	/**
	 *	Sets the vertical alignment
	 *
	 *	@param string $csVAlign Class constant defining a vertical alignment
	 */
	public function SetVAlign($csVAlign)
	{
		switch ($csVAlign)
		{
			case self::sVATop:
			case self::sVAMiddle:
			case self::sVABottom:
			case self::sVABaseline:
				parent::AddAttr("valign", $csVAlign);
			break;
			default:
				throw new XHException("Value is not a vertical alignment class constant");
		}
	}
}


/**
 *	Defines an abstract class for the colgroup and col elements
 *	@abstract
 */
abstract class CXHColAttrs extends CXHTableAlignAttrs
{
	/**
	 *	@param string $sTagName Name of the entity
	 *	@param bool $bHasEnd Indicates if element has end; true for full end, false for self closed
	 */
	public function __construct($sTagName, $bHasEnd = true)
	{
		parent::__construct($sTagName, $bHasEnd);
	}
	

	/**
	 *	Sets the spanning of the column
	 *
	 *	@param string $sSpanVal Number indicating the column spanning
	 */
	public function SetSpan($sSpanVal)
	{
		parent::AddAttr("span", $sSpanVal);
	}
	

	/**
	 *	Sets the width of the column
	 *
	 *	@param string $sWidth Width of the column
	 */
	public function SetWidth($sWidth)
	{
		parent::AddAttr("width", $sWidth);
	}
}
?>
