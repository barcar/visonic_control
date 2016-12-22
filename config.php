<?php
ini_set('display_errors', 'On');

# From Visonic Control Panel
define("USER_CODE", "1234");

# From iOS app settings & Charles proxy sniff
define("PANEL_WEB_NAME", "123456");
define("HOST", "visonic.tycomonitor.com");
define("PARTITION", "P1");

# From https://www.uuidgenerator.net/version4
define("USER_ID", "f4f91292-6c6b-4164-9d5f-a1367fcd089a");

# Static values from Charles Proxy sniff
define("APP_TYPE", "com.visonic.PowerMaxApp");
define("USER_AGENT", "Visonic-GO/2.6.8 CFNetwork/808.1.4 Darwin/16.1.0");
define("LOGIN_URI", "https://visonic.tycomonitor.com/rest_api/3.0/login");
define("STATUS_URI", "https://visonic.tycomonitor.com/rest_api/3.0/status");
define("ARM_URI", "https://visonic.tycomonitor.com/rest_api/3.0/arm_away");
define("DISARM_URI", "https://visonic.tycomonitor.com/rest_api/3.0/disarm");
?>