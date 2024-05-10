<?php
    session_start(); 

    if (isset($_POST['login-submit'])) {
        require 'config.snp.php';

        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if ($row = mysqli_fetch_assoc($result)) {
            $pwdCheck = password_verify($password, $row['password']);

            if($pwdCheck == true) {
                $_SESSION['email'] = $row['email'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['authenticated'] = true;
                
                header("Location: ../admin/index.php?login=success");
                exit();
            } else {
                header("Location: ../index.html?error=wrongpassword");
                exit();
            } 
        } else {
            header("Location: ../index.html?error=nouserfound");
            exit();
        }
    } else {
        header("Location: ../index.html?error=sqlerror");
        exit();
    }
?>
