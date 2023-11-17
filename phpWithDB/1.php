<?php
mysqli_report(MYSQLI_REPORT_OFF);
$conn = @mysqli_connect("127.0.0.1", "root", null); //brak hasła to można dać nulla
if (!$conn) {
    // echo "Nie ma serwera";
    die("Nie ma aktualnie dostępu");
}  
// $conn = @mysqli_connect("127.0.0.1", "root", "null"); //złe hasło, wywala błąd o zabronieniu dostępu
// $result = mysqli_query($conn,"SELECT  'Ala ma kota'");
// $result = mysqli_query($conn,"SEMLETC  'Ala ma kota' AS tekst") or die("SELECT nie ładzia");
$result = mysqli_query($conn,"SELECT  'Ala ma kota' AS tekst") or die("SELECT nie ładzia");
$row = mysqli_fetch_array($result);
echo $row['tekst'];
// echo $row[0];
mysqli_close($conn);
// $mysqli=newmysqli("example.com", "user","password", "database");
// $result = $mysqli->query("SELECT  'Ala ma kota' AS tekst");
// $row = $result->fetch_assoc();
// echo $row['tekst'];
// $result->close();
// $mysqli->close();



?>


(⌐■_■)
(⊙_⊙;)