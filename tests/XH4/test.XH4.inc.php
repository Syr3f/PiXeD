<?php

include("../../_dev/cyb3r.inc.php");

$oDoc = new CXH2DocBlock();

	// CXH2TableBloc

	$oTable = new CXH2TableBlock();
	$oTable->AddAttr("border", "1");

		$oCell = new CXHCell("test");

	$oTable->AppendToRow($oCell);

	$oTable->AppendRowToPart(CXH2TableBlock::iBody);

$oDoc->AppendToBody($oTable);

	// CXH2FormField
	
	$oFormField = new CXH2FormField("test");

$oDoc->AppendToBody($oFormField);

echo $oDoc;

?>