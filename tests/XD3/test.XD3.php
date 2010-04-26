<?php

include("../../XD.inc.php");

$sContentStyle = <<<CS
body { font-family:Georgia, serif; }
CS;

$oDoc = new CXHDocument("en");


	$oHead = new CXHHead();
	
		$oTitle = new CXHTitle("Test XD3");
	
	$oHead->AppendContent($oTitle);
	
		$oBase = new CXHBase("http://www.cyb3r.ca/");
	
	$oHead->AppendContent($oBase);
	
		$oEncoding = new CXHMeta("Content-Type", "", "text/html;charset=UTF-8");
		
	$oHead->AppendContent($oEncoding);
/*
		$oCSS = new CXHCSS();
		
		$oCSS->AppendContent($sBodyStyle);

	$oHead->AppendContent($oCSS);
	
		$oLink = new CXHLink("test.css", "text/css", "stylesheet");
	
	$oHead->AppendContent($oLink);
	
		//$oScript = new CXHScript("javascript", "test.js");
		// or by script integration
		$oScript = new CXHScript("javascript");
		$oScript->AddFileContent("test.js");
	
	$oHead->AppendContent($oScript);
	
		$oNoScript = new CXHNoScript();
	
	$oHead->AppendContent($oNoScript);
*/
	
$oDoc->ReplaceHead($oHead);
	
	$oBody = new CXHBody();
/*	
		$oH1 = new CXHHeading();
	
		$oH1->AppendContent("Hello World!");
		$oH1->AddStyle("color", "#666");
		$oH1->AddEvent("onclick", "alert('Hello again!')");
	
	$oBody->AppendContent($oH1);

			$oP = new CXHParagraph("This is a paragraph in a div");
	
		$oDiv = new CXHDiv($oP);
	
	$oBody->AppendContent($oDiv);
	
		$oHR = new CXHSep();
	
	$oBody->AppendContent($oHR);
	
		$oA = new CXHAnchor("http://github.com", "Testing a link");
	
	$oBody->AppendContent($oA);
	
	$oBody->AppendContent(new CXHBreak());
	
		$oA = new CXHAnchor("http://github.com", "Testing a link with target", "", "_blank");
	
	$oBody->AppendContent($oA);
	
	$oBody->AppendContent(new CXHBreak());
	
		$oImg = new CXHImage("http://www.gravatar.com/avatar/49453871216937223cb2afbe9ffc688f", "A picture");
	
	$oBody->AppendContent($oImg);
	
		$oForm = new CXHForm("#", "post", "FORM1");

			$oFS = new CXHFieldSet("Test legend 1");
				
				$oSelect = new CXHSelectbox("SB1");
				
				$oSelect->AddOption("null", "Select an option");

				$oOptionGroup = new CXHOptionGroup("A label");

					$oOptionGroup->AddOption("1", "An option");
					
						$oOption = new CXHOption("2", "Another option");
					
					$oOptionGroup->InsertOption($oOption);
					
				$oSelect->InsertOptionGroup($oOptionGroup);
				
			$oFS->AppendContent($oSelect);

			$oFS = new CXHFieldSet("Test legend 2");
				
				$oLabel = new CXHLabel("TXT1", "Text field 1");
				
			$oFS->AppendContent($oLabel);

			$oFS->AppendContent(new CXHBreak());
			
				$oText = new CXHFieldText("TXT1");
				
			$oFS->AppendContent($oText);

			$oFS->AppendContent(new CXHBreak());
				
				$oLabel = new CXHLabel("TXT2", "Text field 2");
				
			$oFS->AppendContent($oLabel);

			$oFS->AppendContent(new CXHBreak());

				$oText = new CXHFieldText("TXT2", "Inner text", true, true);
				
			$oFS->AppendContent($oText);

			$oFS->AppendContent(new CXHBreak());
				
				$oLabel = new CXHLabel("PWD", "Password field");
				
			$oFS->AppendContent($oLabel);

			$oFS->AppendContent(new CXHBreak());

				$oPwd = new CXHFieldPassword("PWD");
				
			$oFS->AppendContent($oPwd);

			$oFS->AppendContent(new CXHBreak());
				
				$oLabel = new CXHLabel("CHKBX", "Checkbox field");
				
			$oFS->AppendContent($oLabel);

				$oChkbx = new CXHFieldCheckbox("CHKBX", "CHKBX1", "1");
				
			$oFS->AppendContent($oChkbx);

			$oFS->AppendContent(new CXHBreak());
				
				$oFS2 = new CXHFieldSet("Test legend 3");
				
					$oLabel = new CXHLabel("RDO", "Radio field 1");
				
				$oFS2->AppendContent($oLabel);

					$oRdo = new CXHFieldRadio("RDO", "RDO1", "1");
				
				$oFS2->AppendContent($oRdo);

				$oFS2->AppendContent(new CXHBreak());
				
					$oLabel = new CXHLabel("RDO", "Radio field 2");
				
				$oFS2->AppendContent($oLabel);

					$oRdo = new CXHFieldRadio("RDO", "RDO2", "2");
				
				$oFS2->AppendContent($oRdo);

				$oFS2->AppendContent(new CXHBreak());

			$oFS->AppendContent($oFS2);
				
				$oLabel = new CXHLabel("FILE1", "File upload field");
				
			$oFS->AppendContent($oLabel);

				$oChkbx = new CXHFieldFile("FILE1");
				
			$oFS->AppendContent($oChkbx);

			$oFS->AppendContent(new CXHBreak());

				$oLabel = new CXHLabel("HDN", "Hidden field");
				
			$oFS->AppendContent($oLabel);

				$oChkbx = new CXHFieldHidden("HDN");
				
			$oFS->AppendContent($oChkbx);

			$oFS->AppendContent(new CXHBreak());

				$oLabel = new CXHLabel("IMG1", "Image input field");
				
			$oFS->AppendContent($oLabel);

				$oChkbx = new CXHFieldImage("http://www.gravatar.com/avatar/49453871216937223cb2afbe9ffc688f?d=identicon", "My gravatar identicon", "IMG1", "1");
				
			$oFS->AppendContent($oChkbx);

			$oFS->AppendContent(new CXHBreak());
			
				$oButton = new CXHPushButton(CXHPushButton::sTypeButton, "CMD_BTN", "BTN1");
			
			$oFS->AppendContent($oButton);
			
				$oButton = new CXHPushButton(CXHPushButton::sTypeSubmit, "CMD_SUBMIT", "SUBMIT1");
			
			$oFS->AppendContent($oButton);
			
				$oButton = new CXHPushButton(CXHPushButton::sTypeReset, "CMD_RESET", "RESET1");
			
			$oFS->AppendContent($oButton);
			
		$oForm->AppendContent($oFS);
		
	$oBody->AppendContent($oForm);
	
				$oCell = new CXHCell("Test cell");
	
			$oRow = new CXHRow($oCell);
	
		$oCaption = new CXHCaption("Example of table caption");
	
		$oTable = new CXHTable($oRow, $oCaption);
		$oTable->SetCellspacing("3");
	
			$oColGroup = new CXHColGroup();
			
			$oColGroup->SetHAlign(CXHColGroup::sHACenter);
			
				$oCol = new CXHCol();
			
			$oColGroup->AppendCol($oCol);

				$oCol = new CXHCol();
				$oCol->SetSpan("2");
			
			$oColGroup->AppendCol($oCol);
			
		$oTable->AppendCols($oColGroup);
	
			$oTHead = new CXHTableHead();
	
				$oRow = new CXHRow();
				
					$oCell = new CXHCell("Head test cell1");

				$oRow->AppendCell($oCell);

					$oCell = new CXHCell("Head test cell2");
	
				$oRow->AppendCell($oCell);

			$oTHead->AppendRow($oRow);
				
		$oTable->ReplaceHead($oTHead);
	
			$oTBody = new CXHTableBody();
	
				$oRow = new CXHRow();
				
					$oCell = new CXHCell();
					
					$oCell->AppendContent("Another test cell1");
				
				$oRow->AppendCell($oCell);

					$oCell = new CXHCell();
					
					$oCell->AppendContent("Another test cell2");
				
				$oRow->AppendCell($oCell);

					$oCell = new CXHCell();
					
					$oCell->AppendContent("Another test cell3");
				
				$oRow->AppendCell($oCell);

			$oTBody->AppendRow($oRow);
				
		$oTable->AppendBody($oTBody);

			$oTFoot = new CXHTableFoot();
				
				$oRow = new CXHRow();
				
					$oCell = new CXHCell("Foot test cell 1");
	
				$oRow->AppendCell($oCell);

					$oCell = new CXHCell("Foot test cell 2");
	
				$oRow->AppendCell($oCell);
				
			$oTFoot->AppendRow($oRow);
				
		$oTable->ReplaceHead($oTFoot);
	
	$oBody->AppendContent($oTable);
	
		$sUseMapId = "frog";
	
		$oDiv = new CXHDiv();
			
			$oImg = new CXHImage("george.jpg", "george the wrebbit");
			$oImg->SetUseMap($sUseMapId);
			
		$oDiv->AppendContent($oImg);
	
			$oMap = new CXHMap($sUseMapId);
			
			$oMap->AddArea("http://github.com/", "github.com", CXHArea::sShapeRect, "10,10,500,500");
	
				$oArea = new CXHArea("http://cyb3r.ca", "cyb3r.ca", CXHArea::sShapeCircle, "500,300,100");
	
			$oMap->InsertArea($oArea);
	
		$oDiv->AppendContent($oMap);
	
	$oBody->AppendContent($oDiv);

*/

		$oComment = new CXHComment("test");
	
		$oComment->AddLine("Another test");
		
	$oBody->AppendContent($oComment);
	
$oDoc->ReplaceBody($oBody);

echo $oDoc;

?>