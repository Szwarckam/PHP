<?php
  require_once('./server.php');
  
  $tableToPDF = '
    <style>
    table,th,td {
    margin: 0;
    font-size: 10px;
    border: 2px solid black;
    border-collapse: collapse;
    text-align: center;
    padding: 3px;
    vertical-align: auto;
    text-wrap: nowrap;
    }
    .subj {
    
    }
    
    </style>
    <table>
    <thead>
    <tr>
    <th rowspan="2" >Przedmiot</th>
    <th colspan="4">Okres 1</th>
    <th colspan="3">Okres 2</th>
    <th colspan="2">Koniec roku</th>
    </tr>
    <tr>
    <th>Oceny bieżące</th>
    <th>Śr. I</th>
    <th>(I)</th>
    <th>I</th>
    <th>Oceny bieżące</th>
    <th>Śr. II</th>
    <th>II</th>
    <th>Śr. R</th>
    <th>R</th>
    </tr>
    </thead>
    <tbody>
    
    ';  
  //print_r($marksData);
  //print_r($marksData2);
  //foreach ($marksData as $subject => $values) {
  //echo $subject . "</br> Sem1: ";
  //print_r($values);
  //echo "</br> Sem2: ";
  //print_r($marksData2[$subject]);
  //echo "</br>";
  //}
  
  foreach ($marksData as $subject => $values) {
    $tableToPDF.='
      <tr>
      <td > '.
      $subject .'
      </td>
      <td>';
    foreach ($values as $key => $value) {
      $tableToPDF .= intval($value[1]) !== 0 ? $value[0] . '(' . $value[1] . ')': $value[0];
      $tableToPDF .= $key !== count($values) - 1 ? ', ' : ' ';
    }
    $tableToPDF.= '</td><td>';
    if (isset($Sem1weightedAverage[$subject])) {
      $tableToPDF.= $Sem1weightedAverage[$subject];
    } else {
      $tableToPDF.= '-';
    }
    $tableToPDF.= '</td><td>';
    
    if (isset($marksPropSem1[$subject])) {
      $tableToPDF.= $marksPropSem1[$subject];
    } else {
      $tableToPDF.= '-';
    }
    $tableToPDF.= '</td><td>';
    
    if (isset($marksFinSem1[$subject])) {
      $tableToPDF.= $marksFinSem1[$subject];
    } else {
      $tableToPDF.= '-';
    }
    $tableToPDF.= '</td><td>';
    
    foreach ($marksData2[$subject] as $key => $value) {
      $tableToPDF .= intval($value[1]) !== 0 ? $value[0] . '(' . $value[1] . ')': $value[0];
      $tableToPDF .= $key !== count($marksData2[$subject]) - 1 ? ', ' : ' ';
    }
    $tableToPDF.= '</td><td>';
    
    if (isset($Sem2weightedAverage[$subject])) {
      $tableToPDF.= $Sem2weightedAverage[$subject];
    } else {
      $tableToPDF.= '-';
    }
    
    
    $tableToPDF.= '</td><td>';
    
    if (isset($marksFinSem2[$subject])) {
      $tableToPDF.= $marksFinSem2[$subject];
    } else {
      $tableToPDF.= '-';
    }
    
    
    $tableToPDF.= '</td><td>';
    
    if (isset($FinweightedAverage[$subject])) {
      $tableToPDF.= $FinweightedAverage[$subject];
    } else {
      $tableToPDF.= '-';
    }
    
    $tableToPDF.= '</td><td>';
    
    if (isset($marksFinYear[$subject])) {
      $tableToPDF.= $marksFinYear[$subject];
    } else {
      $tableToPDF.= '-';
    }
    $tableToPDF.= '
      </td>
      </tr>
      ';
  }  

  $tableToPDF.= '
  <tr>
  <td>Zachowanie</td>
  <td> - </td>
  <td> - </td>
  <td> - </td><td>' ;
  if (isset($Sem1weightedAverage['Zachowanie'])) {
    $tableToPDF.= $Sem1weightedAverage['Zachowanie'];
  } else {
    $tableToPDF.= '-';
  }
  $tableToPDF.= '</td>';
  $tableToPDF.= '  <td> - </td> <td> - </td><td> - </td><td>-</td><td>';
  if (isset($FinweightedAverage['Zachowanie'])) {
     $tableToPDF.= $FinweightedAverage['Zachowanie'];
  } else {
    $tableToPDF.= '-';
  }
  $tableToPDF.='
    </td>
    </tr>
    </tbody>
    </table>
    ';
  // echo $tableToPDF;
  