<?php

// Database connection credentials
$usr = "root";
$pwd = "root";

if (file_exists(__DIR__ . '/config_conn.php')) {
    include __DIR__ . '/config_conn.php';
}

//Declare variables
$urlQuery = "https://$serverName/rest-api/topologyQuery"; //URL to execute queries in the CMDB database
$urlAuth = "https://$serverName/rest-api/authenticate"; //Authentication URL

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_PORT => "8443",
  CURLOPT_URL => $urlAuth,
  CURLOPT_SSL_VERIFYHOST => false,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_HEADER => 0,
  CURLOPT_RETURNTRANSFER => 1,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 4,
  CURLOPT_CONNECTTIMEOUT => 4,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\n    \"username\": \"$usr\",\n    \"password\": \"$pwd\",\n    \"clientContext\": 1\n}",
  CURLOPT_HTTPHEADER => array(
    "Accept: */*",
    "Cache-Control: no-cache",
    "Connection: keep-alive",
    "Content-Type: application/json",
    "Host: $serverName",
    "User-Agent: Routing Search/beta 2.0",
    "accept-encoding: gzip, deflate",
    "cache-control: no-cache",
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

$object = json_decode($response, true); //Decode Json by casting it to the array form

//Put the decoded Json to the variable token
$token = $object['token'];

//print "Ваш токен: <strong>" . $token . "</strong>"; // Выведем на экран содержимое переменной token
