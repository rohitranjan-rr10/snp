<?php
    session_start();

    if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
        header("Location: ../index.html");
        exit();
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
    <style>
        th, td {
            text-align: center;
        }
    </style>
</head>
<body id="body-pd">
    <div class="l-navbar" id="navbar">
        <nav class="nav">
            <div>
                <div class="nav__brand">
                    <ion-icon name="menu-outline" class="nav__toggle" id="nav-toggle"></ion-icon>
                </div>
                <div class="nav__list">
                    <a href="index.php" class="nav__link">
                        <ion-icon name="add-circle-outline" class="nav__icon"></ion-icon>
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
                    <a class="nav__link active">
                        <ion-icon name="search" class="nav__icon"></ion-icon>
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
                <h2>Search Records</h2>
                <p>Use the search functionality below to find specific records in the database.</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="p-3 m-0 border-0 bd-example m-0 border-0">
                    <div class="input-group" style="height: 45px; width: 60%;">
                        <span class="input-group-text"><ion-icon name="search-outline"></ion-icon></span>
                        <input type="text" class="form-control" name="searchInput" id="searchInput" placeholder="Search by Sl. No." required oninput="search()">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="p-3 mt-4 border-0 bd-example table-responsive" id="dataContainer"></div>
            </div>
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@5.1.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@5.1.2/dist/ionicons/ionicons.js"></script>
    <script src="assets/main.js"></script>
    <script>
        function search() {
            let serialNumber = document.getElementById('searchInput').value.trim();
            if (serialNumber !== '') {
                fetch('../includes/search_data.php?serial_number=' + serialNumber)
                    .then(response => response.json())
                    .then(data => {
                        if (Array.isArray(data) && data.length > 0) { 
                            let tableHtml = '<table class="table table-bordered align-middle"><thead><tr><th scope="col">Sl. No.</th><th scope="col">Indentor</th><th scope="col">Notesheet/Purchase Order No.</th><th scope="col">Purchase Order Date</th><th scope="col">Description</th><th scope="col">Nature of Asset</th><th scope="col">Quantity</th><th scope="col">Gross Amount incl. of taxes</th><th scope="col">Bill No.</th><th scope="col">Bill Date</th><th scope="col">Name of Supplier</th><th scope="col">Date of Receipt</th><th scope="col">Date of Installation</th><th scope="col">Department</th><th scope="col">Location</th><th scope="col">Invoice</th><th scope="col">No. of items found OK</th><th scope="col">Shortage</th><th scope="col">Excess</th><th scope="col">Reported/Current Location</th></tr></thead>';

                            data.forEach(row => {
                                tableHtml += '<tr>';
                                tableHtml += '<td>' + row.serial_number + '</td>';
                                tableHtml += '<td>' + row.indentor + '</td>';
                                tableHtml += '<td>' + row.notesheet_purchase_order_no + '</td>';
                                tableHtml += '<td>' + row.purchase_order_date + '</td>';
                                tableHtml += '<td>' + (row.description || '') + '</td>';
                                tableHtml += '<td>' + (row.nature_of_asset || '') + '</td>';
                                tableHtml += '<td>' + (row.quantity || '') + '</td>';
                                tableHtml += '<td>' + (row.gross_amount || '') + '</td>';
                                tableHtml += '<td>' + row.bill_no + '</td>';
                                tableHtml += '<td>' + row.bill_date + '</td>';
                                tableHtml += '<td>' + row.supplier + '</td>';
                                tableHtml += '<td>' + row.date_of_receipt + '</td>';
                                tableHtml += '<td>' + row.date_of_installation + '</td>';
                                tableHtml += '<td>' + row.department + '</td>';
                                tableHtml += '<td>' + row.location + '</td>';
                                tableHtml += '<td><button class="btn btn-primary" onclick="viewInvoice(\'' + row.invoice + '\')">View</button></td>';
                                tableHtml += '<td>' + (row.no_of_item_found_ok || '') + '</td>';
                                tableHtml += '<td>' + (row.shortage || '') + '</td>';
                                tableHtml += '<td>' + (row.excess || '') + '</td>';
                                tableHtml += '<td>' + (row.reported_curr_loc || '') + '</td>';
                                tableHtml += '</tr>';
                            });

                            tableHtml += '</table>';
                            document.getElementById('dataContainer').innerHTML = tableHtml;
                        } else {
                            document.getElementById('dataContainer').innerHTML = '<p>No matching rows found.</p>';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                document.getElementById('dataContainer').innerHTML = '<p>Search input is empty.</p>';
            }
        }

        function viewInvoice(invoiceUrl) {
            window.open(invoiceUrl, '_blank');
        }
    </script>
  </body>
</html>
