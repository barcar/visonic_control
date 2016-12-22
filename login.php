<?php
ini_set('display_errors', 'On');

require_once 'config.php';

$login_array = array("user_code" => USER_CODE,
                     "app_type" => APP_TYPE,
                     "user_id" => USER_ID,
                     "panel_web_name" => PANEL_WEB_NAME);

$login_json = json_encode($login_array);

#print_r($login_json);
#echo "<br>";

$login_headers = array("Host: " . HOST  ,
                       "Content-Type: application/json",
                       "Accept: */*",
                       "User Agent: " . USER_AGENT,
                       "Accept-Language: en-gb",
                       "Content-Length: " . strlen($login_json));

#print_r($login_headers);
#echo "<br>";

echo "<p>Logging on...</p>";

$curl = curl_init(LOGIN_URI);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl, CURLOPT_HTTPHEADER, $login_headers);
curl_setopt($curl, CURLOPT_POSTFIELDS, $login_json);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

$json_response = curl_exec($curl);

$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

if ( $status != 200 ) {
    die("Error: call to Login URI failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
}

curl_close($curl);

#print_r($json_response);
#echo "<br>";

$response = json_decode($json_response, true);
$session_token = $response['session_token'];

if (!isset($session_token) || $session_token == "") {
    die("Error - session token missing from response!");
}

echo "<p>Logged on with session token $session_token.</p>";

?>