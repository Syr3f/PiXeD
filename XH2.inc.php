<?php

/**
 *	Second level abstraction of the PHPWebLib.
 *	
 *	This file contains the code elements of the second level abstraction of the PHPWebLib.
 *
 *	@author Serafim Junior Dos Santos Fagundes <serafim@cyb3r.ca>
 *	@copyright Copyright (c) 2010 Serafim Junior Dos Santos Fagundes Cyb3r Networks
 *	@license http://creativecommons.org/licenses/by/3.0/ cc by
 *  
 *	@version 0.0
 *
 *	@package XHTML
 */

include("XH0.inc.php");


class CXH2Script
{
	public function __construct($sLanguage, $sScriptURL = PWL_EMPTY_STRING, $sNoScriptContent = PWL_EMPTY_STRING)
	{
		$this->_sLanguage = $sLanguage;
		$this->_sScriptURL = $sScriptURL;
		$this->_sNoScriptContent = $sNoScriptContent;
		
		$this->_oScript = new CXHScript($sLanguage, $sScriptURL);
		$this->_oNoScript = new CXHNoScript($sNoScriptContent);
	}
	
	public function AppendFileContent($sFilePath)
	{
		$this->_oScript->AppendFileContent($sFilePath);
	}
	
	public function AppendNoScriptContent($sContent)
	{
		$this->_oNoScript->AppendContent($sContent);
	}
	
	public function __toString()
	{
		return $this->_oScript."".$this->_oNoScript;
	}
}



class CXH2ImageMap extends CXHDiv
{
	private $_oImage;
	private $_oMap;

	public function __construct($sImgSrc, $sImgAlt, $sCommonId)
	{
		parent::__construct("div");
	
		$this->_oImage = new CXHImage($sImgSrc, $sImgAlt);
		$this->_oImage->SetUseMap($sCommonId);
		
		$this->_oMap = new CXHMap($sCommonId);
	}
	
	public function AddArea($sHRef, $sAlt, $sShape, $sCoords)
	{
		$this->_oMap->AddArea($sHRef, $sAlt, $sShape, $sCoords);
	}
	
	public function InsertArea($oCXHArea)
	{
		$this->_oMap->InsertArea($oCXHArea);
	}
	
	public function AppendContent($vContent)
	{
			$this->_oMap->AppendContent($vContent);
	}
}



class CXH2HotzonesView extends CXHTable
{
	private $_sHeader;
	private $_sContent;
	private $_sFooter;

	public function __construct()
	{
		parent::__constrct();
		
		$this->SetCellspacing("0");
		$this->SetCellpadding("0");
	}
	
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
			
			$oRow->AppendContent($oCell);
		
		$oTBody->AppendContent($oRow);

			// NAVIGATION ROW
			$oRow = new CHTMLTableRow();
			
				$oCell = new CHTMLTableCell();
				$oCell->SetColspan("3");
				
				$oCell->AppendContent("&nbsp;");
			
			$oRow->AppendContent($oCell);
		
		$oTBody->AppendContent($oRow);

			// TOP MIDDLE ROW
			$oRow = new CHTMLTableRow();
			
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
			
			$oRow->AppendContent($oCell);
		
		$oTBody->AppendContent($oRow);

			// SUB TOP MIDDLE ROW
			$oRow = new CHTMLTableRow();
			
				$oCell = new CHTMLTableCell();
				$oCell->SetRowspan("2");
				$oCell->AddStyle("height", "50%");
				
				$oCell->AppendContent("&nbsp;");
			
			$oRow->AppendContent($oCell);

		$oTBody->AppendContent($oRow);

			// BOTTOM MIDDLE ROW
			$oRow = new CHTMLTableRow();
			
				$oCell = new CHTMLTableCell();
				$oCell->SetRowspan("2");
				$oCell->AddStyle("height", "25%");
				
				$oCell->AppendContent("&nbsp;");
			
			$oRow->AppendContent($oCell);

				$oCell = new CHTMLTableCell();
				$oCell->SetRowspan("2");
				$oCell->AddStyle("height", "25%");
				
				$oCell->AppendContent("&nbsp;");
			
			$oRow->AppendContent($oCell);
		
		$oTBody->AppendContent($oRow);

			// SUB BOTTOM MIDDLE ROW
			$oRow = new CHTMLTableRow();
			
				$oCell = new CHTMLTableCell();
				
				$oCell->AppendContent("&nbsp;");
			
			$oRow->AppendContent($oCell);
		
		$oTBody->AppendContent($oRow);

			// FOOTER ROW
			$oRow = new CHTMLTableRow();
			
				$oCell = new CHTMLTableCell();
				$oCell->SetColspan("3");
				
				$oCell->AppendContent("&nbsp;");
			
			$oRow->AppendContent($oCell);

		$oTBody->AppendContent($oRow);

			// BOTTOM ROW
			$oRow = new CHTMLTableRow();
			
				$oCell = new CHTMLTableCell();
				$oCell->SetColspan("3");
				
				$oCell->AppendContent("&nbsp;");
			
			$oRow->AppendContent($oCell);

		$oTBody->AppendContent($oRow);
	
		parent::AppendContent($oTBody);
	
		return parent::__toString();
	}
}


class CXH2Panel extends CXHDiv
{
	private $_iId;

	public function __construct($iId)
	{
		$this->_iId = $iId;
		
		parent::__construct();
		
		$this->SetId($this->_iId);
	}
}


class CXH2Grid extends CXHTable
{
	private $_iNbColumns;
	private $_iNbRows;
	private $_aaRows;
	private $_aRowIds;
	private $_aRowClasses;
	private $_aaCellIds;
	private $_aaCellClasses;

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
	
	public function SetCellId($sId, $iRow, $iColumn)
	{
		$this->_aaCellIds[$iRow][$iColumn] = $sId;
	}

	public function SetCellClass($sClass, $iRow, $iColumn)
	{
		$this->_aaCellClasses[$iRow][$iColumn] = $sClass;
	}
	
	public function SetRowId($sId, $iRow)
	{
		$this->_aRowIds[$iRow] = $sId;
	}

	public function SetRowClass($sClass, $iRow)
	{
		$this->_aRowClasses[$iRow] = $sClass;
	}
	
	public function AppendContent($vContent, $iRow, $iColumn)
	{
		$this->_aaRows[$iRow][$iColumn][] = $vContent;
	}

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