<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include_once "config.snp.php";

        $indentor = mysqli_real_escape_string($conn, $_POST['indentor']);
        $purchase_order_no = mysqli_real_escape_string($conn, $_POST['purchaseorder']);
        $purchase_order_date = mysqli_real_escape_string($conn, $_POST['purchasedate']);

        $description = $_POST['desc'];
        $description = array_map('mysqli_real_escape_string', array_fill(0, count($description), $conn), $description);
        $nature_of_asset = $_POST['assets'];
        $nature_of_asset = array_map('mysqli_real_escape_string', array_fill(0, count($nature_of_asset), $conn), $nature_of_asset);
        $quantity = $_POST['qty'];
        $quantity = array_map('intval', $quantity);
        $gross_amount = $_POST['grossamt'];
        $gross_amount = array_map('floatval', $gross_amount);

        $itemok = $_POST['itemok'];
        $itemok = array_map('intval', $itemok);
        $shortage = $_POST['shortage'];
        $shortage = array_map('intval', $shortage);
        $excess = $_POST['excess'];
        $excess = array_map('intval', $excess);
        $currloc = $_POST['currloc'];
        $currloc = array_map('mysqli_real_escape_string', array_fill(0, count($currloc), $conn), $currloc);
        $reported_curr_loc = json_encode($currloc);

        $bill_no = mysqli_real_escape_string($conn, $_POST['billno']);
        $bill_date = mysqli_real_escape_string($conn, $_POST['billdate']);
        $supplier = mysqli_real_escape_string($conn, $_POST['supplierName']);

        $date_of_receipt = mysqli_real_escape_string($conn, $_POST['receiptdate']);
        $date_of_installation = mysqli_real_escape_string($conn, $_POST['installationdate']);
        $department = mysqli_real_escape_string($conn, $_POST['department']);
        $location = mysqli_real_escape_string($conn, $_POST['loc']);
        $serialNumber = mysqli_real_escape_string($conn, $_POST['serialNumber']);

        $sql = "UPDATE master_data SET indentor=?, notesheet_purchase_order_no=?, purchase_order_date=?, description=?, nature_of_asset=?, quantity=?, gross_amount=?, bill_no=?, bill_date=?, supplier=?, date_of_receipt=?, date_of_installation=?, department=?, location=?, no_of_item_found_ok=?, shortage=?, excess=?, reported_curr_loc=? WHERE serial_number=?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssssssssssss", $indentor, $purchase_order_no, $purchase_order_date, $descriptionJSON, $nature_of_assetJSON, $quantityJSON, $gross_amountJSON, $bill_no, $bill_date, $supplier, $date_of_receipt, $date_of_installation, $department, $location, $itemokJSON, $shortageJSON, $excessJSON, $reported_curr_loc, $serialNumber);

        $descriptionJSON = json_encode($description);
        $nature_of_assetJSON = json_encode($nature_of_asset);
        $quantityJSON = json_encode($quantity);
        $gross_amountJSON = json_encode($gross_amount);
        $itemokJSON = json_encode($itemok);
        $shortageJSON = json_encode($shortage);
        $excessJSON = json_encode($excess);

        if ($stmt->execute()) {
            echo 'Record updated successfully.';
        } else {
            echo 'Error updating record: ' . $conn->error;
        }

        $stmt->close();
        mysqli_close($conn);
    } else {
        echo 'Invalid request.';
    }
?>
