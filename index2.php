<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form>
        <!-- <input type="text" name="imie" id="imie">
        <input type="text" name="nazwisko" id="nazwisko"> -->
        <input type="number" name="pesel" id="pesel">
        <button type="submit">Zatwierdź</button>
    </form>
<?php

if(isset($_GET['pesel'])){
    // $imie = trim($_GET['imie']);
    // $nazwisko = trim($_GET['nazwisko']);
    $pesel = trim($_GET['pesel']);
    // echo substr($imie, 0 ,1).substr($nazwisko, 0 ,1);
    // echo $imie[0].$nazwisko[0];
    (int)$controlNum = $pesel[-2];
    echo $controlNum;
    echo "</br>";
    if(strlen($pesel) == 11){
        if($controlNum % 2 == 0){
            echo "  to prawdopodobnie kobieta";
        }  else {
            echo "to prawdopodobnie mężczyzna";
        }
    $y = substr($pesel, 0, 2);
    $m = substr($pesel, 2, 2);
    $d = substr($pesel, 4, 2);
    // $pesel = (int)$pesel;
    // echo 
    echo "<br>";
    // echo "miesiąc</br>";
    echo $d."</br>".$m."</br>".$y."</br>";
    // echo $y;
    // echo $d;
    }   
    if ($m >= 20 && $m <= 30) {
        $m = $m-20;
        echo "Data urodzenia osoby o numerze Pesel $pesel to: $d.0$m.20$y r. ";
      }
       elseif ($m > 30 && $m <= 40) {
        $m = $m- 20;
        echo "Data urodzenia osoby o numerze Pesel $pesel to: $d.$m.20$y r. ";
      } else {
        echo "Data urodzenia osoby o numerze Pesel $pesel to: $d.$m.19$y r. ";
      };
    
    } else {
      echo "Numer PESEL: $pesel jest niepoprawny.";
    }


?>


</body>
</html>
