
<?php
if (isset($_COOKIE['ile'])) {
    $ile = $_COOKIE['ile'];
    $ile++;
} else
    $ile = 1;
echo ("Stronę odwiedziło $ile osób");
setcookie('ile', "$ile");
?>
