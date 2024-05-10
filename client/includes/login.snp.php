<?php
    session_start(); 

    if (isset($_POST['login-submit'])) {
        require 'config.snp.php';

        $email = $_POST['email'];
        $depart = $_POST['depart'];
        $password = $_POST['password'];

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $depart = mysqli_real_escape_string($conn, $depart);

        $sql = "SELECT * FROM client WHERE email = ? AND depart = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../index.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $email, $depart);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                $pwdCheck = password_verify($password, $row['password']);

                if($pwdCheck == true) {
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['depart'] = $row['depart'];
                    $_SESSION['authenticated'] = true;
                    
                    header("Location: ../depart/index.php?login=success");
                    exit();
                } else {
                    header("Location: ../index.php?error=wrongpassword");
                    exit();
                } 
            } else {
                header("Location: ../index.php?error=nouserfound");
                exit();
            }
        }
    } else {
        header("Location: ../index.php");
        exit();
    }
?>
