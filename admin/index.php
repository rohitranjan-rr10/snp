<?php
    session_start();

    if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
        header("Location: ../index.html");
        exit();
    }

    $servername = "127.0.0.1:3307";
    $username = "root";
    $password = "";
    $database = "snp";
    
    $conn = mysqli_connect($servername, $username, $password, $database);
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sqlFetchSuppliers = "SELECT concatenated_data FROM suppliers";
    $result = mysqli_query($conn, $sqlFetchSuppliers);

    if ($result) {
        $options = '';
        while ($row = mysqli_fetch_assoc($result)) {
            $concatenatedData = $row['concatenated_data'];
            $options .= "<option value='$concatenatedData'>$concatenatedData</option>";
        }
    } else {
        $options = "<option value=''>Error fetching data</option>";
    }

    $connDepart = mysqli_connect($servername, $username, $password, $database);
    
    if (!$connDepart) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sqlFetchDepartments = "SELECT department_name FROM departments";
    $resultDepart = mysqli_query($connDepart, $sqlFetchDepartments);

    if ($resultDepart) {
        $optionsDepart = '';
        while ($rowDepart = mysqli_fetch_assoc($resultDepart)) {
            $departmentData = $rowDepart['department_name'];
            $optionsDepart .= "<option value='$departmentData'>$departmentData</option>";
        }
    } else {
        $optionsDepart = "<option value=''>Error fetching data</option>";
    }

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
    } else {
        $optionsAssets = "<option value=''>Error fetching data</option>";
    }

    $connIndentor = mysqli_connect($servername, $username, $password, $database);
    
    if (!$connIndentor) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sqlFetchIndentor = "SELECT full_info FROM indentor";
    $resultIndentor = mysqli_query($connIndentor, $sqlFetchIndentor);

    if ($resultIndentor) {
        $optionsIndentor = '';
        while ($rowIndentor = mysqli_fetch_assoc($resultIndentor)) {
            $assetIndentor = $rowIndentor['full_info'];
            $optionsIndentor .= "<option value='$assetIndentor'>$assetIndentor</option>";
        }
    } else {
        $optionsIndentor = "<option value=''>Error fetching data</option>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/styles.css" />
    <title>SNP</title>
    <link rel="icon" href="../assets/favicon.ico" type="image/x-icon" />
</head>
<body id="body-pd">
    <div class="l-navbar" id="navbar">
        <nav class="nav">
            <div>
                <div class="nav__brand">
                    <ion-icon name="menu-outline" class="nav__toggle" id="nav-toggle"></ion-icon>
                </div>
                <div class="nav__list">
                    <a class="nav__link active">
                        <ion-icon name="add-circle" class="nav__icon"></ion-icon>
                        <span class="nav__name">Insert</span>
                    </a>
                    <a href="edit.php" class="nav__link">
                        <ion-icon name="create-outline" class="nav__icon"></ion-icon>
                        <span class="nav__name">Edit</span>
                    </a>
                    <a href="delete.php" class="nav__link">
                        <ion-icon name="trash-outline" class="nav__icon"></ion-icon>
                        <span class="nav__name">Delete</span>
                    </a>
                    <a href="search.php" class="nav__link">
                        <ion-icon name="search-outline" class="nav__icon"></ion-icon>
                        <span class="nav__name">Search</span>
                    </a>
                    <a href="export.php" class="nav__link">
                        <ion-icon name="download-outline" class="nav__icon"></ion-icon>
                        <span class="nav__name">Export</span>
                    </a>
                    <a href="supplier.php" class="nav__link">
                        <ion-icon name="cart-outline" class="nav__icon"></ion-icon>
                        <span class="nav__name">Supplier</span>
                    </a>
                </div>
            </div>
            <a href="../includes/logout.snp.php" class="nav__link">
                <ion-icon name="log-out-outline" class="nav__icon"></ion-icon>
                <span class="nav__name">Log Out</span>
            </a>
        </nav>
    </div>
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h2>Insert Records</h2>
                <p>Please fill out the form below to insert records into the database.</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="p-3 m-0 border-0 bd-example m-0 border-0">
                    <form class="row g-3" action="../includes/master.snp.php" method="POST" enctype="multipart/form-data">
                        <div class="col-md-5">
                            <label for="sl" class="form-label">Sl. No. <span class="required-field">*</span></label>
                            <input type="text" class="form-control" id="sl" name="sl" readonly placeholder="Auto Generated">
                        </div>
                        <div class="col-md-7">
                            <label for="indentor" class="form-label">Indentor <span class="required-field">*</span></label>
                            <select class="form-select" id="indentor" name="indentor">
                                <?php echo $optionsIndentor; ?>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label for="purchaseorder" class="form-label">Notesheet/Purchase Order No. <span class="required-field">*</span></label>
                            <input type="text" class="form-control" id="purchaseorder" name="purchaseorder" placeholder="Notesheet/Purchase Order No." required>
                        </div>
                        <div class="col-md-4">
                            <label for="purchasedate" class="form-label">Purchase Order Date <span class="required-field">*</span></label>
                            <input type="date" class="form-control" id="purchasedate" name="purchasedate" placeholder="Purchase Order Date" required>
                        </div>
                        <div class="col-12" id="dynamicRows">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="desc" class="form-label">Description <span class="required-field">*</span></label>
                                    <textarea class="form-control" rows="3" name="desc[]" placeholder="Description" required></textarea>
                                </div>
                                <div class="col-4">
                                    <label for="assets" class="form-label">Nature of Asset <span class="required-field">*</span></label>
                                    <select class="form-select" name="assets[]" required>
                                        <?php echo $optionsAssets; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="qty" class="form-label">Quantity <span class="required-field">*</span></label>
                                    <input type="number" class="form-control" name="qty[]" placeholder="Quantity" required>
                                </div>
                                <div class="col-md-5">
                                    <label for="grossamt" class="form-label">Gross amount incl. of taxes <span class="required-field">*</span></label>
                                    <input type="number" class="form-control" name="grossamt[]" placeholder="Gross amount" step="0.01" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 py-3">
                            <button id="add" type="button" class="btn btn-primary mt-2 mx-2" style="width: 50px">+</button>
                            <button id="delete" type="button" class="btn btn-danger mt-2 mx-2" style="width: 50px">-</button>
                        </div>
                        <div class="col-md-8">
                            <label for="billno" class="form-label">Bill No. <span class="required-field">*</span></label>
                            <input type="text" class="form-control" id="billno" name="billno" placeholder="Bill No." required>
                        </div>
                        <div class="col-md-4">
                            <label for="billdate" class="form-label">Bill Date <span class="required-field">*</span></label>
                            <input type="date" class="form-control" id="billdate" name="billdate" placeholder="Bill Date" required>
                        </div>
                        <div class="col-md-12">
                            <label for="supplierName" class="form-label">Name of Supplier <span class="required-field">*</span></label>
                            <select class="form-select" id="supplierName" name="supplierName">
                                <?php echo $options; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="receiptdate" class="form-label">Date of Receipt <span class="required-field">*</span></label>
                            <input type="date" class="form-control" name="receiptdate" id="receiptdate" placeholder="Date of Receipt" required>
                        </div>
                        <div class="col-md-4">
                            <label for="installationdate" class="form-label">Date of Installation <span class="required-field">*</span></label>
                            <input type="date" class="form-control" name="installationdate" id="installationdate" placeholder="Date of Installation" required>
                        </div>
                        <div class="col-md-4">
                            <label for="department" class="form-label">Department <span class="required-field">*</span></label>
                            <select class="form-select" id="department" name="department">
                                <?php echo $optionsDepart; ?>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label for="loc" class="form-label">Location <span class="required-field">*</span></label>
                            <input type="text" class="form-control" id="loc" name="loc" placeholder="Enter location" required>
                        </div>
                        <div class="col-md-7">
                            <label for="fileToUpload" class="form-label">Upload Invoice <span class="required-field">*</span></label>
                            <input class="form-control" type="file" id="fileToUpload" name="fileToUpload" required>
                        </div>
                        <div class="col-12 py-3 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary" style="width: 120px; height: 45px;">Insert</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script type="module" src="https://unpkg.com/ionicons@5.1.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@5.1.2/dist/ionicons/ionicons.js"></script>
    <script src="assets/main.js"></script>
    <script src="assets/addDelete.js"></script>
    <script>
        function validateSerial() {
            var serialInput = document.getElementById('serial');
            var serialValue = parseInt(serialInput.value);
            
            if (serialValue <= 0 || isNaN(serialValue)) {
                serialInput.value = 1;
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var qtyInputs = document.getElementsByName('qty[]');
            qtyInputs.forEach(function(qtyInput) {
                qtyInput.addEventListener('input', function() {
                    validateQuantity(qtyInput);
                });
            });

            var grossAmtInputs = document.getElementsByName('grossamt[]');
            grossAmtInputs.forEach(function(grossAmtInput) {
                grossAmtInput.addEventListener('input', function() {
                    validateGrossAmount(grossAmtInput);
                });
            });
        });

        function validateQuantity(input) {
            var value = parseFloat(input.value);
            if (isNaN(value) || value < 0) {
                input.value = '0';
            }
        }

        function validateGrossAmount(input) {
            var value = parseFloat(input.value);
            if (isNaN(value) || value < 0) {
                input.value = '0';
            }
        }
    </script>
  </body>
</html>
