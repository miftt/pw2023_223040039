<?php
function urutanAngka($angka)
{
    $angkaAwal = 1;
    for ($i = 1; $i <= $angka; $i++) {
        for ($j = 1; $j <= $i; $j++) {
            echo $angkaAwal . " ";
            $angkaAwal++;
        }
        echo "<br>";
    }
}
echo urutanAngka(5);
