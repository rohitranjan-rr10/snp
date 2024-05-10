<?php
    $servername = "127.0.0.1:3307";
    $username = "root";
    $password = "";
    $database = "snp";

    $connAssets = mysqli_connect($servername, $username, $password, $database);

    if (!$connAssets) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sqlFetchAssets = "SELECT asset_name FROM assets";
    $resultAssets = mysqli_query($connAssets, $sqlFetchAssets);

    if ($resultAssets) {
        $optionsAssets = '';
        while ($rowAssets = mysqli_fetch_assoc($resultAssets)) {
            $assetData = $rowAssets['asset_name'];
            $optionsAssets .= "<option value='$assetData'>$assetData</option>";
        }
        echo $optionsAssets;
    } else {
        echo "<option value=''>Error fetching data</option>";
    }

    mysqli_close($connAssets);
?>
