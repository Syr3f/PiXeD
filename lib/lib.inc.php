<?php


####
##	CONFIGS BELOW SOULDN'T BE EDITED
####


##	SPnDX DIFFERENTIAL
##
if (!defined("SPnDX"))
{
	define("SPnDXDIFF", "");
	
	define("SPnDXDIFFSEP", "");

	if (!defined("PATH_SEPARATOR"))
	{
		if ( strpos($_ENV["OS"], "Win") !== false)
			define("PATH_SEPARATOR", ";");
		else
			define("PATH_SEPARATOR", ":");
	}

	set_include_path(get_include_path().PATH_SEPARATOR.LIBPATH);
}


##	XD Base Library	
##
require_once(LIBPATH.SPnDXDIFF.SPnDXDIFFSEP."/XH2.inc.php");


?>
