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

    // Retrieve form data into variables (without sanitization)
    $Name = $_POST['name'];
    $Email = $_POST['email'];
    $Mobile = $_POST['phone'];
    $Subject = $_POST['subject'];
    $Message = $_POST['message'];

    // Insert user details into the database (without sanitization)
    $sql = "Insert Into query". "(name, email, phone, subject, message)".
            "VALUES ('$Name', '$Email', '$Mobile', '$Subject', '$Message')";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die('Could not enter data: ' . mysqli_error($conn));
    } else {
        echo "We received your query. Thank you very much!";
    }

    // Close database connection
    mysqli_close($conn);
} else {
    echo "Your Form is not submitted yet. Please fill the form and visit again.";
}
?>



</body>
</html>