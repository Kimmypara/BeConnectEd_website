<?php
require_once "dbh.php"; 



if (isset($_GET['user_id']) && isset($_GET['is_active'])) {

    $user_id = intval($_GET['user_id']);
    $is_active = $_GET['is_active'];

    if ($is_active === "activate") {
        $status = 1;
    } elseif ($is_active === "inactivate") {
        $status = 0;
    } else {
        die("Invalid action");
    }

    $sql = "UPDATE users SET is_active = ? WHERE user_id = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die("SQL Error");
    }

    mysqli_stmt_bind_param($stmt, "ii", $is_active, $user_id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    // Redirect to table 
    header("location: ../registration_admin.php");
    exit();
}
?>
