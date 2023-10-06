<?php
// $tab = array(
//     "jeden"=> "pierwszy",
//     "dwa"=> "drugi",
//     "trzy"=> "trzeci",
// );
$tab1=array(
    'pierwszy' => 'Ala',
    'drugi' => 'ma',
    'trzeci' => 'kota');
    
// echo $tab["jeden"];
// echo  ksort($tab);
echo (implode(" ",$tab1))."</br>";

foreach($tab1 as $x => $x_value) {
    echo "Key=" . $x . ", Value=" . $x_value;
    echo "<br>";
  };

for($i = 0; $i<101;){
    $random = rand(1, 200);
    $tab2[$i] =  $random;
    if($random > 50){
    echo $tab2[$i]."</br>";
    $i++;
    }
};
echo "</br> Posortowanie </br>";
// sort($tab2, SORT_STRING);
sort($tab2);
for($i = 0; $i<11; $i++){
    echo $tab2[$i]."</br>";
    
};
echo count($tab2);
$characters = [];



 //Funkcje
 echo "</br>";
function stars ($val){
    for($i = 0; $i < $val; $i++){
        echo "*";
    }
    echo "</br>";
}
stars(2);
stars(5);
?>