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
      <p>Arming Visonic</p>
<?php
ini_set('display_errors', 'On');

#@session_start(); 
      
echo '<p>Attempting to arm system...</p>';

require_once 'config.php';
require_once 'login.php';
require_once 'status.php';

$arm_array = array("partition" => PARTITION);

#print_r ($arm_array);
#echo "<br>";

$arm_json = json_encode($arm_array);

#print_r ($arm_json);
#echo "<br>";

$arm_headers = array("Host: " . HOST  ,
                       "Content-Type: application/json",
                       "Accept: */*",
                       "User Agent: " . USER_AGENT,
                       "Accept-Language: en-gb",
                       "Session-Token: " . $session_token,
                       "Content-Length: " . strlen($arm_json));

#print_r ($arm_headers);
#echo "<br>";
#echo "<p>" . ARM_URI . "</p>";

$curl = curl_init(ARM_URI);
#curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST'  );
curl_setopt($curl, CURLOPT_HTTPHEADER, $arm_headers);
curl_setopt($curl, CURLOPT_POSTFIELDS, $arm_json);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

#$x = curl_getinfo($curl);
#print_r ($x);
#echo "<br>";

$json_response = curl_exec($curl);

$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

if ( $status != 200 ) {
    die("Error: call to Arm URI failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
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
  echo "System armed with process token $process_token.";
  echo "<br>";
}

?>
</body>
</html>