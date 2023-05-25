<?php
require 'functions.php';
$name = 'Tambah Data Mahasiswa';

//Ketika Tombol submit diklik
if (isset($_POST['tambah'])) {
    //ambil data dari form lalu tambah ke tabel mahasiswa
    //cek apakah tambah data berhasil
    if (tambah($_POST) > 0) {
        echo "<script>
                alert('tambah data berhasil');
                document.location.href = 'index.php';
              </script>";
    }
}

require 'views/tambah.view.php';
