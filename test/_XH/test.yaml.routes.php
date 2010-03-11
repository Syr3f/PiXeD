<?php


include("../../pwl.inc.php");
include("../_SPYC/spyc/spyc.php");


$oDoc = new CXHDoc();

$aYAML = Spyc::YAMLLoad("routes.yml");

$oPre = new CXHPre(print_r($aYAML, true));

$oDoc->AppendToBody($oPre);


echo $oDoc;

?>