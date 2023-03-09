<?php
// apakah sebuah bilangan ganjil atau genap
function cek_ganjil_genap($angka) // parameter
{
    // jika angka dibagi 2, sisanya 1 maka itu bilangan ganjil
    if ($angka % 2 === 1) {
        return "$angka adalah bilangan ganjil";
    } else { // selain dari 
        return "$angka adalah bilangan genap";
    }
}
echo cek_ganjil_genap(10); // argument = nilai aslinya
echo "<br>";
echo cek_ganjil_genap(5);
echo "<br>";
echo cek_ganjil_genap(500);
