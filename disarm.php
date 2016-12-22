<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <title>Visonic Arm</title>
    </head>
    <body>
      <p>Disarming Visonic</p>
<?php
ini_set('display_errors', 'On');

#@session_start(); 
      
echo '<p>Attempting to disarm system...</p>';

require_once 'config.php';
require_once 'login.php';
require_once 'status.php';

$disarm_array = array("partition" => PARTITION);

#print_r ($disarm_array);
#echo "<br>";

$disarm_json = json_encode($disarm_array);

#print_r ($disarm_json);
#echo "<br>";

$disarm_headers = array("Host: " . HOST  ,
                       "Content-Type: application/json",
                       "Accept: */*",
                       "User Agent: " . USER_AGENT,
                       "Accept-Language: en-gb",
                       "Session-Token: " . $session_token,
                       "Content-Length: " . strlen($disarm_json));

#print_r ($disarm_headers);
#echo "<br>";
#echo "<p>" . DISARM_URI . "</p>";

$curl = curl_init(DISARM_URI);
#curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST'  );
curl_setopt($curl, CURLOPT_HTTPHEADER, $disarm_headers);
curl_setopt($curl, CURLOPT_POSTFIELDS, $disarm_json);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

#$x = curl_getinfo($curl);
#print_r ($x);
#echo "<br>";

$json_response = curl_exec($curl);

$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

if ( $status != 200 ) {
    die("Error: call to Disarm URI failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
}

curl_close($curl);

$response = json_decode($json_response, true);
#print_r ($response);
#echo "<br>";

$process_token = $response['process_token'];
#print_r ($process_token);
#echo "<br>";

if (!isset($process_token) || $process_token == "") {
    die("Error - process token missing from response!");
} else {
  echo "System disarmed with process token $process_token.";
  echo "<br>";
}

?>
</body>
</html>