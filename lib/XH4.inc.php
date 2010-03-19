<?php


/**
 *
 *	@package [4]Blocks
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
 *	The idea of this level is to extend the 3th level, .
 */
 
 
require_once("XH3.inc.php");


/**
 *	@todo To document
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
	public function __toString()
	{
		return $this->_oScript."".$this->_oNoScript;
	}
}


/**
 *	@todo To document
 */
class CXH2ImageBlock extends CXHDiv
{
	/**
	 *	@todo To document
	 */
	private $_oImage;


	/**
	 *	@todo To document
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
	 */
	private $_sHeader;


	/**
	 *	@todo To document
	 */
	private $_sContent;


	/**
	 *	@todo To document
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
	public function __toString()
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
}

/**
 *	@todo To document
 */
class CXH2PanelBlock extends CXHDiv
{
	/**
	 *	@todo To document
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
 *	@todo To document
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
	 *	@todo To document
	 */
	private $_aTBody;
	
	
	/**
	 *	@todo To document
	 */
	private $_iCurrentBody;
	
	
	/**
	 *	@todo To document
	 */
	private $_oTHead;
	
	
	/**
	 *	@todo To document
	 */
	private $_oTFoot;
	
	
	/**
	 *	@todo To document
	 */
	private $_oCurrentRow;
	
	
	/**
	 *	@todo To document
	 */
	private $_oCurrentCell;
	
	
	/**
	 *	@todo To document
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->_aTBody = array();
		
		$this->_iCurrentBody = 0;
		
		$this->_oTHead = new CXHTableHead();
		$this->_aTBody[] = new CHXTableBody();
		$this->_oTFoot = new CXHTableFoor();
		
		$this->_oCurrentRow = new CHXRow();
		
		$this->_oCurrentCell = new CXHCell();
	}

	
	/**
	 *	@todo To document
	 */
	public function NewBody()
	{
		$this->_aTBody[] = new CXHTableBody();
		
		$this->_iCurrentBody++;
	}
	
	
	/**
	 *	@todo To document
	 */
	public function GenerateRow($cPart, $oCell = PXH_NULL_OBJECT)
	{
		if (!_in($oCell))
			$this->AppendToRow($oCell);
		else
			$this->AppendToRow($this->_oCurrentCell);
			
		$this->AppendRowToPart($cPart, $this->_oCurrentRow);
		
		$this->_oCurrentRow = new CXHRow();
		
		$this->_oCurrentCell = new CXHCell();
	}
	
	
	/**
	 *	@todo To document
	 */
	public function AppendToRow($oCell = PXH_NULL_OBJECT)
	{
		if (!_in($oCell))
			$this->_oCurrentCell = $oCell;
	
		$this->_oCurrentRow->AppendContent($this->_oCurrentCell);
	}
	
	
	/**
	 *	@todo To document
	 */
	public function AppendRowToPart($cPart, $oRow = PXH_NULL_OBJECT)
	{
		if (!_in($oRow))
			$this->_oCurrentRow = $oRow;
			
		switch ($cPart)
		{
			case self::iHead:
				$this->_oTHead->AppendContent($this->_oCurrentRow);
			break;
			case self::iBody:
				$this->_aTBody[$this->_iCurrentBody]->AppendContent($this->_oCurrentRow);
			break;
			case self::iFoot:
				$this->_oTFoot->AppendContent($this->_oCurrentRow);
			break;
			default:
				throw new XHException("Part value is not valid");
		}
	}
	
	
	/**
	 *	@todo To document
	 */
	 public function AppendContent($vContent)
	 {
		if (_io($vContent, 'CXHCell'))
			$this->_oCurrentRow->AppendContent($oCell);
		else
			parent::AppendContent($vContent);
	 }
	 
	
	/**
	 *	@todo To document
	 */
	public function __toString()
	{
		parent::ReplaceHead($this->_oTHead);

		foreach ($this->_aTBody as $oTBody)
			parent::AppendBody($oTBody);
	
		parent::ReplaceFoot($this->_oTFoot);
	
		parent::__toString();
	}
}


/**
 *	@todo To document
 */
class CXH2GridBlock extends CXHTable
{
	/**
	 *	@todo To document
	 */
	private $_iNbColumns;


	/**
	 *	@todo To document
	 */
	private $_iNbRows;


	/**
	 *	@todo To document
	 */
	private $_aaRows;


	/**
	 *	@todo To document
	 */
	private $_aRowIds;


	/**
	 *	@todo To document
	 */
	private $_aRowClasses;


	/**
	 *	@todo To document
	 */
	private $_aaCellIds;


	/**
	 *	@todo To document
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
	 *	@todo To document
	 */
	public function __toString()
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
}


?>