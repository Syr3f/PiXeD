<?php


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
define("CSS_BLUEPRINT_RESET",	LIBBASEURL."/lib/css/blueprint/reset.css");
define("CSS_BLUEPRINT_TYPO",	LIBBASEURL."/lib/css/blueprint/typography.css");
define("CSS_BLUEPRINT_FORMS",	LIBBASEURL."/lib/css/blueprint/forms.css");
define("CSS_BLUEPRINT_GRID",	LIBBASEURL."/lib/css/blueprint/grid.css");
define("CSS_BLUEPRINT_PRINT",	LIBBASEURL."/lib/css/blueprint/print.css");
define("CSS_BLUEPRINT_SCREEN",	LIBBASEURL."/lib/css/blueprint/screen.css");
define("CSS_BLUEPRINT_IE",		LIBBASEURL."/lib/css/blueprint/ie.css");
define("CSS_BLUEPRINT_LIQUID",	LIBBASEURL."/lib/css/blueprint/plugins/liquid/liquid.css");


##	Default CSS Framework
##
define("CSS_DEFAULT_TYPO",	LIBBASEURL."/lib/css/default/typography.css");


##	Paternal CSS Framework
##
define("CSS_LOTUS_TYPO",	LIBBASEURL."/lib/css/lotus/typography.css");


require_once("lib/XH6.inc.php");


?>
