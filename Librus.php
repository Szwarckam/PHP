<html>
<pre>
<?php
echo "<head>";

$styles = [
    "/js/librus-component/data-table/librus-data-table.css?v2",
    "/js/librus-component/panel/librus-panel.css?v1",
    "/js/librus-component/notification/librus-notification.css?v4",
    "/js/librus-component/dialog/librus-dialog.css?v1",
     "/js/jquery/themes/base/jquery.ui.all.1285316921.css",
     "/js/jquery/jquery-ui-1.9.2.custom/css/librus/jquery-ui-1.9.2.custom.min.1422664051.css",
     //"/js/jquery/jquery-ui-1.9.2.custom/css/librus/librus-aditional.1507325373.css",
     //"/assets/css/fancybox/jquery.fancybox-1.3.4.css",
     "/LibrusStyleSheet2.1674858050.css",
     //"/LibrusPrintStyleSheet2.1495831305.css",
     "/LibrusStyleSheet2NonIE.1361960241.css",
      //"/LibrusStyleSheet2IE.1615587149.css",
     // "/LibrusStyleSheet2IE7.1371460280.css",
     //"/LibrusStyleSheet2IE8.1367217179.css",
      //"/LibrusStyleSheet2IE9.1366628972.css",
     "/LibrusStyleSheet2Light.1637964526.css",
     "/LibrusStyleSheet2LightGreen.1628259748.css", // kolor
     "/assets/css/synergia.1615587149.css",
     "/assets/css/style.1679696063.css",
     "/js/newLayout/SparkBoxSelect/sparkbox-select.css",
     "/jquery.treeview.css",
     "/assets/css/tippy/tippy.css",
     "/assets/css/tippy-theme.css",
     "/js/jquery/jquery.multiselect.1628259749.css",
     "/js/fancybox/jquery.fancybox-1.3.4.css",
];
foreach ($styles as $style) {
    echo '<link rel="stylesheet" href="https://synergia.librus.pl'. $style . '">';
};
echo "</head>";
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
//echo $res;
preg_match_all("|location:\s(.+)|", $res, $out);
//print_r($out);
get($out[1][2]);
$res  = get("https://synergia.librus.pl/przegladaj_oceny/uczen");
//echo $res;
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
$res = preg_match("", $res);
echo $res;
