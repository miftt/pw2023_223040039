<?php
function salam($nama = "Admin")
{
    date_default_timezone_set('Asia/Jakarta'); // set timezone sesuai dengan wilayah
    $jam = date('H'); // H yang berarti ambil jam saat ini dari waktu lokal
    if ($jam >= 1 && $jam <= 8) {
        $waktu = "Pagi";
    } elseif ($jam >= 9 && $jam <= 15) {
        $waktu = "Siang";
    } elseif ($jam >= 16 && $jam <= 18) {
        $waktu = "Sore";
    } else {
        $waktu = "Malam";
    }
    return "Selamat $waktu, $nama";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>latihan function</title>
</head>

<body>
    <h1><?= salam("Miftah") ?></h1>
</body>

</html>