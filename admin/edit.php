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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                    <a class="nav__link active">
                        <ion-icon name="create" class="nav__icon"></ion-icon>
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
                <h2>Edit Records</h2>
                <p>You can edit the selected records here. Make sure to review your changes before saving.</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form class="row g-3" id="fetchForm">
                    <div class="col-md-12 mt-5">
                        <label for="serialNumber" class="form-label">Sl. No. <span class="required-field">*</span></label>
                        <input type="text" class="form-control" id="serialNumber" name="serialNumber" placeholder="Enter Sl. No.">
                    </div>
                    <div class="col-12 py-3">
                        <button type="submit" class="btn btn-primary">Fetch Data</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-4" id="fetchedDataContainer" style="display: none;">
            <div class="col">
                <form id="editForm" class="row g-3" enctype="multipart/form-data">
                    <div id="fetchedData"></div>
                </form>
            </div>
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@5.1.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@5.1.2/dist/ionicons/ionicons.js"></script>
    <script src="assets/main.js"></script>
    <script>
        $(document).ready(function () {
            $('#fetchForm').submit(function (e) {
                e.preventDefault();
                var serialNumber = $('#serialNumber').val();
                $.ajax({
                    type: 'POST',
                    url: '../includes/fetch_data.php',
                    data: { sl: serialNumber },
                    success: function (response) {
                        $('#fetchedDataContainer').show();
                        $('#fetchedData').html(response);
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });
            });
            
            $('#fetchedDataContainer').on('submit', '#editForm', function (e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                var serialNumber = $('#serialNumber').val();
                formData.append('serialNumber', serialNumber);
                $.ajax({
                    type: 'POST',
                    url: '../includes/edit.snp.php',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                    alert('Record updated successfully.');
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                        alert('Error updating record.');
                    }
                });
            });
        });
    </script>
  </body>
</html>
