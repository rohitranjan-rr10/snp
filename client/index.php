<?php
    $servername = "127.0.0.1:3307";
    $username = "root";
    $password = "";
    $database = "snp";

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SNP</title>
    <link rel="icon" href="../assets/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
    <style>
        input:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        select:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            border: 2px solid #e5e5e5;
        }

        input:focus {
            outline: none;
        }
    </style>
</head>
<body>
    <section class="container forms">
        <div class="form login">
            <div class="form-content">
                <header>Sign In</header>
                <form action="includes/login.snp.php" method="POST">
                    <div class="field input-field">
                        <input type="email" placeholder="Email" class="input" name="email">
                    </div>
                    <div class="field input-field">
                        <select class="input" required name="depart">
                            <?php echo $optionsDepart; ?>
                        </select>
                    </div>
                    <div class="field input-field">
                        <input type="password" placeholder="Password" class="password" name="password">
                        <i class='bx bx-hide eye-icon'></i>
                    </div>
                    <div class="field button-field">
                        <button type="submit" name="login-submit">SIGN IN</button>
                    </div>
                </form>
                <div class="form-link">
                    <span>Don't have an account? <a href="#" class="link signup-link">Sign Up</a></span>
                </div>
            </div>
        </div>
        <div class="form signup">
            <div class="form-content">
                <header>Create Account</header>
                <form action="includes/signup.snp.php" method="POST">
                    <div class="field input-field">
                        <input type="text" placeholder="Name" class="input" required name="name">
                    </div>
                    <div class="field input-field">
                        <input type="email" placeholder="Email" class="input" required name="email">
                    </div>
                    <div class="field input-field">
                        <select class="input" required name="depart">
                            <?php echo $optionsDepart; ?>
                        </select>
                    </div>
                    <div class="field input-field">
                        <input type="password" placeholder="Password" class="password" required name="password">
                        <i class='bx bx-hide eye-icon'></i>
                    </div>
                    <div class="field button-field">
                        <button type="submit" name="signup-submit">SIGN UP</button>
                    </div>
                </form>
                <div class="form-link">
                    <span>Already have an account? <a href="#" class="link login-link">Sign In</a></span>
                </div>
            </div>
        </div>
    </section>
    <script src="script.js"></script>
</body>
</html>