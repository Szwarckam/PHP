<html>
<pre>
<?php
$cookie_file_path = ""; // path do przechowywania ciasteczek 
$ch = curl_init();
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path); // "The name of the file containing the cookie data ..."
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // "Set CURLOPT_RETURNTRANSFER to TRUE to return the transfer as a string of the return value of curl_exec()"
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // "true to follow any "Location: " header that the server sends as part of the HTTP header."

get("https://synergia.librus.pl/loguj/portalRodzina?v=1706616867");
$r = post(array(
    "action" => "login",
    "login" => "",
    "pass" => "",
), "https://api.librus.pl/OAuth/Authorization?client_id=46");
$r = json_decode($r);
$goTo = "https://api.librus.pl" . $r->{'goTo'};

curl_setopt($ch, CURLOPT_HEADER, 1);
$res = post(array(
    "command" => "open_synergia_window",
    "commandPayload" => array(
        "url" => "https:\/\/synergia.librus.pl\/uczen\/index"
    )
), $goTo);
// echo $res;
preg_match_all("|location:\s(.+)|", $res, $out);
// print_r($out);
get($out[1][2]);
$res  = get("https://synergia.librus.pl/przegladaj_oceny/uczen");
echo $res;
curl_setopt($ch, CURLOPT_HEADER, 0);

function get($url)
{
    global $ch;
    curl_setopt($ch, CURLOPT_URL, $url); // "The URL to fetch."
    $res = curl_exec($ch);
    return $res;
}

function post($fields, $url)
{
    global $ch;
    $POSTFIELDS = http_build_query($fields);
    curl_setopt($ch, CURLOPT_POST, 1); // "true to do a regular HTTP POST."
    curl_setopt($ch, CURLOPT_POSTFIELDS, $POSTFIELDS); // "The full data to post in a HTTP "POST" operation."
    curl_setopt($ch, CURLOPT_URL, $url);
    $res = curl_exec($ch);
    return $res;
}
