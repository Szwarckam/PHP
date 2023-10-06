<?php
$operator = $_GET["operator"];
$value1 = $_GET['val'];
$value2 = $_GET['val2'];
if($value2 == 0){
    echo "Nie tak";
} else {
    switch($operator){
        case "+":
            echo $value1 + $value2;
            break;
        case "-":
            echo $value1 - $value2;
            break;
        case "*":
            echo $value1 * $value2;
            break;
        case "/":
            echo $value1 / $value2;
            break;
        default:
            echo "Zły operator koleżko";
    }
}
?>























































































































































































