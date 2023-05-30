<?php
require 'functions.php';
$name = 'Ubah Data Mahasiswa';
$id = htmlspecialchars($_GET['id']);
$student = query("SELECT * FROM mahasiswa WHERE id = $id")[0];

//Ketika Tombol submit diklik
if (isset($_POST['ubah'])) {
    //ambil data dari form lalu tambah ke tabel mahasiswa
    //cek apakah tambah data berhasil
    if (ubah($_POST) > 0) {
        echo "<script>
                alert('ubah data berhasil');
                document.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>
                alert('ubah data gagal');
                document.location.href = 'index.php';
              </script>";
    }
}

require 'views/ubah.view.php';
