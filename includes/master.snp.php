<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include_once "config.snp.php";

        $indentor = mysqli_real_escape_string($conn, $_POST['indentor']);
        $purchase_order_no = mysqli_real_escape_string($conn, $_POST['purchaseorder']);
        $purchase_order_date = mysqli_real_escape_string($conn, $_POST['purchasedate']);

        $description = $_POST['desc'];
        $description = preg_replace('/[^.a-zA-Z0-9-: ]/', '', $description);
        $nature_of_asset = $_POST['assets'];
        $quantity = $_POST['qty'];
        $gross_amount = $_POST['grossamt'];

        $bill_no = mysqli_real_escape_string($conn, $_POST['billno']);
        $bill_date = mysqli_real_escape_string($conn, $_POST['billdate']);
        $supplier = mysqli_real_escape_string($conn, $_POST['supplierName']);

        $date_of_receipt = mysqli_real_escape_string($conn, $_POST['receiptdate']);
        $date_of_installation = mysqli_real_escape_string($conn, $_POST['installationdate']);
        $department = mysqli_real_escape_string($conn, $_POST['department']);
        $location = mysqli_real_escape_string($conn, $_POST['loc']);
        $serialNumber = mysqli_real_escape_string($conn, $_POST['serialNumber']);

        if (!empty($_FILES["fileToUpload"]["name"])) {
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
            $domain = $_SERVER['HTTP_HOST'];
            $upload_directory = '/snp/uploads/';

            $absolute_url = $protocol . $domain . $upload_directory;

            $original_file_name = basename($_FILES["fileToUpload"]["name"]);
            $sanitized_file_name = preg_replace('/[^.a-zA-Z0-9-]/', '', $original_file_name);

            date_default_timezone_set('Asia/Kolkata');
            $current_date = date("d-m-Y");
            $current_time = date("H-i-s");

            $file_name_without_ext = pathinfo($sanitized_file_name, PATHINFO_FILENAME);
            $file_ext = pathinfo($sanitized_file_name, PATHINFO_EXTENSION);
            $new_file_name = $file_name_without_ext . "_" . $current_date . "-" . $current_time . "_." . $file_ext;

            $target_file = $_SERVER['DOCUMENT_ROOT'] . $upload_directory . $new_file_name;

            $uploadOk = 1;

            $file_url = $absolute_url . basename($target_file);

            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $sql = "INSERT INTO master_data (indentor, notesheet_purchase_order_no, purchase_order_date, description, nature_of_asset, quantity, gross_amount, bill_no, bill_date, supplier, date_of_receipt, date_of_installation, department, location, invoice)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssssssssssssss", $indentor, $purchase_order_no, $purchase_order_date, $descriptionJSON, $nature_of_assetJSON, $quantityJSON, $gross_amountJSON, $bill_no, $bill_date, $supplier, $date_of_receipt, $date_of_installation, $department, $location, $file_url);

                $descriptionJSON = json_encode($description);
                $nature_of_assetJSON = json_encode($nature_of_asset);
                $quantityJSON = json_encode($quantity);
                $gross_amountJSON = json_encode($gross_amount);

                if ($stmt->execute()) {
                    header("Location: ../admin/index.php?upload=success");
                    exit();
                } else {
                    header("Location: ../admin/index.php?error=uploaderror");
                    exit();
                }

                $stmt->close();
            } else {
                header("Location: ../admin/index.php?error=uploaderror");
                exit();
            }
        } else {
            header("Location: ../admin/index.php?error=uploaderror");
            exit();
        }

        mysqli_close($conn);
    } else {
        echo 'Invalid request.';
    }
?>
