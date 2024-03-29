<?php


//Data dodaniabase credentials
$hostname = "szwarckam.ct8.pl";
$username = "m41820_user";
$password = "zaq1@WSX";
$database = "m41820_wykresDB";
$width = 1500;
$height = 600;
$month = date('m');

$year = date('y');
$days = cal_days_in_month(CAL_GREGORIAN,  $month, $year);;

$temp = 36.0;

$mysqli = new mysqli($hostname, $username, $password, $database);

if (!$mysqli) die("Brak połączenia z bazą");

if (isset($_GET['w'])) {
  $width = $_GET['w'];
}  
if (isset($_GET['h'])) {
  $height = $_GET['h'];
}  
if (isset($_GET['y'])) {
  $year = $_GET['y'];
}  
if (isset($_GET['m'])) {
  $month = $_GET['m'];
  $days = cal_days_in_month(CAL_GREGORIAN,  $_GET['m'], $year);
  //echo $days;
}
 
$rightMargin = intval($width*0.9);
$leftMargin = intval($width*0.1);
$topMargin =   intval($height*0.05);
$bottomMargin = intval($height*0.85);  
  
$heightUnit = intval(($height * 0.8) / 10);
$widthtUnit = intval(($width * 0.8) / $days);
$img = new Imagick();
$img->newImage($width, $height, new ImagickPixel('white'));
$draw = new ImagickDraw();




  

//print_r($result->fetch_assoc());
  
  
  
$draw->setFillColor('black');

$draw->setFontSize(30);
$draw->setGravity(Imagick::GRAVITY_CENTER);

$img->annotateImage($draw, intval(0 - $width*0.46), 0, -90, 'Temperatura ciała');
//$img->setImageFormat('png');
  
  
$img->annotateImage($draw, 0, intval($height*0.43), 0, 'Dni miesiąca');  
  
$draw->line($leftMargin, $bottomMargin, $rightMargin, $bottomMargin);
$draw->line($leftMargin, $bottomMargin, $leftMargin, $topMargin - 10);

  for ($i=0; $i < 11; $i++) {

  drawLine($draw, $leftMargin - 7, $bottomMargin - ($i * $heightUnit),$leftMargin + 7,  $bottomMargin - ($i * $heightUnit));
  drawText($draw, $leftMargin - 30, $bottomMargin - ($i * $heightUnit ) +8, $temp );
  if($i != 0) {
      if($i == 8) {
        drawDashedLine($draw, $leftMargin +5, $bottomMargin - ($i * $heightUnit),$rightMargin,  $bottomMargin - ($i * $heightUnit), "red");
    } else {
      drawDashedLine($draw, $leftMargin +10, $bottomMargin - ($i * $heightUnit),$rightMargin,  $bottomMargin - ($i * $heightUnit));
    }
    
   }

    //$draw->annotation($leftMargin - 10,$bottomMargin - ($i * $heightUnit ) +5, $temp);
  $temp += 0.2;
};
  
$prevPosX = null;
$prevPosY = null;  
  for ($i=1; $i <= $days; $i++) {
    drawDashedLine($draw, $leftMargin + ($i* $widthtUnit), $bottomMargin -2 ,$leftMargin + ($i* $widthtUnit),  $topMargin-10);
    drawText($draw, $leftMargin + ($i* $widthtUnit) , $bottomMargin +20, $i );
    $sql = "SELECT * FROM temperature  WHERE YEAR(date) = $year AND MONTH(date) = $month  AND DAY(date) = $i  ORDER BY date ASC";
    $result = $mysqli->query($sql);
    $tempValue = 0;
    if ($result) {
    while ($row = $result->fetch_assoc()) {
        //print_r($result->fetch_assoc());
        //print_r($row);

      $tempValue = $row['value'] <= 36 ? null : ($row['value']-36) * 5;
      
    };
    // echo $tempValue;
               // echo "<br>";
      
   if($prevPosX && $prevPosY) {
    drawLine($draw, $prevPosX, $prevPosY,  $leftMargin + ($i* $widthtUnit) ,  $bottomMargin - ($heightUnit * $tempValue), "red");
   }   
      
   $color = "blue";
   if($tempValue == null) {
     $color = "grey";
     $tempValue = 0;
     } else if($tempValue > 8 ){
     $color = "red";
        $prevPosX = $leftMargin + ($i* $widthtUnit);
       $prevPosY = ($heightUnit * $tempValue);
     } else {
         $prevPosX = $leftMargin + ($i* $widthtUnit);
       $prevPosY = ($heightUnit * $tempValue);
     }    

   drawCircle($draw, $leftMargin + ($i* $widthtUnit),$bottomMargin - ($heightUnit * $tempValue), 5, $color);
 
   //$draw->circle($originX, $originY, $endX, $endY);
 };
};


//echo $tempValue."<br>";





 drawLine($draw, $leftMargin +5, $bottomMargin - (8 * $heightUnit),$rightMargin,  $bottomMargin - (8 * $heightUnit), "red");
  
  

  

/* New ImagickDraw instance for ellipse draw */


//for ($i=1; $i <= $days; $i++) {
   // drawDashedLine($draw, $leftMargin + ($i* $widthtUnit), $bottomMargin -2 ,$leftMargin + ($i* $widthtUnit),  $topMargin-10);
  //  drawText($draw, $leftMargin + ($i* $widthtUnit) , $bottomMargin +20, $i );
  //$draw->annotation($leftMargin - 10,$bottomMargin - ($i * $heightUnit ) +5, $temp);
//};

/* Set purple fill color for ellipse */
//$draw->setFillColor('#ffffff');
/* Set ellipse dimensions */
$draw->setFillColor('#1c1c1c');


/* Draw ellipse onto the canvas */





function drawText($draw, $x,$y,$text) {
  $draw->setGravity(Imagick::GRAVITY_CENTER);
  $draw->setTextAlignment(Imagick::ALIGN_CENTER);
  $draw->setStrokeColor('none');
  $draw->setFillColor('black');
  $draw->setFontSize(20);
   
  $draw->annotation($x,$y, $text);
 //$img->annotateImage($img, intval($x), intval($y), $angle, $text);
}
 
  
function drawCircle($draw, $x,$y, $r,$color) {
  $draw->setGravity(Imagick::GRAVITY_CENTER);
  $draw->setStrokeColor($color);
  $draw->setFillColor($color);
  $draw->setFontSize(20);
  $draw->circle($x, $y, $x + $r, $y);
 //$img->annotateImage($img, intval($x), intval($y), $angle, $text);
}
 
function drawDashedLine(&$draw, $x1,$y1,$x2,$y2, $color = "grey") {
  $draw->setStrokeColor('#ffffff');
  $draw->setFillColor($color);
  $draw->setStrokeDashArray([2, 2]);
  $draw->line(intval($x1), intval($y1), intval($x2), intval($y2));
     
}
  
function drawLine($draw, $x1,$y1,$x2,$y2, $color = "black") {
  $draw->setFillColor($color);
 $draw->setStrokeColor('none');
 $draw->line(intval($x1), intval($y1), intval($x2), intval($y2));
     
};
/* Center text horizontally and vertically */

$img->setImageFormat('png');
$img->drawImage($draw);
/* Set appropriate header for PNG and output the image */
header('Content-Type: image/png');
echo $img;

$mysqli->close();
?>
