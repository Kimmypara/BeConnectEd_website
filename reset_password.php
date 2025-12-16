<?php
session_start();
require_once "includes/dbh.php";

$error = "";
$success = "";

// Handle form submission
if (isset($_POST['submit'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // 1️⃣ Basic validation
    if (empty($email) || empty($password) || empty($confirmPassword)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {

        // 2️⃣ Check if user exists & is active
        $sql = "SELECT user_id FROM users WHERE email = ? AND is_active = 1";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            $error = "Something went wrong. Please try again.";
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($user = mysqli_fetch_assoc($result)) {

                // 3️⃣ Hash password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // 4️⃣ Update password
                $updateSql = "
                    UPDATE users 
                    SET password_hash = ?, must_change_password = 0 
                    WHERE user_id = ?
                ";
                $stmt2 = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt2, $updateSql);
                mysqli_stmt_bind_param($stmt2, "si", $hashedPassword, $user['user_id']);
                mysqli_stmt_execute($stmt2);

                // 5️⃣ Redirect to login
                header("Location: login_institute.php?reset=success");
                exit();

            } else {
                $error = "No active account found with this email.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <style>
        <?php include 'css/style.css'; ?>
    </style>
</head>

<body class="m-0">

<div class="login_bg d-flex align-items-center">
    <div class="container login-layout pb-5">
        <div class="row align-items-center">

            <!--  LOGO -->
            <div class="col-lg-6 text-center mb-4 ">
                <img src="assets/images/logo.png"
                     alt="BeConnectEd logo"
                     class="form-logo">
            </div>

            <!--  FORM -->
            <div class="form-login col-lg-4 col-md-6 col-sm-12">

                <h4 class="form-title mb-3">Set Your Password</h4>

                <?php if ($error): ?>
                    <p class="text-danger"><?php echo $error; ?></p>
                <?php endif; ?>

                <form method="POST">

                    <input type="email"
                           name="email"
                           placeholder="Email address"
                           class="d-block button3"
                           required>

                    <input type="password"
                           name="password"
                           placeholder="New password"
                           class="d-block button3"
                           required>

                    <input type="password"
                           name="confirm_password"
                           placeholder="Confirm password"
                           class="d-block button3"
                           required>

                    <button type="submit"
                            name="submit"
                            class="button loginbtn mt-3">
                        Set Password
                    </button>

                </form>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="includes/darkmode.js" defer></script>

</body>
</html>
