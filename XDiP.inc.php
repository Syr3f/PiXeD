<?php


##	EDIT BASE URL RELATIVE TO THE XDiP LIBRARY
##
define("LIBBASEURL", "");


####
##	CONFIGS BELOW SOULDN'T BE EDITED
####

##	Blueprint CSS Framework
##
define("CSS_BLUEPRINT_RESET",	LIBBASEURL."/lib/css/blueprint/src/reset.css");
define("CSS_BLUEPRINT_TYPO",	LIBBASEURL."/lib/css/blueprint/src/typography.css");
define("CSS_BLUEPRINT_FORMS",	LIBBASEURL."/lib/css/blueprint/src/forms.css");
define("CSS_BLUEPRINT_LIQUID",	LIBBASEURL."/lib/css/blueprint/plugins/liquid/liquid.css");
define("CSS_BLUEPRINT_PRINT",	LIBBASEURL."/lib/css/blueprint/print.css");


include("lib/XH1.inc.php");
#include("XH2.inc.php");

include("lib/XHModeler.inc.php");


?>