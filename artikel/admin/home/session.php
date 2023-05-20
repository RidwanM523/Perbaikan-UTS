<?php
include('../config.php');

$user_check = $_SESSION['username'];
$ses_sql = mysqli_query($mysqli, "select username from tb_users where username='$user_check'");
$row = mysqli_fetch_assoc($ses_sql);
$login_session = $row['username'];
if (!isset($login_session)) {
    mysqli_close($mysqli);
    header('Location: index.php');
    exit();
}
