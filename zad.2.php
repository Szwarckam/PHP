<style>
    td {
    border: 5px groove grey;
    text-align: center;
  }
</style>
<?php
$c = 1;
$table = "<table>";
for ($i=1; $i <= 5; $i++) { 
  $table .= "<tr>";
  for ($j=1; $j <= 8 ; $j++) {
    if($i == 1 || $j == 1){ 
    $res =  $j * $c;
    $table .= "<th> $res </th>";
    } else {
      $res =  $j * $c;
    $table .= "<td> $res </td>";
    }
  }
  $table .= "</tr>";
  // echo "<br>";
  $c++;
}
$table .= "</table";
echo $table;
?>
