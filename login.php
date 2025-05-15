<?php

include "./helper.php";
session_start();



$requestUsername = $_REQUEST['username'] ?? null;
$requestPassword = $_REQUEST['password'] ?? null;

$errorMessage = "";


if (empty($requestUsername) || empty($requestPassword)) {
    $errorMessage = "نام کاربری یا رمز عبور نمی‌تواند خالی باشد.";
    include "./view/login.html"; 
    echo "<script>alert('$errorMessage');</script>";
    return;
}


$userData = select($connection, "SELECT * FROM `users` WHERE `username` = ?", [$requestUsername])[0] ?? null;

if (empty($userData)) {
    $errorMessage = "نام کاربری وجود ندارد.";
    include "./view/login.html"; // نمایش صفحه ورود با پیام خطا
    echo "<script>alert('$errorMessage');</script>";
    return;
}


if (!password_verify($requestPassword, $userData['password'])) {
    $errorMessage = "رمز عبور نادرست است.";
    include "./view/login.html"; 
    echo "<script>alert('$errorMessage');</script>";
    return;
}
$_SESSION['user_id'] = $userData['id'];

header("Location: index.php");
exit();
