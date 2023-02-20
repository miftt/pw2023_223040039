<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>1c</title>
    <style type = "text/css" >
        .container{
            display: flex;
        }
        .kotak {
            width: 70px;
            height: 70px;
            background-color: blue;
            position: relative;
            border: 1px solid #000;
        }
        .numb{
            position: absolute;
            font-family: sans-serif;
            font-size: 40px;
            left: 30%;
            top: 20%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="kotak">
            <div class="numb">1</div>
        </div>
    </div>
    <div class="container">
        <div class="kotak">
            <div class="numb">2</div>
        </div>
        <div class="kotak">
            <div class="numb">2</div>
        </div>
    </div>
    <div class="container">
        <div class="kotak">
            <div class="numb">3</div>
        </div>
        <div class="kotak">
            <div class="numb">3</div>
        </div>
        <div class="kotak">
            <div class="numb">3</div>
        </div>
    </div>
</body>
</html>