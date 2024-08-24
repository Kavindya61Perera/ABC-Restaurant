<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php
if (isset($_POST['submit'])) {
    include("connection.php");

    $UserName = $_POST['User_name'];
    $Email = $_POST['email'];
    $mobile = $_POST['Tel_No'];
    $password = $_POST['Password'];

    // Check if username starts with "Staff" and has digits
    if (preg_match('/^Staff\d+$/', $UserName)) {
        // Display a message and prevent further execution
        echo "Registration with this username is not allowed.";
        exit;
    } else {
        // Always set role to 'customer' for non-Staff usernames
        $role = 'customer';
    }

    // Determine the role based on User_name
    // if (preg_match('/^Staff\d+$/', $UserName)) {
    //     $role = 'staff';
    // } else {
    //     $role = 'customer';
    // }

    // Insert user details into the database including the determined role
    $sql = "Insert Into user". "(User_name, email, Tel_No, Password, Roll)" . "VALUES ('$UserName', '$Email', '$mobile', '$password', '$role')";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die('Could not enter data: ' . mysqli_error($conn));
    } else {
        echo "Entered data successfully";
        header("location: login.html");
    }
} else {
    echo "Your Form is not submitted yet. Please fill the form and visit again.";
}
?>


</body>
</html>