<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "sprawadziandb";
$Imiona = [];
$Nazwiska = [];
$Doswiadzczenie = [];
$mysqli = new mysqli($hostname, $username, $password, $database);


if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
// $c = new mysqli("localhost", "root", null, "firma");

if(!$mysqli) die("Brak połączenia z bazą typie");


$sql = "SELECT * FROM sprawdzian";
$result = $mysqli->query($sql);
if ($result) {
    
  while ($row = $result->fetch_assoc()) {
    array_push($Imiona,  $row["Imie"]);
    array_push($Nazwiska,  $row["Nazwisko"]);
    array_push($Doswiadzczenie,  $row["Lata_Doswiadczenia"]);
    // print_r($Imie)
      // echo "ID: " . $row["ID"] . " - Imię: " . $row["Imie"] . " - Nazwisko: " . $row["Nazwisko"] . "Data dodania: " . $row["Data dodania"] ."Staż: " . $row["Lata_Doswiadczenia"] .  "<br>";
  }
};
// print_r($Imie);
// print_r($Nazwiska);
// print_r($Doswiadzczenie);
// echo count($Imiona);
$mysqli->close();

header("Content-type: image/jpeg");
$rysunek = imagecreate(1000, 1000)
  or die("Biblioteka graficzna nie została zainstalowana!");
$kolorbialy = imagecolorallocate($rysunek, 28, 28, 28);
$kolorczarny = imagecolorallocate($rysunek, 255, 255, 255);
imagefill($rysunek, 0, 0, $kolorbialy);
// $length = count($Imie);
for ($i = 0; $i < count($Imiona); $i++) {

  // $kolorslupka = imagecolorallocate($rysunek, $i * 20, 128 - $i * 10, 0);
  $kolorslupka = imagecolorallocate($rysunek, (($i * 20)%255), ((abs(128 - $i * 30))%255), 0);
  imagefilledrectangle(
    $rysunek,
    $i * 100 + 20,
    120 +  $Doswiadzczenie[$i] * 25,
    $i * 100 + 50,
    120,
    $kolorslupka
  );
  imagestring(
    $rysunek,
    400,
    30 + $i * 100,
    80,
    
    $Imiona[$i],
    
    $kolorczarny
  );
  imagestring(
    $rysunek,



    8,
    30 + $i * 100,
    130 + $Doswiadzczenie[$i] * 25,

    $Doswiadzczenie[$i],
    $kolorczarny
  );
}
imagejpeg($rysunek);
?>
<!-- 	imagefilledrectangle(id_rys,x1,y1,x2,y2,kolor) – rysuje prostokąt wypełniony kolorem, 
x1,y1 – współrzędne lewego górnego narożnika, 
x2,y2 – współrzędne prawego dolnego narożnika -->