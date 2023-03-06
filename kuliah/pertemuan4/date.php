<?php
echo date("l, d-m-y") . "<br>";

// UNIX TIME
// echo time();

echo "dalam 100 hari lagi hari berubah menjadi hari " . date("l", time() + 60 * 60 * 24 * 100) . "<br>";

echo "dalam 100 hari kebelakang maka hari berubah menjadi hari " . date("l", time() - 60 * 60 * 24 * 100) . "<br>";

// MK TIME
// MEMBUAT DETIK SENDIRI
// mktime(0,0,0,0,0)
// jam menit detik bulan tanggal tahun
echo "Saya di lahirkan di hari " . date("l", mktime(0, 0, 0, 1, 27, 2004)) . "<br>";

// strtotime()
echo date("l", strtotime("27 january 2004"));
