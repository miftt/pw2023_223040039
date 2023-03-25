<?php 
$mahasiswa = [
    [
        "nama" => "Miftah Fauzi",
        "nrp" => "223040039",
        "email" => "miftahfauzi012@gmail.com",
        "jurusan" => "Teknik Informatika",
        "gambar" => "0.jpg"
    ],
    [
        "nama" => "Rama Dhaniaji Refin",
        "nrp" => "223040040",
        "email" => "rama@gmail.com",
        "jurusan" => "Teknik Informatika",
        "gambar" => "1.jpg"
    ],
    [
        "nama" => "Rizky Abdurrahman",
        "nrp" => "223040037",
        "email" => "rizky@gmail.com",
        "jurusan" => "Teknik Informatika",
        "gambar" => "2.jpg"
    ],
    [
        "nama" => "Muhammad Alief Arrizal Effendi",
        "nrp" => "223040061",
        "email" => "arrizal@gmail.com",
        "jurusan" => "Teknik Informatika",
        "gambar" => "3.jpg"
    ],
    [
        "nama" => "Muhammad Pandu Permana",
        "nrp" => "223040042",
        "email" => "pandu@gmail.com",
        "jurusan" => "Teknik Informatika",
        "gambar" => "4.jpg"
    ],
    [
        "nama" => "Reza Fahrezi",
        "nrp" => "223040044",
        "email" => "reza@gmail.com",
        "jurusan" => "Teknik Informatika",
        "gambar" => "5.jpg"
    ],
    [
        "nama" => "Arya Saputra",
        "nrp" => "223040051",
        "email" => "arya@gmail.com",
        "jurusan" => "Teknik Informatika",
        "gambar" => "6.jpg"
    ],
    [
        "nama" => "Muhammad Rachka Fauziansyah",
        "nrp" => "223040036",
        "email" => "rachka@gmail.com",
        "jurusan" => "Teknik Informatika",
        "gambar" => "7.jpg"
    ],
    [
        "nama" => "Muhammad Rafly Alfarizi",
        "nrp" => "223040043",
        "email" => "rafly@gmail.com",
        "jurusan" => "Teknik Informatika",
        "gambar" => "8.jpg"
    ],
    [
        "nama" => "Rayyan Naufal Andriyana",
        "nrp" => "223040065",
        "email" => "rayyan@gmail.com",
        "jurusan" => "Teknik Informatika",
        "gambar" => "9.jpg"
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>5a</title>
</head>
<body>
    <h1>Daftar Mahasiswa</h1>
    <?php foreach($mahasiswa as $mhs): ?>
    <ul>
        <li><img src="img/<?= $mhs["gambar"];?>"></li>
        <li>Nama: <?= $mhs["nama"] ;?></li>
        <li>Nrp: <?= $mhs["nrp"] ;?></li>
        <li>Email: <?= $mhs["email"] ;?></li>
        <li>jurusan: <?= $mhs["jurusan"] ;?></li>
    </ul>
    <?php endforeach ?>
</body>
</html>