# visonic_control

** STOP: Visonic changed their API (to v8 according to https://visonic.tycomonitor.com/rest_api/version) so this approach no longer works. This project might be your best bet going forward: https://github.com/And3rsL/VisonicAlarm2. Their commits reference upgrading to API v8** 

----------
 
This project consists of basic PHP scripts to arm, disarm and check status of a Visonic PowerMaster security alarm by emulating the Visonic Go app talking to the RESTful web service which is connected to a PowerLink 3 module in the alarm.

These scripts are quick and dirty - I'm sure somebody with better PHP skills can improve them but they get the job done. The workings of the web service were determined via the Charles Web Debugging Proxy monitoring the Visonic Go app. 

Of course this is unsupported by Visonic - they don't publish their REST API. It is also unsupported by me. I accept no liability for your use of the scripts nor for any loss or damage resulting from security breaches at your property.

**Of particular note is that all SSL checking is disabled when connecting to the Visonic service. This is _clearly_ a VERY BAD IDEA. But it works.**

# pre-requisites

- A working Visonic Powermaster alarm with a PowerLink 3 module installed and connected
- A configured Visonic Go app on your phone which can successfully arm and disarm the alarm system
- The credentials needed to configure the Visonic Go app (web panel id, host, user code)
- A host with a web server capable of serving PHP content (configuring this is out of scope - I just use my QNAP NAS)
- The files from this repository downloaded to the host and published via the web server
- Network access from the host to the internet for interaction with the Visonic service

**It goes without saying that anybody with access to the web server can arm and disarm your alarm so take a moment to think about that risk and make sure it is secured appropriately.**

# usage

- **USER_CODE** : should be a valid user code on your alarm - a PIN you can use at the keypad to arm and disarm the alarm. I created a special user code just for these scripts so that I can differentiate scripted access from control panel access.
- **PANEL_WEB_NAME** : should be the panel web name displayed in the settings of your control panel and as used in the Visonic Go app.
- **HOST** : should be the host name specified in your Visonic Go app.
- **PARTITION** : should be the internal name of the partition you want to arm/disarm - in single partition systems it will be "P1" or you can use "ALL" to have the scripts arm the whole system.
- **USER_ID** : should be a unique Version 4 UUID generated at https://www.uuidgenerator.net/version4 - think of this as identifying your scripts as a unique device to Visonic - if you have multiple Visonic Go apps they will each have their own UUID.

```
docker run --rm -ti -p 8099:80 -e USER_CODE=XXXX -e PANEL_WEB_NAME=XXXXX -e HOST=XXXXX -e USER_ID=`uuidgen chrisns/visonic
```

Point your browser at one of the PHP files to activate the required function namely:

- http://your.host/visonic_control/status.php
- http://your.host/visonic_control/arm.php
- http://your.host/visonic_control/disarm.php

Where neccesary the PHP script will call the login or status scripts to achieve the required function.

# further enhancements

Use Home Assistant (https://home-assistant.io) to create a Command Line Switch which you can then control with Amazon Echo (Alexa) or via HomeBridge (https://github.com/nfarina/homebridge) with Apple Siri. So you can say "Turn on burglar alarm" to arm your system via Alexa.

You might like to configure Home Assistant Command Line Switch to only allow Alexa to arm the system so that strangers can't walk into your home and tell Alexa to disarm it.

You could probably do something similar with FauxMo (https://github.com/makermusings/fauxmo) which is a fake WeMo switch. I haven't tried that but can't see why it wouldn't work.

# behind the scenes 

- The Visonic Go app and these scripts use your configured credentials to post to the LOGIN_URI
- It then monitors the STATUS_URI until the panel is connected - this can take a little while so it will make a few attempts
- Once connected it displays status and, if required, makes further calls to the ARM_URI or DISARM_URI to change the system status
