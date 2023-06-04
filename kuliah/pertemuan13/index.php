<?php
require('functions.php');
$name = 'Home';


$students = query("SELECT * FROM mahasiswa");

require('views/index.view.php');
