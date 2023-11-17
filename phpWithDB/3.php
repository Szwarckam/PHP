<?php
mysqli_report(MYSQLI_REPORT_OFF);
$conn = @mysqli_connect("127.0.0.1", "root", null, "kszwarc"); //brak hasła to można dać nulla
if (!$conn) {
    die("Nie ma aktualnie dostępu");
}  
// $result = mysqli_query($conn,"SELECT * FROM pracownicy") or die("SELECT nie ładzia");
$result = mysqli_query($conn,"SELECT imie, nazwisko FROM pracownicy") or die("SELECT nie ładzia");
while ($row = mysqli_fetch_array($result) ) { //or die("Tabela jest pusta")
    echo $row['imie']." ".$row['nazwisko']."<br>";
    // echo $row[0]." ".$row[1];
    // echo "<br>";
}


mysqli_close($conn);



?>
<!-- 
(⌐■_■)
(⊙_⊙;) -->