<?php

$arr = [];
for ($i=0; $i < 30 ; $i++) { 
  // echo $i ;
  array_push($arr, rand(-20, 20)) ;
  echo $arr[$i];
  echo "<br>";
  
};
$counts = array_count_values($arr);

foreach ($counts as $element => $count) {
    if ($count > 1) {
        echo "Element $element występuje $count razy.\n";
    }
}
