<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2d</title>
    <style type="text/css">
        table {
            border: 1px solid;
        }

        .warna-hitam {
            background-color: black;
        }

        .warna-putih {
            background-color: white;
        }
    </style>
</head>

<body>
    <table cellpadding="25" cellspacing="0">
        <?php
        for ($i = 1; $i <= 5; $i++) {
            echo "<tr>";
            for ($j = 1; $j <= 5; $j++) {
                if (($i + $j) % 2 == 0) {
                    echo "<td class='warna-hitam'> </td>";
                } else {
                    echo "<td class='warna-putih'> </td>";
                }
            }
            echo "</tr>";
        }
        ?>
    </table>
</body>

</html>