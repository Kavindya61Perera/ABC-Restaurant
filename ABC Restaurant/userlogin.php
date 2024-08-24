<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php
if (isset($_POST['submit'])) {
    include 'connection.php';

    $U_Name = $_POST["User_name"];
    $pass = $_POST["Password"];

    $sql = "SELECT * FROM user WHERE User_name='$U_Name' AND Password='$pass'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Fetch the role of the user
        $row = mysqli_fetch_assoc($result);
        $role = $row['Roll'];

        // Redirect based on role
        switch ($role) {
            case 'admin':
                header("location: admin.php");
                break;
            case 'staff':
                header("location: staff.php");
                break;
            case 'customer':
                header("location: reservation.html");
                break;
            default:
                // Handle unexpected roles here (optional)
                header("location: login.html");
                break;
        }
        exit; // Ensure script stops execution after redirection
    } else {
        $msg = "Your Login Name or Password is invalid";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
}
?>


</body>
</html>