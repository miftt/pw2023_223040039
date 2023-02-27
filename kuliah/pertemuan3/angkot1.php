<?php
$jumlahAngkot = 10;
$noAngkot = 1;

while ($noAngkot <= 5) {
    echo "Angkot no.$noAngkot beroperasi dengan baik <br>";
    $noAngkot++;
}

for ($noAngkot = 6; $noAngkot <= $jumlahAngkot; $noAngkot++) {
    echo "Angkot no.$noAngkot sedang rusak <br>";
}
