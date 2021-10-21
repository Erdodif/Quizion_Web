<?php
    $response = file_get_contents("http://10.147.20.1/adatok/index.php?method=read&table=quiz");
?><!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <?php
            $kiir = json_decode($response);

            echo $kiir->data[1]->header;
            echo "<br />";
            echo $kiir->data[2]->id;
        ?>
    </body>
</html>
