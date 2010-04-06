<?php


####
##	CONFIGS BELOW SOULDN'T BE EDITED
####


##	XPiD-Fw DIFFERENTIAL
##
if (!defined("XPIDFW"))
{
	define("XPIDFWDIFF", "");
	
	define("XPIDFWDIFFSEP", "");

	if (!defined("PATH_SEPARATOR"))
	{
		if ( strpos($_ENV["OS"], "Win") !== false)
			define("PATH_SEPARATOR", ";");
		else
			define("PATH_SEPARATOR", ":");
	}

	set_include_path(get_include_path().PATH_SEPARATOR.INCLUDEPATH);
}
else
{
	define("XPIDFWSEP", "/");
}


##	Blueprint CSS Framework
##
define("CSS_BLUEPRINT_RESET",	LIBBASEURL.XPIDFWDIFF."/lib/css/blueprint/reset.css");
define("CSS_BLUEPRINT_TYPO",	LIBBASEURL.XPIDFWDIFF."/lib/css/blueprint/typography.css");
define("CSS_BLUEPRINT_FORMS",	LIBBASEURL.XPIDFWDIFF."/lib/css/blueprint/forms.css");
define("CSS_BLUEPRINT_GRID",	LIBBASEURL.XPIDFWDIFF."/lib/css/blueprint/grid.css");
define("CSS_BLUEPRINT_PRINT",	LIBBASEURL.XPIDFWDIFF."/lib/css/blueprint/print.css");
define("CSS_BLUEPRINT_SCREEN",	LIBBASEURL.XPIDFWDIFF."/lib/css/blueprint/screen.css");
define("CSS_BLUEPRINT_IE",	LIBBASEURL.XPIDFWDIFF."/lib/css/blueprint/ie.css");
define("CSS_BLUEPRINT_LIQUID",	LIBBASEURL.XPIDFWDIFF."/lib/css/blueprint/plugins/liquid/liquid.css");


##	Default CSS Framework
##
define("CSS_DEFAULT_TYPO",	LIBBASEURL.XPIDFWDIFF."/lib/css/default/typography.css");


##	Paternal CSS Framework
##
define("CSS_LOTUS_TYPO",	LIBBASEURL.XPIDFWDIFF."/lib/css/lotus/typography.css");


##	Library Helpers
##
require_once(XPIDFWDIFF.XPIDFWDIFFSEP."helpers/spyc-0.4.5/spyc.php");
require_once(XPIDFWDIFF.XPIDFWDIFFSEP."helpers/textile-2.0.0/classTextile.php");


##	XPiD Base Library	
##
require_once(XPIDFWDIFF.XPIDFWDIFFSEP."lib/XH6.inc.php");


?>
