<?php

include("../../PXD.inc.php");

$sContentStyle = <<<CS
body
{
	font-family:Georgia, serif;
}
CS;

$oDoc = new CXHDocument("en");


	$oHead = new CXHHead();
	
		$oTitle = new CXHTitle("Test PXD3");
	
	$oHead->AppendContent($oTitle);
	
		$oBase = new CXHBase("http://pixed.cyb3r.ca/tests/PXD3/");
	
	$oHead->AppendContent($oBase);
	
		$oEncoding = new CXHMeta("Content-Type", "", "text/html;charset=UTF-8");
		
	$oHead->AppendContent($oEncoding);
	
		$oLink = new CXHLink("test.css", "text/css", "stylesheet");
	
	$oHead->AppendContent($oLink);

		$oStyle = new CXHStyle("text/css");
		
		$oStyle->SetMedia("screen");
		
		$oStyle->AppendContent($sContentStyle);

	$oHead->AppendContent($oStyle);


		//$oScript = new CXHScript("javascript", "test.js");
		// or by script integration
		$oScript = new CXHScript("javascript");
		$oScript->AddFileContent("test.js");
	
	$oHead->AppendContent($oScript);
	
		$oNoScript = new CXHNoScript();
	
	$oHead->AppendContent($oNoScript);
	
$oDoc->ReplaceHead($oHead);
	
	$oBody = new CXHBody();
	
		$oDiv = new CXHDiv("This is a div element.");
		
			$oP = new CXHParagraph("This is a paragraph in a div element.");
			
		$oDiv->AppendContent($oP);
		
	$oBody->AppendContent($oDiv);
	
		$oH1 = new CXHHeading();
	
		$oH1->AppendContent("Hello World 1!");
		$oH1->AddStyle("color", "#666");
		$oH1->AddEvent("onclick", "alert('Hello again!')");
	
	$oBody->AppendContent($oH1);

		$oH2 = new CXHHeading(CXHHeading::iLvl2);
	
		$oH2->AppendContent("Hello World 2!");
	
	$oBody->AppendContent($oH2);

		$oH3 = new CXHHeading(CXHHeading::iLvl3);
	
		$oH3->AppendContent("Hello World 3!");
	
	$oBody->AppendContent($oH3);

		$oH4 = new CXHHeading(CXHHeading::iLvl4);
	
		$oH4->AppendContent("Hello World 4!");
	
	$oBody->AppendContent($oH4);

		$oH5 = new CXHHeading(CXHHeading::iLvl5);
	
		$oH5->AppendContent("Hello World 5!");
	
	$oBody->AppendContent($oH5);

		$oH6 = new CXHHeading(CXHHeading::iLvl6);
	
		$oH6->AppendContent("Hello World 6!");
	
	$oBody->AppendContent($oH6);
	
		$oUL = new CXHUnorderedList();
		
		$oUL->AddItem("This is item 1");
		
			$oLI = new CXHListItem("This is item 2");
			
		$oUL->InsertItem($oLI);
		
	$oBody->AppendContent($oUL);

		$oOL = new CXHOrderedList();
		
		$oOL->AddItem("This is item 1");
		
			$oLI = new CXHListItem("This is item 2");
			
		$oOL->InsertItem($oLI);
		
	$oBody->AppendContent($oOL);
	
		$oDL = new CXHDefList();
		
		$oDL->AddTerm("Term 1");
		
		$oDL->AddDef("This is the definition 1 of term 1");
		
			$oDT = new CXHTerm("Term 2");
		
		$oDL->InsertTerm($oDT);

			$oDD = new CXHDef("This is the definition 1 of term 2");
		
		$oDL->InsertDef($oDD);
		
	$oBody->AppendContent($oDL);
		
		$oAddress = new CXHAddress();
		
		$oAddress->AppendContent("Santa Claus, North Pole, H0H 0H0");
		
	$oBody->AppendContent($oAddress);
		
		$oHR = new CXHHRule();
		
	$oBody->AppendContent($oHR);
	
		$oPre = new CXHPre();
		
		$oPre->AppendContent($sContentStyle);
		
	$oBody->AppendContent($oPre);
	
		$oBq = new CXHBlockquote();
		
			$sLorem = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc convallis aliquet nunc vel commodo. Nullam pretium commodo lectus, quis consequat velit ullamcorper non. Ut vitae blandit sem. Vestibulum blandit diam pharetra risus tempus posuere. Quisque ligula massa, molestie vitae posuere eget, lobortis et nunc. Sed a tempor sem. Quisque rhoncus mi id turpis molestie viverra. Nulla ut metus turpis, nec feugiat mi. Nunc dolor sem, fermentum a fringilla sit amet, fermentum et eros. Vestibulum est erat, volutpat ac dapibus quis, consectetur porttitor nibh. Aenean ac erat dolor. Nullam dapibus tincidunt ligula vel luctus. Curabitur et tellus non augue accumsan pulvinar et sed mauris.";
			
			$sCite = "http://www.lipsum.com/";
		
		$oBq->AppendContent($sLorem);
		
		$oBq->SetCite($sCite);
	
	$oBody->AppendContent($oBq);
	
		$oIns = new CXHInsertion($sCite, "2010-04-27", $sLorem);
		
	$oBody->AppendContent($oIns);
	
		$oDel = new CXHDeletion($sCite, "2010-04-27", $sLorem);
	
	$oBody->AppendContent($oDel);
	
		$oA = new CXHAnchor($sCite, "Lorem Ipsum");
	
	$oBody->AppendContent($oA);

	/*	
	
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
*/
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
			
		$oImg = new CXHImage("george.jpg", "george wrebbit");
		$oImg->SetUseMap($sUseMapId);
			
	$oBody->AppendContent($oImg);
	
		$oMap = new CXHMap($sUseMapId);
		
		$oMap->AddArea("http://github.com/", "github.com", CXHArea::sShapeRect, "10,10,100,100");

			$oArea = new CXHArea("http://cyb3r.ca", "cyb3r.ca", CXHArea::sShapeCircle, "100,300,100");

		$oMap->InsertArea($oArea);
	
	$oBody->AppendContent($oMap);

		$oComment = new CXHComment("test");
	
		$oComment->AddLine("Another test");
		
	$oBody->AppendContent($oComment);
	
$oDoc->ReplaceBody($oBody);

echo $oDoc;

?>