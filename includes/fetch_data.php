<?php
    include_once 'config.snp.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sl'])) {
        $serialNumber = mysqli_real_escape_string($conn, $_POST['sl']);

        $sql = "SELECT * FROM master_data WHERE serial_number = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $serialNumber);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $descriptionArray = json_decode($row['description'], true);
                $assetsArray = json_decode($row['nature_of_asset'], true);
                $qtyArray = json_decode($row['quantity'], true);
                $grossamtArray = json_decode($row['gross_amount'], true);

                $sqlFetchDepartments = "SELECT department_name FROM departments";
                $resultDepart = mysqli_query($conn, $sqlFetchDepartments);
                

                if ($resultDepart) {
                    $optionsDepart = '';
                    while ($rowDepart = mysqli_fetch_assoc($resultDepart)) {
                        $departmentData = $rowDepart['department_name'];
                        $selected = ($departmentData == $row['department']) ? 'selected' : '';
                        $optionsDepart .= "<option value='$departmentData' $selected>$departmentData</option>";
                    }
                } else {
                    $optionsDepart = "<option value=''>Error fetching departments</option>";
                }

                $sqlFetchIndentor = "SELECT full_info FROM  indentor WHERE full_info <> ?";
                $stmtIndentor = $conn->prepare($sqlFetchIndentor);
                $stmtIndentor->bind_param("s", $row['indentor']);
                $stmtIndentor->execute();
                $resultIndentor = $stmtIndentor->get_result();

                if ($resultIndentor) {
                    $optionsIndentor = '';
                    while ($rowIndentor = mysqli_fetch_assoc($resultIndentor)) {
                        $indentorData = $rowIndentor['full_info'];
                        $optionsIndentor .= "<option value='$indentorData'>$indentorData</option>";
                    }
                } else {
                    $optionsIndentor = "<option value=''>Error fetching indentors</option>";
                }

                $sqlFetchSuppliers = "SELECT concatenated_data FROM suppliers WHERE concatenated_data <> ?";
                $stmtSuppliers = $conn->prepare($sqlFetchSuppliers);
                $stmtSuppliers->bind_param("s", $row['supplier']);
                $stmtSuppliers->execute();
                $resultSuppliers = $stmtSuppliers->get_result();

                if ($resultSuppliers) {
                    $optionsSuppliers = '';
                    while ($rowSuppliers = mysqli_fetch_assoc($resultSuppliers)) {
                        $supplierData = $rowSuppliers['concatenated_data'];
                        $optionsSuppliers .= "<option value='$supplierData'>$supplierData</option>";
                    }
                } else {
                    $optionsSuppliers = "<option value=''>Error fetching suppliers</option>";
                }

                echo '<div class="row g-3">';
                echo '<div class="col-md-12">';
                echo '<label for="indentor" class="form-label">Indentor</label>';
                echo '<select class="form-select" id="indentor" name="indentor">';
                echo '<option value="' . $row['indentor'] . '" selected>' . $row['indentor'] . '</option>';
                echo $optionsIndentor;
                echo '</select>';
                echo '</div>';
                echo '<div class="col-md-8">';
                echo '<label for="purchaseorder" class="form-label">Notesheet/Purchase Order No.</label>';
                echo '<input type="text" class="form-control" id="purchaseorder" name="purchaseorder" value="' . $row['notesheet_purchase_order_no'] . '">';
                echo '</div>';
                echo '<div class="col-md-4">';
                echo '<label for="purchasedate" class="form-label">Purchase Order Date</label>';
                echo '<input type="date" class="form-control" id="purchasedate" name="purchasedate" value="' . $row['purchase_order_date'] . '">';
                echo '</div>';

                for ($i = 0; $i < count($descriptionArray); $i++) {
                    echo '<div class="col-md-12">';
                    echo '<label for="desc" class="form-label">Description</label>';
                    echo '<textarea class="form-control" rows="3" name="desc[]">' . $descriptionArray[$i] . '</textarea>';
                    echo '</div>';
                    echo '<div class="col-4">';
                    echo '<label for="assets" class="form-label">Nature of Asset</label>';
                    echo '<select class="form-select" name="assets[]">';
                    echo '<option value="' . $assetsArray[$i] . '">' . $assetsArray[$i] . '</option>';

                    $sqlFetchAssets = "SELECT asset_name FROM assets";
                    $resultAssets = mysqli_query($conn, $sqlFetchAssets);

                    if ($resultAssets) {
                        while ($rowAssets = mysqli_fetch_assoc($resultAssets)) {
                            $assetData = $rowAssets['asset_name'];
                            if ($assetData !== $assetsArray[$i]) {
                                echo '<option value="' . $assetData . '">' . $assetData . '</option>';
                            }
                        }
                    } else {
                        echo '<option value="">Error fetching assets</option>';
                    }

                    echo '</select>';
                    echo '</div>';

                    echo '<div class="col-md-3">';
                    echo '<label for="qty" class="form-label">Quantity</label>';
                    echo '<input type="number" class="form-control" name="qty[]" value="' . $qtyArray[$i] . '">';
                    echo '</div>';
                    echo '<div class="col-md-5">';
                    echo '<label for="grossamt" class="form-label">Gross amount incl. of taxes</label>';
                    echo '<input type="number" class="form-control" name="grossamt[]" value="' . $grossamtArray[$i] . '" step="0.01">';
                    echo '</div>';
                }

                echo '<div class="col-md-9">';
                echo '<label for="billno" class="form-label">Bill No.</label>';
                echo '<input type="text" class="form-control" id="billno" name="billno" value="' . $row['bill_no'] . '">';
                echo '</div>';
                echo '<div class="col-md-3">';
                echo '<label for="billdate" class="form-label">Bill Date</label>';
                echo '<input type="date" class="form-control" id="billdate" name="billdate" value="' . $row['bill_date'] . '">';
                echo '</div>';
                echo '<div class="col-md-12">';
                echo '<label for="supplierName" class="form-label">Name of Supplier</label>';
                echo '<select class="form-select" id="supplierName" name="supplierName">';
                echo '<option value="' . $row['supplier'] . '" selected>' . $row['supplier'] . '</option>';
                echo $optionsSuppliers;
                echo '</select>';
                echo '</div>';
                echo '<div class="col-md-4">';
                echo '<label for="receiptdate" class="form-label">Date of Receipt</label>';
                echo '<input type="date" class="form-control" name="receiptdate" id="receiptdate" value="' . $row['date_of_receipt'] . '">';
                echo '</div>';
                echo '<div class="col-md-4">';
                echo '<label for="installationdate" class="form-label">Date of Installation</label>';
                echo '<input type="date" class="form-control" name="installationdate" id="installationdate" value="' . $row['date_of_installation'] . '">';
                echo '</div>';
                echo '<div class="col-md-4">';
                echo '<label for="department" class="form-label">Department</label>';
                echo '<select class="form-select" id="department" name="department">';
                echo '<option value="' . $row['department'] . '" selected>' . $row['department'] . '</option>';
                echo $optionsDepart;
                echo '</select>';
                echo '</div>';
                echo '<div class="col-md-12">';
                echo '<label for="loc" class="form-label">Location</label>';
                echo '<input type="text" class="form-control" id="loc" name="loc" value="' . $row['location'] . '">';
                echo '</div>';
                echo '<div class="col-md-12">';
                echo '<label for="fileToUpload" class="form-label">Upload Invoice</label>';
                echo '<input type="file" class="form-control mb-2" id="fileToUpload" name="fileToUpload">';
                if (!empty($row['invoice'])) {
                    echo '<span class="text-muted">Current File: <a href="' . $row['invoice'] . '" target="_blank">' . basename($row['invoice']) . '</a></span>';
                } else {
                    echo '<span class="text-muted">No file uploaded</span>';
                }
                echo '</div>';
                echo '<div class="col-12 py-3 d-flex justify-content-end">';
                echo '<button type="submit" class="btn btn-primary mb-3" style="width: 150px; height: 45px;">Save Changes</button>';
                echo '</div>';
                echo '</div>';
            } else {
                echo 'No data found for the provided serial number.';
            }
        } else {
            echo 'Error fetching data.';
        }

        $stmt->close();
        mysqli_close($conn);
    } else {
        echo 'Invalid request.';
    }
?>
