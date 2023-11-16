<?php
$result = "";
function revWords($sen) {
    $slowa = str_word_count($sen, 1);
    // print_r($slowa);
    foreach ($slowa as &$wyraz) {
        if (strlen($wyraz) % 2 == 0) {
            $wyraz = strrev($wyraz);
        } elseif (strlen($wyraz) % 2 == 1) {
            $wyraz =  ucfirst($wyraz);
            $wyraz = strrev($wyraz);
            $wyraz = ucfirst($wyraz);
            $wyraz = strrev($wyraz);
            
          }
          echo $wyraz;
          echo " ";
      }
    
    // return implode(' ', $slowa);
}

// Przykład użycia
$sen = strtolower("Kolorowe kwiaty rozwiewają się na letnim wietrze");
$result = revWords($sen);

echo "Oryginalne zdanie: $sen"."<br>";
echo $result;