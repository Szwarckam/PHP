<img  src="img2.php" alt="Wyjebało się">
<?php


// Data dodaniabase credentials
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
if(isset($_GET['Imie'], $_GET['Nazwisko'], $_GET['Data_dodania'])){
  $Imie = $_GET['Imie'];
  $Nazwisko = $_GET['Nazwisko'];
  $DataDodania = $_GET['Data_dodania'];
  echo "Dodano pracownika: $Imie $Nazwisko";
  $mysqli->query("INSERT INTO sprawdzian (Imie, Nazwisko, Data_dodania) VALUES ('$Imie', '$Nazwisko', '$DataDodania')") or die("INSERT nie działa"); //zapytanie sql
}


$sql = "SELECT * FROM sprawdzian";


$result = $mysqli->query($sql);

echo "
  <table>
  <tr>
    <th>ID</th>
    <th>Imie</th>
    <th>Nazwisko</th>
    <th>Data dodania</th>
    <th>Staż</th>
  </tr>
  "
;

if ($result) {
    
    while ($row = $result->fetch_assoc()) {
        // echo "ID: " . $row["ID"] . " - Imię: " . $row["Imie"] . " - Nazwisko: " . $row["Nazwisko"] . "Data dodania: " . $row["Data dodania"] ."Staż: " . $row["Lata_Doswiadczenia"] .  "<br>";
        array_push($Imiona,  $row["Imie"]);
        array_push($Nazwiska,  $row["Nazwisko"]);
        array_push($Doswiadzczenie,  $row["Lata_Doswiadczenia"]);
        echo "<tr>"
        . "<td>". $row["ID"] . "</td>" 
        . "<td>". $row["Imie"] . "</td>" 
        . "<td>". $row["Nazwisko"] . "</td>" 
        . "<td>". $row["Data_dodania"] . "</td>" 
        . "<td>". $row["Lata_Doswiadczenia"] . "</td>" 
        ."</tr>";
    }

    // print_r($Imiona). "<br>";
    // print_r($Nazwiska). "<br>";
    // print_r($Doswiadzczenie). "<br>";
    $result->free();
} else {
    echo "Error: " . $mysqli->error;
}
echo "</table>";
$mysqli->close();

?>
<form>

<form method="GET">
    Imię: <input type="text" name="Imie"> <br />
    Nazwisko: <input type="text" name="Nazwisko"> <br />
    Data : <input type="date" name="Data_dodania"> <br />
    <input type="submit" value="dodaj">
</form>
