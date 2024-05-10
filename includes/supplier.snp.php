<?php
    if (isset($_POST['add-supplier'])) {
        require 'config.snp.php';

        $supplierName = $_POST['supplier_name'];
        $supplierPhone = $_POST['supplier_phone'];
        $supplierAddress = $_POST['supplier_address'];

        $supplierName = preg_replace('/["\']/', '', $supplierName);
        $supplierName = preg_replace('/\s+/', ' ', $supplierName);
        $supplierName = trim($supplierName);

        $supplierPhone = preg_replace('/["\']/', '', $supplierPhone);
        $supplierPhone = preg_replace('/\s+/', ' ', $supplierPhone);
        $supplierPhone = trim($supplierPhone);

        $supplierAddress = preg_replace('/["\']/', '', $supplierAddress);
        $supplierAddress = preg_replace('/\s+/', ' ', $supplierAddress);
        $supplierAddress = trim($supplierAddress);

        if (empty($supplierName) || empty($supplierPhone) || empty($supplierAddress)) {
            header("Location: ../admin/supplier.php?error=emptyfield");
            exit();
        }

        $sqlCheck = "SELECT COUNT(*) FROM suppliers WHERE supplier_name=?";
        $stmtCheck = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmtCheck, $sqlCheck)) {
            header("Location: ../admin/supplier.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmtCheck, "s", $supplierName);
            mysqli_stmt_execute($stmtCheck);
            mysqli_stmt_store_result($stmtCheck);
            mysqli_stmt_bind_result($stmtCheck, $count);
            mysqli_stmt_fetch($stmtCheck);

            if ($count > 0) {
                header("Location: ../admin/supplier.php?error=supplierexists");
                exit();
            } else {
                $sqlInsert = "INSERT INTO suppliers (supplier_name, supplier_phone, supplier_address, concatenated_data) VALUES (?, ?, ?, CONCAT(?, ', ', ?, ', ', ?))";
                $stmtInsert = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmtInsert, $sqlInsert)) {
                    header("Location: ../admin/supplier.php?error=sqlerror");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmtInsert, "ssssss", $supplierName, $supplierPhone, $supplierAddress, $supplierName, $supplierPhone, $supplierAddress);
                    mysqli_stmt_execute($stmtInsert);
                    header("Location: ../admin/supplier.php?insert=success");
                    exit();
                }
            }
        }

        mysqli_stmt_close($stmtInsert);
        mysqli_stmt_close($stmtCheck);
        mysqli_close($conn);
    } else {
        header("Location: ../admin/supplier.php");
        exit();
    }
?>
