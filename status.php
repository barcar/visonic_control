<?php
ini_set('display_errors', 'On');

require_once 'login.php';

$status_headers = array("Host: " . HOST  ,
                       "Accept: */*",
                       "User Agent: " . USER_AGENT,
                       "Accept-Language: en-gb",
                       "Session-Token: " . $session_token);

#print_r($status_headers);
#echo "<br>";

echo "<p>Checking connection status...</p>";

$attempts = 1;
$max_attempts = 5;
  
while ( ($is_connected <> true) || ($attempts < $max_attempts) ) {
  
  echo "<p>Attempt #$attempts/$max_attempts<p>";
  
  $curl = curl_init(STATUS_URI);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
  curl_setopt($curl, CURLOPT_HTTPHEADER, $status_headers);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  
  $json_response = curl_exec($curl);
  
  $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  
  if ( $status != 200 ) {
      die("Error: call to Status URI failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
  }
  
  curl_close($curl);
  
  #print_r($json_response);
  #echo "<br>";

  $response = json_decode($json_response, true);
  #print_r($response);
  #echo "<br>";

  # Array ( [is_connected] => 1 [exit_delay] => 60 [partitions] => Array ( [0] => Array ( [partition] => P1 [state] => Disarm [ready_status] => 1 ) ) ) 
  # Check that partition is ready to arm ???

  $is_connected = $response['is_connected'];
  #print_r($is_connected);
  #echo "<br>";

  if (! isset($is_connected)) {
      die("Error - connection status missing from response!");
  }

  if ( ! $is_connected ) {
    echo "<p>Sleeping 5 seconds before retry.</p>";
    $attempts++;
    sleep(5);
  } else {
    echo "<p>Connection confirmed.</p>";
    $attempts = $max_attempts;
  }
 
}


if (! $is_connected) {
    die("Error - Failed to connect to panel after $max_attempts attempts.");
} else {
    print_r($response);
    echo "<br>";
}

?>