
<?php


//Data dodaniabase credentials
$hostname = "localhost";
$username = "root";
$password = "";
$database = "sprawdzianphp";
$Imiona = [];
$Nazwiska = [];
$Doswiadzczenie = [];
$mysqli = new mysqli($hostname, $username, $password, $database);

if (!$mysqli) die("Brak połączenia z bazą");
if (isset($_GET['day'])) {
  $day = $_GET['day'];
  $result = $mysqli->query("UPDATE sprawdzian SET Liczba = Liczba + 1 WHERE ID = $day");
}
$sql = "SELECT * FROM sprawdzian";
$result = $mysqli->query($sql);

if ($result) {
  echo "Jaki jest twój ulubiony dzień tygodnia ?" . "</br>";
  echo "<form method='GET'>";

  while ($row = $result->fetch_assoc()) {

    // array_push($Imiona,  $row["Liczba"]);
    // array_push($Nazwiska,  $row["Nazwa"]);
    echo "<label for=" .  $row["ID"] . ">" . $row["Nazwa"] . "<input type='radio' id=" . $row["ID"] . " value=" .  $row["ID"] . " name='day' ></label></br>";
  }
  echo "<input type='submit'> ";
  echo "</form>";
  $result->free();
} else {
  echo "Error: " . $mysqli->error;
}
echo "</table>";





$sql = "SELECT * FROM sprawdzian";
$result = $mysqli->query($sql);
if ($result) {
  $rysunek = imagecreate(1000, 1000);
  $kolorbialy = imagecolorallocate($rysunek, 28, 28, 28);
  $kolorczarny = imagecolorallocate($rysunek, 255, 255, 255);
  $i = 0;
  $suma = 0;
  while ($row = $result->fetch_assoc()) {
    imagestring(
      $rysunek,
      100,
      10,
      10 + $i * 50,
      $row["Nazwa"],
      $kolorczarny
    );
    $kolorslupka = imagecolorallocate($rysunek, (($i * 50) % 255), ((abs(128 - $i * 30)) % 255), 255);
    imagefilledrectangle(
      $rysunek,
      150,
      $i * 50,
      160 + $row['Liczba'] * 20,
      $i * 50 + 40,
      $kolorslupka
    );
    imagestring(
      $rysunek,
      10,
      170 + $row["Liczba"] * 20,
      10 + $i * 50,
      $row["Liczba"],
      $kolorczarny
    );
    $i++;
    $suma += $row["Liczba"];
  }
  imagestring(
    $rysunek,
    10,
    20,
    30 + $i * 50,
    "Suma " . $suma,
    $kolorczarny,
  );
};

imagejpeg($rysunek, "wykres.png");
echo "<img src='wykres.png'>";


$mysqli->close();
?>