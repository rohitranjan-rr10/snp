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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
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
                    <a href="search.php" class="nav__link">
                        <ion-icon name="search-outline" class="nav__icon"></ion-icon>
                        <span class="nav__name">Search</span>
                    </a>
                    <a href="export.php" class="nav__link">
                        <ion-icon name="download-outline" class="nav__icon"></ion-icon>
                        <span class="nav__name">Export</span>
                    </a>
                    <a class="nav__link active">
                        <ion-icon name="cart" class="nav__icon"></ion-icon>
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
                <h2>Add Supplier</h2>
                <p>Please fill out the form below to add supplier details.</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="p-3 m-0 border-0 bd-example m-0 border-0">
                    <form class="row g-3" action="../includes/supplier.snp.php" method="POST">
                        <div class="col-md-12">
                            <label for="inputEmail4" class="form-label">Name <span class="required-field">*</span></label>
                            <input type="text" class="form-control" id="inputEmail4" placeholder="Name" name="supplier_name" required>
                        </div>
                        <div class="col-md-12">
                            <label for="inputEmail4" class="form-label">Address <span class="required-field">*</span></label>
                            <textarea class="form-control" rows="5" id="floatingTextarea" placeholder="Address" name="supplier_address" required></textarea>
                        </div>
                        <div class="col-md-4">
                            <label for="inputEmail4" class="form-label">Phone No. <span class="required-field">*</span></label>
                            <br>
                            <input type="tel" class="form-control" id="phone" placeholder="9999999999" name="supplier_phone" required maxlength="10" pattern="[0-9]{10}">
                        </div>
                        <div class="col-12 py-3 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary" style="width: 120px; height: 45px;" name="add-supplier">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@5.1.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@5.1.2/dist/ionicons/ionicons.js"></script>
    <script src="assets/main.js"></script>
    <script>
        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            initialCountry: "in",
        });
    </script>
  </body>
</html>
