<?php
  //require_once('./test.php');
  $cookie_file_path = ""; // path do przechowywania ciasteczek
  $ch = curl_init();
  
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
  curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  
  function get($url)
  {
    global $ch;
    
    curl_setopt($ch, CURLOPT_URL, $url);
    
    curl_setopt($ch, CURLOPT_HEADER, 0);
    
    $res = curl_exec($ch);
    return $res;
  }
  
  function post($fields, $url)
  {
    global $ch;
    
    $POSTFIELDS = http_build_query($fields);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $POSTFIELDS);
    curl_setopt($ch, CURLOPT_URL, $url);
    
    curl_setopt($ch, CURLOPT_HEADER, 0);
    
    $res = curl_exec($ch);
    return $res;
  }
  
  
  get("https://synergia.librus.pl/loguj/portalRodzina?v=1706616867");
  
  
  $r = post(array(
    "action" => "login",
    "login" => 'login',
    "pass" => 'pass',
  ), "https://api.librus.pl/OAuth/Authorization?client_id=46");
  
  
  $r = json_decode($r);
  $goTo = "https://api.librus.pl" . $r->{'goTo'};
  
  $res = post(array(
    "command" => "open_synergia_window",
    "commandPayload" => array(
      "url" => "https:\/\/synergia.librus.pl\/uczen\/index"
    )
  ), $goTo);
  
  
  preg_match_all("|location:\s(.+)|", $res, $out);
  //get($out[1][2]);
  
  
  $res  = get("https://synergia.librus.pl/przegladaj_oceny/uczen");
  
  
  function prefix_urls($html, $prefix) {
    
    $pattern = '/(href|src)=["\']\s*([^"\'\s]+)\s*["\']/i';
    
    
    $modified_html = preg_replace_callback($pattern, function($matches) use ($prefix) {
      $attribute = $matches[1];
      $url = $matches[2];
      
      if (!preg_match('/^(https?:\/\/|\/\/|[a-zA-Z0-9]+:\/\/)/i', $url)) {
        
        $url = $prefix . $url;
      }
      
      
      return $attribute . '="' . $url . '"';
    }, $html);
    
    return $modified_html;
  }
  
  
  $prefix = "https://synergia.librus.pl";
  
  
  $res = get("https://synergia.librus.pl/przegladaj_oceny/uczen");
  $res2 = get("https://synergia.librus.pl/informacja");
  
  $res = prefix_urls($res, $prefix);
  
  
  $dom = new DOMDocument();
  
  
  $dom->loadHTML($res, LIBXML_NOERROR | LIBXML_NOWARNING);
  
  $xpath = new DOMXPath($dom);
  
  $query = '//span[@class="luckyNumber"]/b';
  $elements = $xpath->query($query);  
  if ($elements->length > 0) {
    $luckyNum = intval($elements[0]->textContent);
  }
  
  
  $headerElement = $dom->getElementById('header');
  if ($headerElement !== null) {
    $headerElement->parentNode->removeChild($headerElement);
  }
  $res = $dom->saveHTML();
  $testTable = "";
  
  $query = '//a[contains(@class, "fold-link")]';
  $elements = $xpath->query($query);
  //print_r($elements);
  
  
  
  
  
  $tableHTML = '';
  $tables = $dom->getElementsByTagName('table');
  if ($tables->length > 0) {
    
    $table = $tables->item(5);
    
    
    $tableHTML = $dom->saveHTML($table);
    
    //echo $tableHTML;
    $trArray = array();
    $trs = $table->getElementsByTagName('tr');
    $testTable .= "<table>";
    //print_r($trs);
    for ($i = 0; $i < $trs->length; $i++) {
      
      $tr = $trs->item($i);
      // if($tr['textContent']){
      //echo($tr['textContent']);
      //}
      $trHTML = $dom->saveHTML($tr);
      $testTable .= $trHTML;
      $trArray[] = $trHTML;
      
    }
    $testTable .= "</table>";
    
  }
  
  if ($elements->length > 0) {
    
    $element = $elements->item(0);
    //print_r($element);
    //$element->textContent = "Nowa treść";
    $element->setAttribute('href', "pdf.php");
    $element->childNodes->item(0)->textContent="Wydrukuj w pionie";
    
    $element2 = $elements->item(1);
    $element2->setAttribute('href', "pdf.php?dir=L");
    $element2->childNodes->item(0)->textContent="Wydrukuj w poziomie";
    
    for ($i = 2; $i < $elements->length; $i++) {
      $parentNode = $elements->item($i)->parentNode;
      if ($parentNode !== null) {
        $parentNode->removeChild($elements->item($i));
      }
    }
  }
  
  $query = '//div[contains(@class, "right") and contains(@class, "screen-only")]';
  $elements = $xpath->query($query);
  
  if ($elements->length > 0) {
    $element = $elements->item(0);
    $parentNode = $element->parentNode;
    if ($parentNode !== null) {
      $parentNode->removeChild($element);
    }
    
  } else {
    echo "Nie ma";
  }
  
  
  
  
  function calculateWeightedAverage($marksArray) {
    $totalMarks = 0;
    $totalWeights = 0;
    //print_r($marksArray);
    if(count($marksArray) > 0) {
      foreach ($marksArray as $mark) {
        
        $weight = intval($mark[1]);
        if ($weight > 0) {
          $value = parseMarkValue($mark[0]);
          
          $totalMarks += $value * $weight;
          $totalWeights += $weight;
        } else {
          $slashPos = strpos($mark[0], '/');
          $value = floatval(substr($mark[0], 0, $slashPos));
          $weight = floatval(substr($mark[0], $slashPos + 1));
          if(strpos($mark[0], '*')) {
            $weight=0;         
          }
          //echo "Punktowe";
          
          //$ = intval(substr($title, $wagaPos + 6, 1));
          $totalMarks += $value;
          $totalWeights += $weight;
          
          
        }
      }
      if($marksArray[0][1] == 0) {
        return $totalWeights > 0 ? number_format(($totalMarks / $totalWeights) * 100, 2, '.', '') : "-";
      } else {
        return $totalWeights > 0 ? number_format($totalMarks / $totalWeights, 2, '.', '') : "-";
      }
    } else {
      return "-";
    }
    
  }
  
  function parseMarkValue($mark) {
    if (strpos($mark, '+') !== false) {
      return intval($mark) + 0.5;
    } elseif (strpos($mark, '-') !== false) {
      return intval($mark) - 0.25;
    } else {
      return intval($mark);
    }
  }
  
  
  //$xpath2 = new DOMXPath($tables->item(5));
  $elements = $xpath->query("//table[1]//tr[(contains(@class, 'line0') or contains(@class, 'line1') or contains(@class, 'line1 booled')) and not(@*[name() != 'class'])]");
  $subjects = array();
  $marksData = array();
  $marksData2 = array();
  $marksPropSem1 = array();
  $marksFinSem1 = array();
  $marksFinSem2 = array();
  $marksFinYear = array();
  $Sem1weightedAverage = array();
  $Sem2weightedAverage = array();
  $FinweightedAverage = array();
  $oldRows = array();
  $newRows = array();
  $oldButton = array();
  $newButton = array();
  
  foreach ($elements as $element) {
    //print_r($element->textContent);
    $tds = $xpath->query("td", $element);
    //print_r($tds);
    if ($tds->length > 6) {
      
      $subject = trim($tds->item(1)->textContent);
      //echo $tds->item(1)->textContent;
      if($subject !== "") {
        //echo "Przedmiot: " . $subject. "</br>";
        $sem1Prop = trim($tds->item(4)->textContent);
        $sem1Fin = trim($tds->item(5)->textContent);
        $marksPropSem1[$subject] = trim($tds->item(4)->textContent);
        $marksFinSem1[$subject] = trim($tds->item(5)->textContent);
        $marksFinSem2[$subject] = trim($tds->item(8)->textContent);
        $marksFinYear[$subject] = trim($tds->item(10)->textContent);
        //echo "Proponowan sem1: " . $sem1Prop. "</br>";
        //echo "Semestralna sem1: " . $sem1Fin. "</br>";
        if (!empty($subject)) {
          array_push($subjects, $subject);
          //print_r($td);
          $nextSibling = $tds->item(2);
          if ($nextSibling && $nextSibling->nodeType === XML_ELEMENT_NODE) {
            $nextSiblingContent = trim($nextSibling->textContent);
            if ($nextSiblingContent !== "Brak ocen") {
              $marksData[$subject] = extractMarks($nextSibling);
              $marksData2[$subject] = extractMarks($tds->item(6));
              
              //echo $dom->saveHTML($tds->item(2)->parentNode). "<br>";
            } else if($nextSiblingContent === "Brak ocen") {
              $elements2 = $xpath->query("//table[2]//tr");
              //echo "<table>";
              foreach ($elements2 as $element2) {
                
                $tds2 = $xpath->query("td", $element2);
                
                if ($tds2->length > 6) {
                  $subject2 = trim($tds2->item(1)->textContent);
                  
                  if ($subject2 == $subject) {
                    //echo $subject2;
                    
                    //$marksData[$subject] = extractMarks();
                    //echo $dom->saveHTML($tds2->item(0)->nextSibling) . "<br>";
                    if ($tds2->item(2)->textContent !== "Brak ocen") {
                      //echo "2 TABELA OCENY: " . $tds2->item(2)->textContent . "</br>";
                      $marksData[$subject] = extractMarks($tds2->item(2));
                      $marksData2[$subject] = extractMarks($tds2->item(5));
                      //print_r($marksData[$subject]);
                      //echo "<tr>";
                      //echo $dom->saveHTML($tds->item(2)->parentNode). "<br>";
                      $tds->item(0)->parentNode->replaceChild($tds2->item(5), $tds->item(6));
                      $tds->item(0)->parentNode->replaceChild($tds2->item(2), $tds->item(2));
                      //$tds->item(0)->parentNode->parentNode->replaceChild($tds2->item(0)->parentNode->parentNode->childNodes->item(2), $tds->item(0)->parentNode);
                      //$tds->item(0)->parentNode->nextSibling->insertAfter($tds2->item(0)->parentNode->nextSibling, $tds->item(0)->parentNode->nextSibling);
                      //echo "Podtabela: ";
                      $oldRows[$subject] = $dom->saveHTML($tds->item(0)->parentNode->nextSibling);
                      $oldButton[$subject] = $dom->saveHTML($tds->item(0));
                      $newButton[$subject] = $dom->saveHTML($tds2->item(0));
                      $newRows[$subject] = $dom->saveHTML($tds2->item(0)->parentNode->nextSibling->nextSibling);
                      //print_r($dom->saveHTML($tds2->item(0)));
                      //echo "Tabela2: </br>" . $dom->saveHTML($tds2->item(0)->parentNode->parentNode->childNodes->item(2)). "<br>";
                      //echo "Tabela1: </br>" . $dom->asveHTML($tds->item(0)->parentNode->parentNode->childNodes->item(3)). "<br>";
                      //echo "</br>";
                    }
                  }
                }
              }
              //echo "</table>";
            }
          }
        }
        
        if (isset($marksData[$subject]) && $marksData2[$subject]) {
          $weightedAverage1 = calculateWeightedAverage($marksData[$subject]);
          //print_r($marksData2[$subject]);
          $weightedAverage2 = calculateWeightedAverage($marksData2[$subject]);
          $weightedAverageFin = calculateWeightedAverage(array_merge($marksData[$subject], $marksData2[$subject]));
          $Sem1weightedAverage[$subject] = $weightedAverage1;
          $Sem2weightedAverage[$subject] = $weightedAverage2;
          $FinweightedAverage[$subject] = $weightedAverageFin;
          $tds->item(3)->textContent= strval( $weightedAverage1);
          $tds->item(7)->textContent= strval($weightedAverage2);
          $tds->item(9)->textContent= strval($weightedAverageFin);
          //echo "$subject - Średnia sem1: $weightedAverage1<br>";
          //echo "$subject - Średnia cał: $weightedAverage2<br>";
        } else {
          $tds->item(3)->textContent= strval("-");
          $tds->item(7)->textContent= strval("-");
          $tds->item(9)->textContent= strval("-");
        }
      }
    }
    
  }
  
  //print_r($marksData2);
  
  $elements3 = $xpath->query("//table[1]//tr[(contains(@class, 'bolded line1')) and not(@*[name() != 'class'])]");
  foreach($elements3 as $element) {
    $tds = $xpath->query("td", $element);
    // print_r($tds);
    $subject = trim($tds->item(1)->textContent);
    $sem = trim($tds->item(3)->textContent);
    $fin = trim($tds->item(5)->textContent);
    // echo $fin;
    $Sem1weightedAverage[$subject] = $sem;
    $FinweightedAverage[$subject] = $fin;
    // if ($tds->length > 3) {
    
    // $subject = trim($tds->item(1)->textContent);
    // echo $subject;
    
    // }
    
  }
  $subjects = array_unique($subjects);  
  natcasesort($subjects);
  array_pop($subjects);    
  // print_r($Sem1weightedAverage);
  //  print_r($FinweightedAverage['Zachowanie']);

  
  
  function extractMarks($nextSibling) {
    
    $marksArray = [];
    
    $aElements = $nextSibling->getElementsByTagName('a');
    foreach ($aElements as $aElement) {
      //print_r($aElement);
      $title = $aElement->getAttribute('title');
      $childNodes = $aElement->childNodes;
      
      if (strpos($title, 'Licz do wyniku: TAK') !== false || strpos($title, 'Licz do średniej: tak') !== false) {
        $wagaPos = strpos($title, 'Waga: ');
        $liczPos = strpos($title, 'Licz ');
        if ($wagaPos !== false) {
          $weight = intval(substr($title, $wagaPos + 6, 1));
          
          foreach ($childNodes as $child) {
            $mark = trim($child->textContent);
            //echo $mark;
            if (!empty($mark) && strpos($mark, 'n') === false) {
              //echo $mark . "</br>";
              $marksArray[] = [$mark, $weight];
            }
          }
        } else if($liczPos !== false) {
          $weight = intval(0);
          foreach ($childNodes as $child) {
            $mark = trim($child->textContent);
            //echo $mark;
            if (!empty($mark) && !strpos('n', $mark)) {
              if(strpos($title, 'Licz do puli: NIE') !== false) {
                if(strpos($mark, '/')){
                  //echo strpos(strval($mark), '/');
                  //$mark = substr($mark, 0, strpos(strval($mark), '/') + 1) . '0*';
                  $mark .= '*';
                  //echo $mark . "</br>";
                }
                //$pos = strpos(strval($mark), '/');
                //echo $pos;
                //$mark = substr($mark, 0, strpos($mark, '/') + 1) . '0';
                
                $marksArray[] = [$mark, $weight];
              } else {
                $marksArray[] = [$mark, $weight];
              }
            }
            
          }
          
        }
      }
    }
    return $marksArray;
  }
  
  // echo "<br>" . $subjects[10];
  //echo $tableHTML;
  
  //print_r($subjects);
  //print_r($marksData);
  $dom2= new DOMDocument();
  $dom2->loadHTML($tableHTML, LIBXML_NOERROR | LIBXML_NOWARNING);
  $xpath2 = new DOMXPath($dom2);
  
  
  
  
  
  $dom3 = new DOMDocument();
  
  $dom3->loadHTML($res2, LIBXML_NOERROR | LIBXML_NOWARNING);
  $xpath = new DOMXPath($dom3);
  $query = '//th[text()="Nr w dzienniku "]/following-sibling::td';
  $elements = $xpath->query($query);
  
  
  if ($elements->length > 0) {
    $studentNum = intval($elements[0]->textContent);
  }
  
  $pattern = '/<div class="legend left stretch">/';
  
  $matches = [];
  preg_match($pattern, $res, $matches, PREG_OFFSET_CAPTURE);
  //print_r($oldRows);
  //print_r($newRows);
  
  $res = $dom->saveHTML();
  curl_close($ch);
  
  foreach ($oldRows as $subject => $value) {
    $newRows[$subject] = str_replace("OP_", "", $newRows[$subject]);
    $res = str_replace($oldRows[$subject], $newRows[$subject], $res);
    //$res = str_replace($oldButton[$subject], $newButton[$subject], $res);
    
  }
  
  $pos = strpos($res, 'Oceny punktowe');
  
  if ($pos !== false) {
    
    $pos += strlen('Oceny punktowe');
    
    $res = substr($res, 0, $pos-20);
  }
  //echo $testTable;
  ?>