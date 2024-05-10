<?php
    if(isset($_POST['signup-submit'])) {
        require 'config.snp.php';

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (empty($name) || !preg_match("/^[a-zA-Z ]*$/", $name)) {
            header("Location: ../index.html?error=invalidname");
            exit();
        } else {
            $sql = "SELECT email FROM users WHERE email=?";
            $stmt = mysqli_stmt_init($conn);
            
            if(!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../index.html?error=sqlerror");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                $resultCheck = mysqli_stmt_num_rows($stmt);

                if($resultCheck > 0) {
                    header("Location: ../index.html?error=userexists");
                    exit();
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);

                    echo "<script>";
                    echo "console.log('Name: $name');";
                    echo "console.log('Email: $email');";
                    echo "console.log('Hashed Password: $hashed_password');";
                    echo "</script>";

                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../index.html?error=sqlerror");
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed_password);
                        mysqli_stmt_execute($stmt);
                        
                        $_SESSION['authenticated'] = true;

                        header("Location: ../admin/index.php?signup=success");
                        exit();
                    }
                }
            }
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        header("Location: ../index.php");
        exit();
    }
?>
