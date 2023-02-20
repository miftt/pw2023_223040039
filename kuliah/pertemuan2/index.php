<?php
    $nama = "Miftah";
    $mataKuliah = "Programman Web 1"?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pertemuan 2</title>
</head>
<body>
    <h1>
        <?php 
        echo "Hello $nama";?>
    </h1>
    <p>
        <?php
        echo $mataKuliah; ?>
    </p>
    <p> <?php
        echo "Halo, nama saya $nama , saya sedang kuliah di $mataKuliah" ?> 
    </p>
</body>
</html>