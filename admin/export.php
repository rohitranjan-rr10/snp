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
                    <a href="search.php" class="nav__link">
                        <ion-icon name="search-outline" class="nav__icon"></ion-icon>
                        <span class="nav__name">Search</span>
                    </a>
                    <a class="nav__link active">
                        <ion-icon name="download" class="nav__icon"></ion-icon>
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
                <h2>Export Data</h2>
                <p>This will export all the records available in the database in CSV format.</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="p-3 m-0 border-0 bd-example m-0 border-0">
                    <form class="row g-3" action="../includes/export.snp.php" method="POST">
                        <div class="col-12 py-3">
                            <button type="submit" class="btn btn-primary" style="width: 120px; height: 45px;">Export CSV</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@5.1.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@5.1.2/dist/ionicons/ionicons.js"></script>
    <script src="assets/main.js"></script>
  </body>
</html>
