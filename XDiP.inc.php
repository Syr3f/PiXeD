<?php


##	EDIT BASE URL RELATIVE TO THE XDiP LIBRARY
##
define("LIBBASEURL", "");


##	EDIT BASE URL RELATIVE TO THE XDiP LIBRARY
##
define("INCLUDEPATH", "");


####
##	CONFIGS BELOW SOULDN'T BE EDITED
####


if (!defined("PATH_SEPARATOR"))
{
	if ( strpos($_ENV["OS"], "Win") !== false)
		define("PATH_SEPARATOR", ";");
	else
		define("PATH_SEPARATOR", ":");
}


set_include_path(get_include_path().PATH_SEPARATOR.INCLUDEPATH);


##	Blueprint CSS Framework
##
define("CSS_BLUEPRINT_RESET",	LIBBASEURL."/lib/css/blueprint/src/reset.css");
define("CSS_BLUEPRINT_TYPO",	LIBBASEURL."/lib/css/blueprint/src/typography.css");
define("CSS_BLUEPRINT_FORMS",	LIBBASEURL."/lib/css/blueprint/src/forms.css");
define("CSS_BLUEPRINT_PRINT",	LIBBASEURL."/lib/css/blueprint/print.css");
define("CSS_BLUEPRINT_SCREEN",	LIBBASEURL."/lib/css/blueprint/screen.css");
define("CSS_BLUEPRINT_IE",		LIBBASEURL."/lib/css/blueprint/ie.css");
define("CSS_BLUEPRINT_LIQUID",	LIBBASEURL."/lib/css/blueprint/plugins/liquid/liquid.css");


#include(LIBBASEURL."/lib/XH1.inc.php");
#include("XH2.inc.php");
include("lib/XH3.inc.php");


?>