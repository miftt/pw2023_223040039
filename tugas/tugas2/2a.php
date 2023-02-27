<?php
$namaDepan = "Miftah";
$namaBelakang = "Fauzi";

for ($i = 1; $i <= 100; $i++) {
    if ($i % 3 == 0 && $i % 5 == 0) {
        echo $namaDepan . " " . $namaBelakang . "<br>";
    } else if ($i % 3 == 0) {
        echo $namaDepan . "<br>";
    } else if ($i % 5 == 0) {
        echo $namaBelakang . "<br>";
    } else {
        echo $i . "<br>";
    }
}
