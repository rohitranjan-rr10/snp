<?php
    include_once 'config.snp.php';

    $jsonIndex = isset($_GET['json_index']) ? intval($_GET['json_index']) : null;
    $serialNumber = isset($_GET['serial_number']) ? intval($_GET['serial_number']) : null;

    if ($jsonIndex !== null && $serialNumber !== null) {
        $sql = "SELECT * FROM master_data WHERE serial_number = $serialNumber";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $json_columns = ['description', 'nature_of_asset', 'quantity', 'gross_amount'];
            $updatedJsonData = array();
            
            foreach ($json_columns as $column) {
                if (array_key_exists($column, $row) && is_json($row[$column])) {
                    $json_data = json_decode($row[$column]);

                    if (is_array($json_data)) {
                        if (count($json_data) === 1) {
                            $sqlDelete = "DELETE FROM master_data WHERE serial_number = $serialNumber";
                            mysqli_query($conn, $sqlDelete);

                            $success = true;
                            $response = array("success" => $success);

                            mysqli_close($conn);
                            header('Content-Type: application/json');
                            echo json_encode($response);
                            exit();
                        } else {
                            foreach ($json_data as $index => $value) {
                                if ($index != $jsonIndex) {
                                    $updatedJsonData[$column][] = $value;
                                }
                            }
                        }
                    }
                }
            }

            foreach ($updatedJsonData as $column => $data) {
                $updatedJsonString = json_encode($data);
                $sqlUpdate = "UPDATE master_data SET $column = '$updatedJsonString' WHERE serial_number = $serialNumber";
                mysqli_query($conn, $sqlUpdate);
            }

            $success = true;
            $response = array("success" => $success);
        } else {
            $response = array("error" => "No record found for the given serial number.");
        }
    } else {
        $response = array("error" => "Invalid JSON index or serial number parameter.");
    }

    mysqli_close($conn);

    header('Content-Type: application/json');
    echo json_encode($response);

    function is_json($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
?>
