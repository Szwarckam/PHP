<?php
// mysqli_report(MYSQLI_REPORT_OFF);
$conn = @mysqli_connect("127.0.0.1", "root", null, "kszwarc"); //brak hasła to można dać nulla
$result = mysqli_query($conn, "UPDATE counter1 SET Num=Num+1");
$rs =  mysqli_query($conn, "SELECT  Num  FROM  counter1")["Num"];
echo  $rs[1];
mysqli_close($conn);

// echo "Liczba odświerzeń: " . $Num;
