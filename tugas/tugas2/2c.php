<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2c</title>
    <style type="text/css">
        td {
            height: 60px;
            width: 60px;
            border: 1px solid;
            background-color: aqua;
            text-align: center;
        }
    </style>
</head>

<body>
    <table cellspacing="0" cellpadding="15">
        <?php
        for ($i = 10; $i >= 1; $i--) {
            echo "<tr>";
            for ($j = 1; $j <= $i; $j++) {
                echo "<td> $j </td>";
            }
            echo "</tr>";
        }
        ?>
</body>

</html>