<?php
    if(isset($_POST['signup-submit'])) {
        require 'config.snp.php';

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $depart = $_POST['depart'];

        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (empty($name) || !preg_match("/^[a-zA-Z ]*$/", $name)) {
            header("Location: ../index.php?error=invalidname");
            exit();
        }

        $sql = "SELECT email FROM client WHERE email = ? AND depart = ?";
        $stmt = mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../index.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $email, $depart);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            $resultCheck = mysqli_stmt_num_rows($stmt);

            if($resultCheck > 0) {
                header("Location: ../index.php?error=userexists");
                exit();
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO client (name, email, depart, password) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../index.php?error=sqlerror");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $depart, $hashed_password);
                    mysqli_stmt_execute($stmt);
                    $_SESSION['email'] = $email;
                    $_SESSION['name'] = $name;
                    $_SESSION['depart'] = $depart;
                    $_SESSION['authenticated'] = true;
                    
                    header("Location: ../depart/index.php?signup=success");
                    exit();
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
