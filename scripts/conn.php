<?php
    $data = "alaskamusic";
    $host = "127.0.0.1";
    $user = "root";
    $pass = "Zamdokie1833?!";
    $con = mysqli_connect($host, $user, $pass, $data);

    if (!$con) {
        header("location: nologin.html");
    }
?>