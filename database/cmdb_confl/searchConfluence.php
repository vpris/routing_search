<?php

$hostnameConfl = 'confluence.atlassian.com';
$credentConfl = 'Your username and password are encrypted'; // You can also transfer a token. Do not forget to change the authorization type from Basic to Bearer.

if (file_exists(__DIR__.'/config_conn.php')) {
    include __DIR__.'/config_conn.php';
}

$req = $_GET["term"];
$reqw = urlencode($req);
$conflUrl = "https://$hostnameConfl";
$symbols1 = "%22";
$symbols2 = "%22";
$star = "*";
$linkReq = "{$symbols1}{$reqw}{$star}{$symbols2}";
$q = 'cql=space=sdesk%20and%20type=' . $chbxAtt . '%20and%20' . $chbx . '%20~%20' . $linkReq  . '*?';
//print $q . '<br>';

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://$hostnameConfl/rest/api/content/search?$q",
  CURLOPT_SSL_VERIFYHOST => false,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_HEADER => 0,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 10,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "",
  CURLOPT_HTTPHEADER => array(
    "Accept: */*",
    "Authorization: Basic $credentConfl",
    "Cache-Control: no-cache",
    "Connection: keep-alive",
    "Content-Type: application/json",
    "Host: $hostnameConfl",
    "accept-encoding: gzip, deflate",
    "User-Agent: Routing Search/beta2.0",
    "cache-control: no-cache",
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
$object = json_decode($response, true); // Раскодируем Json, приведя его к виду массива

print "<div class='resultCount'>" . "Найдено результатов: " . $object['size'] . "</div>";

if(is_array($object['results'])) {
    $results = array_filter($object['results']);
} else {
    $results = array();
}

if(!empty($results)) {
    foreach ($results as $result) {
        $urlss = "{$conflUrl}{$result['_links']['webui']}";
        print "<div class='confluenceResult'>
                    <div class='confluenceResultTitle'>
                        <a href='$urlss' target='_blank'>$result[title]</a>
                    </div>
                    <div class='confluenceResultType'>
                      Тип:  $result[type]
                    </div>
                    <div class='confluenceResultUrl'>";
        print   $conflUrl . $result['_links']['webui'];
        print   "</div>";

        print "<div class='confluenceResultBody'>";
        print $result['excerpt'] . "...";
        print "</div>";
        print "</div>";
    }
} else {
    print "<div class='notFound'>Ошибка! Попробуйте изменить запрос. Допускается поиск неполного слова.</div>";
}
