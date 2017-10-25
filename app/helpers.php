<?php

function countTable($n){
  $jumlah = 0;
  while($n > 0){
    $jumlah += $n - 1;
    $n--;
  }
  return $jumlah;
}

function ri($count)
{
    $ri = [
        1 => 0,
        2 => 0,
        3 => 0.52,
        4 => 0.89,
        5 => 1.11,
        6 => 1.25,
        7 => 1.35,
        8 => 1.4,
        9 => 1.45,
        10 => 1.49,
        11 => 1.52,
        12 => 1.54,
        13 => 1.56,
        14 => 1.57,
        15 => 1.59
    ];
    return $ri[$count];
}
?>
