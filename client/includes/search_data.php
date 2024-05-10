<?php
    include_once 'config.snp.php';

    $serialNumber = isset($_GET['serial_number']) ? $_GET['serial_number'] : '';

    if (empty($serialNumber)) {
        echo json_encode(array("error" => "Serial number parameter is missing."));
        exit;
    }

    $sqlCheckDepartment = "SELECT department FROM master_data WHERE serial_number = ?";
    $stmtCheckDept = $conn->prepare($sqlCheckDepartment);
    $stmtCheckDept->bind_param("i", $serialNumber);
    $stmtCheckDept->execute();
    $resultCheckDept = $stmtCheckDept->get_result();

    if ($resultCheckDept && $resultCheckDept->num_rows > 0) {
        $rowDept = $resultCheckDept->fetch_assoc();
        $department = $rowDept['department'];

        if ($_SESSION['depart'] !== $department) {
            echo json_encode(array("error" => "You are not authorized to search records from other departments."));
            exit;
        }

        $sql = "SELECT * FROM master_data WHERE serial_number = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $serialNumber);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && mysqli_num_rows($result) > 0) {
            $outputData = array();

            while ($row = mysqli_fetch_assoc($result)) {
                foreach ($row as $key => $value) {
                    if (is_json($value)) {
                        $json_data = json_decode($value, true);
                        $row[$key] = $json_data;
                    }
                }

                $outputData[] = $row;
            }

            header('Content-Type: application/json');
            echo json_encode($outputData);
        } else {
            echo json_encode(array("error" => "No records found for the given serial number."));
        }

        $stmt->close();
    } else {
        echo json_encode(array("error" => "Invalid serial number."));
    }

    $stmtCheckDept->close();
    mysqli_close($conn);

    function is_json($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
?>
