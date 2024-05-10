<?php
    session_start();
    
    $serverName = "127.0.0.1:3307";
    $dBUserName = "root";
    $dBPassword = "";
    $dBName = "snp";

    $conn=mysqli_connect($serverName, $dBUserName, $dBPassword, $dBName);

    if (!$conn) {
        die("Connection Failed: ".mysqli_connect_error());
    }
?>
