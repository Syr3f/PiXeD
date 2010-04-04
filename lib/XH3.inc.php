<?php


/**
 *
 *	@package [3]Blocks
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
 *	The idea of this level is to extend the 2th level, XHTML entity definitions, and amalgamate the sub elements into higher level constructs for higher coding efficiency and achieve innovative content generation.
 */


/**
 *	Links the second level file
 */
require_once("XH2.inc.php");


/**
 *	@todo To document
 *	@todo To test[3]
 */
class CXH2ScriptBlock
{
	/**
	 *	@todo To document
	 */
	public function __construct($sLanguage, $sScriptURL = PXH_EMPTY_STRING, $sNoScriptContent = PXH_EMPTY_STRING)
	{
		$this->_sLanguage = $sLanguage;
		$this->_sScriptURL = $sScriptURL;
		$this->_sNoScriptContent = $sNoScriptContent;
		
		$this->_oScript = new CXHScript($sLanguage, $sScriptURL);
		$this->_oNoScript = new CXHNoScript($sNoScriptContent);
	}
	

	/**
	 *	@todo To document
	 */
	public function AppendFileContent($sFilePath)
	{
		$this->_oScript->AppendFileContent($sFilePath);
	}
	

	/**
	 *	@todo To document
	 */
	public function AppendNoScriptContent($sContent)
	{
		$this->_oNoScript->AppendContent($sContent);
	}
	
	
	/**
	 *	@todo To document
	 */
	protected function _Generate()
	{
		return $this->_oScript."".$this->_oNoScript;
	}
	

	/**
	 *	@todo To document
	 */
	public function __toString()
	{
		return self::_Generate();
	}
}


/**
 *	@todo To document
 *	@todo To test[3]
 */
class CXH2ImageBlock extends CXHDiv
{
	/**
	 *	@todo To document
	 *	@access private
	 */
	private $_oImage;


	/**
	 *	@todo To document
	 *	@access private
	 */
	private $_oMap;


	/**
	 *	@todo To document
	 */
	public function __construct($sImgSrc, $sImgAlt, $sCommonId)
	{
		parent::__construct("div");
	
		$this->_oImage = new CXHImage($sImgSrc, $sImgAlt);
		$this->_oImage->SetUseMap($sCommonId);
		
		$this->_oMap = new CXHMap($sCommonId);
	}
	

	/**
	 *	@todo To document
	 */
	public function AddArea($sHRef, $sAlt, $sShape, $sCoords)
	{
		$this->_oMap->AddArea($sHRef, $sAlt, $sShape, $sCoords);
	}
	
	/**
	 *	@todo To document
	 */
	public function InsertArea($oCXHArea)
	{
		$this->_oMap->InsertArea($oCXHArea);
	}
	

	/**
	 *	@todo To document
	 */
	public function AppendContent($vContent)
	{
			$this->_oMap->AppendContent($vContent);
	}
}


/**
 *	@todo To document
 */
class CXH2HotzonesBlock extends CXHTable
{
	/**
	 *	@todo To document
	 *	@access private
	 */
	private $_sHeader;


	/**
	 *	@todo To document
	 *	@access private
	 */
	private $_sContent;


	/**
	 *	@todo To document
	 *	@access private
	 */
	private $_sFooter;


	/**
	 *	@todo To document
	 */
	public function __construct()
	{
		parent::__constrct();
		
		$this->SetCellspacing("0");
		$this->SetCellpadding("0");
	}
	
	
	/**
	 *	@todo To document
	 *	@access private
	 */
	public function _generateRow($oTBody, $oRow, $oCell)
	{
			$oRow->AppendContent($oCell);

		$oTBody->AppendContent($oRow);

			// BOTTOM ROW
			$oRow = new CHTMLTableRow();	
	}
	
	
	/**
	 *	@todo To document
	 */
	protected function _Generate()
	{
		$oTBody = new CHTMLTableBody();
			
			// TOP ROW
			$oRow = new CHTMLTableRow();
			
				$oCell = new CHTMLTableCell();
				
				$oCell->AppendContent("&nbsp;");
			
			$oRow->AppendContent($oCell);

				$oCell = new CHTMLTableCell();
				
				$oCell->AppendContent("&nbsp;");
			
			$oRow->AppendContent($oCell);

				$oCell = new CHTMLTableCell();
				
				$oCell->AppendContent("&nbsp;");

		// NAVIGATION ROW
		$this->_generateRow($oTBody, $oRow, $oCell);
			
				$oCell = new CHTMLTableCell();
				$oCell->SetColspan("3");
				
				$oCell->AppendContent("&nbsp;");
			
		// TOP MIDDLE ROW
		$this->_generateRow($oTBody, $oRow, $oCell);
			
				$oCell = new CHTMLTableCell();
				$oCell->SetRowspan("2");
				$oCell->AddStyle("height", "25%");
				
				$oCell->AppendContent("&nbsp;");
			
			$oRow->AppendContent($oCell);

				$oCell = new CHTMLTableCell();
				
				$oCell->AppendContent("&nbsp;");
			
			$oRow->AppendContent($oCell);

				$oCell = new CHTMLTableCell();
				$oCell->SetRowspan("2");
				$oCell->AddStyle("height", "25%");
				
				$oCell->AppendContent("&nbsp;");
			
		// SUB TOP MIDDLE ROW
		$this->_generateRow($oTBody, $oRow, $oCell);
			
				$oCell = new CHTMLTableCell();
				$oCell->SetRowspan("2");
				$oCell->AddStyle("height", "50%");
				
				$oCell->AppendContent("&nbsp;");
			
		// BOTTOM MIDDLE ROW
		$this->_generateRow($oTBody, $oRow, $oCell);			

				$oCell = new CHTMLTableCell();
				$oCell->SetRowspan("2");
				$oCell->AddStyle("height", "25%");
				
				$oCell->AppendContent("&nbsp;");
			
			$oRow->AppendContent($oCell);

				$oCell = new CHTMLTableCell();
				$oCell->SetRowspan("2");
				$oCell->AddStyle("height", "25%");
				
				$oCell->AppendContent("&nbsp;");
			
		// SUB BOTTOM MIDDLE ROW
		$this->_generateRow($oTBody, $oRow, $oCell);
			
				$oCell = new CHTMLTableCell();
				
				$oCell->AppendContent("&nbsp;");
			
			// FOOTER ROW
		$this->_generateRow($oTBody, $oRow, $oCell);
			
				$oCell = new CHTMLTableCell();
				$oCell->SetColspan("3");
				
				$oCell->AppendContent("&nbsp;");
			
			// BOTTOM ROW
		$this->_generateRow($oTBody, $oRow, $oCell);
			
				$oCell = new CHTMLTableCell();
				$oCell->SetColspan("3");
				
				$oCell->AppendContent("&nbsp;");
			
			$oRow->AppendContent($oCell);

		$oTBody->AppendContent($oRow);
	
		parent::AppendContent($oTBody);
	
		return parent::__toString();
	}
	
	/**
	 *	@todo To document
	 */
	public function __toString()
	{
		return self::_Generate();
	}
}

/**
 *	@todo To document
 */
class CXH2PanelBlock extends CXHDiv
{
	/**
	 *	@todo To document
	 *	@access private
	 */
	private $_iId;


	/**
	 *	@todo To document
	 */
	public function __construct($iId)
	{
		$this->_iId = $iId;
		
		parent::__construct();
		
		$this->SetId($this->_iId);
	}
}



/**
 *	Creates a table element
 *
 *	The CXH2TableBlock generates a table element and manages most of the table elements. The goal of this implementation is to ease the table implementation and its diverse parts for less code management and reading.
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


/**
 *	@todo To document
 *	@todo To test[3]
 */
class CXH2GridBlock extends CXHTable
{
	/**
	 *	@todo To document
	 *	@access private
	 */
	private $_iNbColumns;


	/**
	 *	@todo To document
	 *	@access private
	 */
	private $_iNbRows;


	/**
	 *	@todo To document
	 *	@access private
	 */
	private $_aaRows;


	/**
	 *	@todo To document
	 *	@access private
	 */
	private $_aRowIds;


	/**
	 *	@todo To document
	 *	@access private
	 */
	private $_aRowClasses;


	/**
	 *	@todo To document
	 *	@access private
	 */
	private $_aaCellIds;


	/**
	 *	@todo To document
	 *	@access private
	 */
	private $_aaCellClasses;
	
	
	/**
	 *	@todo To document
	 */
	public function __construct($iNbRows, $iNbColumns)
	{
		parent::__construct();
		
		$this->SetCellpadding("0");
		$this->SetCellspacing("0");
			
		$this->_iNbColumns = $iNbColumns;
		$this->_iNbRows = $iNbRows;
		
		$this->_aaRows = array();
		$this->_aRowIds = array();
		$this->_aRowClasses = array();
		$this->_aaCellIds = array();
		$this->_aaCellClasses = array();

		for ($iR = 0; $iR < $iNbRows; $iR++)
		{
			array_push($this->_aaRows, array(array()));
			
			$this->_aaCellIds[] = array();
			
			$this->_aaCellClasses[] = array();
		}
	}
	

	/**
	 *	@todo To document
	 */
	public function SetCellId($sId, $iRow, $iColumn)
	{
		$this->_aaCellIds[$iRow][$iColumn] = $sId;
	}


	/**
	 *	@todo To document
	 */
	public function SetCellClass($sClass, $iRow, $iColumn)
	{
		$this->_aaCellClasses[$iRow][$iColumn] = $sClass;
	}
	

	/**
	 *	@todo To document
	 */
	public function SetRowId($sId, $iRow)
	{
		$this->_aRowIds[$iRow] = $sId;
	}


	/**
	 *	@todo To document
	 */
	public function SetRowClass($sClass, $iRow)
	{
		$this->_aRowClasses[$iRow] = $sClass;
	}
	

	/**
	 *	@todo To document
	 */
	public function AppendContent($vContent, $iRow, $iColumn)
	{
		$this->_aaRows[$iRow][$iColumn][] = $vContent;
	}
	
	
	/**
	 *	Generates markup
	 *
	 *	@return string
	 */
	protected function _Generate()
	{
		$oTBody = new CHTMLTableBody();
	
		for ($iR = 0; $iR < count($this->_aaRows); $iR++)
		{
			$oRow = new CHTMLTableRow();

			if (isset($this->_aRowIds[$iR]))
			{
				$oRow->SetId($this->_aRowIds[$iR]);
			}

			if (isset($this->_aRowClasses[$iR]))
			{
				$oRow->SetClass($this->_aRowClasses[$iR]);
			}
			
			for ($iC = 0; $iC < count($this->_aaRows[$iR]); $iC++)
			{
				$oCell = new CHTMLTableCell();
				
				if (isset($this->_aaCellIds[$iR][$iC]))
				{
					$oCell->SetId($this->_aaCellIds[$iR][$iC]);
				}

				if (isset($this->_aaCellClasses[$iR][$iC]))
				{
					$oCell->SetClass($this->_aaCellClasses[$iR][$iC]);
				}
				
				for ($i = 0; $i < count($this->_aaRows[$iR][$iC]); $i++)
					$oCell->AppendContent($this->_aaRows[$iR][$iC][$i]);
				
				$oRow->AppendContent($oCell);
			}
			
			$oTBody->AppendContent($oRow);
		}
		
		parent::AppendContent($oTBody);
		
		return parent::__toString();
	}


	/**
	 *	@todo To document
	 */
	public function __toString()
	{
		return self::_Generate();
	}
}


/**
 *	@todo To document
 *	@todo To test[3]
 */
class CXH2FormField extends CXHDiv
{
	/**
	 *	@todo To document
	 */
	const iDisplayInline = 1;

	
	/**
	 *	@todo To document
	 */
	const iDisplayStacked = 2;


	/**
	 *	@todo To document
	 */
	const iDisplayRight = 3;


	/**
	 *	@todo To document
	 */
	const iDisplayBottom = 4;

	
	/**
	 *	@todo To document
	 *	@access private
	 */
	private $_vLabel;

	
	/**
	 *	@todo To document
	 *	@access private
	 */
	private $_oField;
	

	/**
	 *	@todo To document
	 *	@access private
	 */
	private $_iDisplay;
	
	
	/**
	 *	@todo To document
	 *	@access private
	 */
	private $_sLabelClass;


	/**
	 *	@todo To document
	 */
	public function __construct($vLabel, $oField, $ciDisplay = CXH2FormField::iDisplayInline)
	{
		parent::__construct();
		
		$this->_vLabel = $vLabel;
		$this->_oField = $oField;
		$this->SetDisplay($ciDisplay);
		$this->SetLabelOrientation($ciLabelOrientation);
		
		$this->_sLabelClass = PXH_EMPTY_STRING;
	}


	/**
	 *	@todo To document
	 */
	public function SetDisplay($ciDisplay)
	{
		switch ($ciDisplay)
		{
			case self::iDisplayStacked:
			case self::iDisplayInline:
			case self::iDisplayRight:
			case self::iDisplayBottom:
				$this->_iDisplay = $ciDisplay;
			break;
			default:
				throw new XHException("Form field display is not a class constant");
		}		
	}
	
	
	/**
	 *	@todo To document
	 */
	public function SetLabelClass($sClass)
	{
		$this->_sLabelClass = $sClass;
	}
	
	
	/**
	 *	@todo To document
	 */
	private function _setFormField()
	{
		$sId = $this->_oField->GetId();
	
		$oLabel = new CXHLabel($sId, $this->_vLabel);

		if (_sl($this->_sLabelClass))
			$oLabel->SetClass($this->_sLabelClass);
	
		switch ($this->_iOrientation)
		{
			case self::iDisplayInline:
				parent::AppendContent($oLabel);
				parent::AppendContent($this->_oField);
			break;
			case self::iDisplayRight:
				$oLabel->AddStyle("float", "right");
				parent::AppendContent($oLabel);
				$this->_oField->AddStyle("float", "right");
				parent::AppendContent($this->_oField);
			break;
			case self::iDisplayStacked:
				parent::AppendContent($oLabel);
				parent::AppendContent(new CXHBreak());
				parent::AppendContent($this->_oField);
			break;
			case self::iDisplayBottom:
				parent::AppendContent($this->_oField);
				parent::AppendContent(new CXHBreak());
				parent::AppendContent($oLabel);
			break;
		}
	}
	
	
	/**
	 *	Generates markup
	 *
	 *	@return string
	 */
	protected function _Generate()
	{
		$this->_setFormField();
	
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
