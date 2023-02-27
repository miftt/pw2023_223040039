<?php
echo "Mulai. <br>";
// 1. Inisialisasi / nilai awal
// 2. Kondisi terminasi / kapan pengulangannya berhenti
// 3. increment / decrement
$nilaiAwal = 1; // inisialisasi
while ($nilaiAwal <= 10) { // kondisi terminasi
    echo "hello world $nilaiAwal x <br>";
    $nilaiAwal += 1; // Increment
}
echo "Selesai. <br>";

echo "<hr>";

echo "Mulai. <br>";
for ($nilaiAwal = 1; $nilaiAwal <= 5; $nilaiAwal++) {
    echo "Hello World $nilaiAwal x<br>";
}
echo "Selesai. <br>";
