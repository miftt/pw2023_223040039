<?php
// Array
// Array adalah variabel yang bisa menampung banyak nilai / variable

// membuat array
$hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
$bulan = ['Januari', 'Februari', 'Maret'];
$myArray = ['Miftah', 1, false];
$binatang = ['🐕', '🐇', '🐒', '🦝', '🐄'];

// Mencetak array
var_dump($hari);
print_r($bulan);
var_dump($myArray);
echo ($binatang[3]);

echo "<br>";

//Manipulasi Array
// Menambah Elemen di akhir array
$bulan[] = 'April';
$bulan[] = 'Mei';
print_r($bulan);

echo "<hr>";

array_push($bulan, 'Juni', 'Juli', 'Agustus');
print_r($bulan);

echo "<hr>";

// Menambah Elemen di awal array
array_unshift($binatang, '🐍', '🐔');
print_r($binatang);

echo "<hr>";

//Menghapus elemen di akhir array
array_pop($hari);
print_r($hari);

echo "<hr>";

// menghapus elemen di awal array
array_shift($hari);
print_r($hari);
