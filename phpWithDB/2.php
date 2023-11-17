<style>
    td,
    th {
        border: 2px solid black;
        width: 200px;
    }

    th,
    input {
        background-color: black;
        color: wheat;
        border-color: wheat;
        width: 200px;
    }

    input[type="text"] {
        position: absolute;
        left: 100px;
    }

    table {
        border-collapse: collapse;
    }
</style>
<?php
$buttonText = "Dodaj";
$imie = "";
$nazwisko = "";
$id = 0;

mysqli_report(MYSQLI_REPORT_OFF);
$mysqli = @new mysqli("127.0.0.1", "root", null, "kszwarc");

if (isset($_GET['akcja'])) {
    $akcja = $_GET['akcja'];
    // $id = $_GET['id']
    switch ($akcja) {
        case 'Dodaj':
            if (isset($_GET['imie'], $_GET['nazwisko'])) {
                $imie = $_GET['imie'];
                $nazwisko = $_GET['nazwisko'];
                $mysqli->query("INSERT INTO pracownicy(imie, nazwisko) VALUES('$imie', '$nazwisko')") or die("Wybombiło ci INSERTA");
                $imie = "";
                $nazwisko = "";
                $id = "";
            }
            break;
        case 'Usuń':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $result = $mysqli->query("DELETE FROM pracownicy WHERE id_pracownika=$id") or die("Usuwanie nie działa");
            }
            break;
        case 'Edytuj':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $rs =  $mysqli->query("SELECT imie, nazwisko FROM pracownicy WHERE id_pracownika=$id") or die("SELECT nie ładzia");
                $row = $rs->fetch_assoc();
                $nazwisko = $row['nazwisko'];
                $imie = $row['imie'];
                $buttonText = "Zapisz";
            }
            break;
        case 'Zapisz':
            $id = $_GET['id'];
            $imie = $_GET['imie'];
            $nazwisko = $_GET['nazwisko'];
            $mysqli->query("UPDATE  pracownicy SET imie='$imie', nazwisko='$nazwisko' WHERE id_pracownika=$id") or die("UPDATE nie ładzia");
            $imie = "";
            $nazwisko = "";
            $id = "";
            break;
    }
}
$result = $mysqli->query("SELECT id_pracownika id, imie, nazwisko FROM pracownicy") or die("SELECT nie ładzia");
if ($result->num_rows > 0) {
    echo "<table><tr><th>Imię</th><th>Nazwisko</th><th>Usuwanie</th><th>Edycja</th></tr>";
    while ($row = $result->fetch_assoc()) { //or die("Tabela jest pusta")
        echo "<form><tr>
        <td><input type='hidden' name='id' value='{$row['id']}'>{$row['imie']}</td>
        <td>{$row['nazwisko']}</td>
        <td><input type='submit' name='akcja' value='Usuń'>
        </td><td><input type='submit' name='akcja' value='Edytuj'></td>
        </tr></form>";
        // echo $row['imie']." ".$row['nazwisko']."<br>";   
    }
    echo "</table>";
} else {
    echo "Brak pracowników";
}

// echo $row['tekst'];
$result->close();
$mysqli->close();

echo "<form method='GET'>
    <input type='hidden' name='id' value='$id'>
    Imię:<input type='text' name='imie' id='imie' required value='$imie'><br>
    Nazwisko:<input type='text' name='nazwisko' id='nazwisko' required value='$nazwisko'><br>
    <input type='submit' value='$buttonText' name='akcja'>
</form>";
?>
<!-- 
(⌐■_■)
(⊙_⊙;) -->