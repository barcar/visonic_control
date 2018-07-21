<?php
ini_set('display_errors', 'On');

# From Visonic Control Panel
define("USER_CODE", $_ENV["USER_CODE"]);

# From iOS app settings & Charles proxy sniff
define("PANEL_WEB_NAME", $_ENV["PANEL_WEB_NAME"]);
define("HOST", $_ENV["HOST"]);
define("PARTITION", "P1");

# From https://www.uuidgenerator.net/version4
define("USER_ID", $_ENV["USER_ID"]);

# Static values from Charles Proxy sniff
define("APP_TYPE", "com.visonic.PowerMaxApp");
define("USER_AGENT", "Visonic-GO/2.6.8 CFNetwork/808.1.4 Darwin/16.1.0");
define("LOGIN_URI", "https://" . HOST . "/rest_api/3.0/login");
define("STATUS_URI", "https://" . HOST . "/rest_api/3.0/status");
define("ARM_URI", "https://" . HOST . "/rest_api/3.0/arm_away");
define("DISARM_URI", "https://" . HOST . "/rest_api/3.0/disarm");
?>