<?php
require('functions.php');
$name = 'Home';


$students = query("SELECT * FROM mahasiswa");

// cari mahasiswa, ketika tombol search di klik
if (isset($_GET['search'])) {
    $keyword = $_GET['keyword'];
    $query = "SELECT * FROM
                mahasiswa
              WHERE
                  nama LIKE '%$keyword%' OR
                  jurusan LIKE '%$keyword%' OR
                  email LIKE '%$keyword%'";
    $students = query($query);
}
require('views/index.view.php');
