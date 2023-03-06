<?php
echo "<h4> Menghitung Luas Lingkaran </h4>";
function hitungLuasLingkaran($r)
{
    echo "Jari-Jari = $r cm <br>";
    echo "Luas Lingkaran = " . (3.14 * $r * $r) . " cm²";
    return $r;
}

hitungLuasLingkaran(10);
echo "<hr>";

echo "<h4> Menghitung Luas Lingkaran </h4>";
function hitungKelilingLingkaran($r)
{
    echo "Jari-Jari = $r cm <br>";
    echo "Keliling Lingkaran  = " . (2 * 3.14 * $r) . " cm";
    return $r;
}

hitungKelilingLingkaran(20);
echo "<hr>";
