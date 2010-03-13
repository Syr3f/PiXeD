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
 *	@package Template
 */

 
/**
 *	@todo To document
 */
class CXHModeler extends CXHDoc
{
	public function __construct($sTitle = "My XDiP Modeler Document", $sEncoding = "UTF-8", $sLanguage = "en")
	{
		parent::__construct($sTitle, $sEncoding, $sLanguage);
		
			$oCSS = new CXHCSS(CSS_BLUEPRINT_RESET);
		
		parent::AppendToHeader($oCSS);

			$oCSS = new CXHCSS(CSS_BLUEPRINT_TYPO);
		
		parent::AppendToHeader($oCSS);

			$oCSS = new CXHCSS(CSS_BLUEPRINT_FORMS);
		
		parent::AppendToHeader($oCSS);

			$oCSS = new CXHCSS(CSS_BLUEPRINT_LIQUID);
		
		parent::AppendToHeader($oCSS);

			$oCSS = new CXHCSS(CSS_BLUEPRINT_PRINT);
		
		parent::AppendToHeader($oCSS);
	}
	
	
	public function __toString()
	{
		$oDiv = new CXHDiv();
	
		return parent::__toString();
	}
}

?>