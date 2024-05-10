<?php

    include_once 'config.snp.php';

    $serialNumber = isset($_GET['serial_number']) ? $_GET['serial_number'] : '';
    
    if (!empty($serialNumber)) {
        $sql = "SELECT * FROM master_data WHERE serial_number = '$serialNumber'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $outputData = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $json_columns = ['description', 'nature_of_asset', 'quantity', 'gross_amount', 'no_of_item_found_ok', 'shortage', 'excess', 'reported_curr_loc'];
                $max_count = 1;

                foreach ($json_columns as $column) {
                    if (array_key_exists($column, $row) && is_json($row[$column])) {
                        $json_data = json_decode($row[$column]);
                        $max_count = max($max_count, count($json_data));
                    }
                }

                for ($i = 0; $i < $max_count; $i++) {
                    $new_row = $row;

                    foreach ($json_columns as $column) {
                        if (array_key_exists($column, $row) && is_json($row[$column])) {
                            $json_data = json_decode($row[$column]);
                            $new_row[$column] = isset($json_data[$i]) ? $json_data[$i] : '';
                        }
                    }

                    $outputData[] = $new_row;
                }
            }

            header('Content-Type: application/json');
            echo json_encode($outputData);
        } else {
            echo json_encode(array("error" => "No records found for the given serial number."));
        }
    } else {
        echo json_encode(array("error" => "Serial number parameter is missing."));
    }

    mysqli_close($conn);

    function is_json($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
?>
