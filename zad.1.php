<?php
$max = 20;
$min = -20;
$arr = [];
$rep = [];
for ($i=0; $i < 30 ; $i++) { 
  // echo $i ;
  array_push($arr, rand($min, $max)) ;
  echo $arr[$i];
  echo "<br>";
  
}
for ($j=0; $j < count($arr) ; $j++) {
  for ($k=0; $k <  count($arr) ; $k++) {
    if ($j != $k) {
      if ($arr[$j] == $arr[$k]) {
        $res =  array_search($arr[$k], $rep);
        if (!is_int($res)) {
          array_push($rep, $arr[$k]);
          continue;
        }
      };
    } 
    
  } 
}
echo "Powtarzające się: ";
echo "<br>";
for ($d=0; $d < count($rep) ; $d++) { 
  echo $rep[$d];
  echo "<br>";
}
// print_r($rep)
// echo "Powtarzające się: ";
// foreach ($rep as $val){
//   echo $val;
//   echo "<br>";
// }
// echo "<br>";