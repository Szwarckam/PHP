<?php
for ($i = 0; $i < 10; $i++) {
  $liczby[$i] = rand(0, 37);
}
header("Content-type: image/jpeg");
$rysunek = imagecreate(1000, 1000)
  or die("Biblioteka graficzna nie została zainstalowana!");
$kolorbialy = imagecolorallocate($rysunek, 28, 28, 28);
$kolorczarny = imagecolorallocate($rysunek, 255, 255, 255);
imagefill($rysunek, 0, 0, $kolorbialy);

for ($i = 0; $i < 10; $i++) {

  // $kolorslupka = imagecolorallocate($rysunek, $i * 20, 128 - $i * 10, 0);
  $kolorslupka = imagecolorallocate($rysunek, $i * 20, 128 - $i * 10, 255);
  imagefilledrectangle(
    $rysunek,
    40 + $liczby[$i] * 25,
    $i * 100 + 20,
    40,
    $i * 100 + 50,
    $kolorslupka
  );
  // imagefilledrectangle ($rysunek, $i*100+20, 900-$liczby[$i]*200, $i*100+50, 950, $kolorslupka);
  imagestring(
    $rysunek,
    8,
    20,
    30 + $i * 100,
    $i,
    $kolorczarny
  );
  imagestring(
    $rysunek,
    8,
    50 + $liczby[$i] * 25,
    30 + $i * 100,
    $liczby[$i],
    $kolorczarny
  );
}
imagejpeg($rysunek);
?>
<!-- 	imagefilledrectangle(id_rys,x1,y1,x2,y2,kolor) – rysuje prostokąt wypełniony kolorem, 
x1,y1 – współrzędne lewego górnego narożnika, 
x2,y2 – współrzędne prawego dolnego narożnika -->