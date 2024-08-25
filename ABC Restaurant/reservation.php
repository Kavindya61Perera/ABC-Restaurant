<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Submission</title>
</head>
<body>

<?php
if (isset($_POST['submit'])) {
    include("connection.php");

    $orderType = $_POST['orderType'];

    if ($orderType == 'dinein') {
        // Dine-in details
        $orderType = $_POST['orderType'];
        $branchType = $_POST['branchType'];
        $Cus_name = $_POST['Cus_name'];
        $Tel_no = $_POST['Tel_no'];
        $Receive_date = $_POST['Receive_date'];
        $Receive_time = $_POST['Receive_time'];
        $Number_person = $_POST['Number_person'];

         // Assuming the price per person is 
         $pricePerPerson = 2500;
         $Total_Price = $Number_person * $pricePerPerson;

        $sql = "INSERT INTO reservation (orderType,branchType, Cus_name, Tel_no, Receive_date, Receive_time, Number_person, Total_Price)
                VALUES ('$orderType','$branchType', '$Cus_name', '$Tel_no', '$Receive_date', '$Receive_time', '$Number_person', '$Total_Price')";
        
    } elseif ($orderType == 'delivery') {
        // Delivery details
        $orderType = $_POST['orderType'];
        $Cus_name = $_POST['Cus_name'];
        $deliveryAddress = $_POST['deliveryAddress'];
        $Tel_no = $_POST['Tel_no'];
        $Receive_date = $_POST['Receive_date'];
        $foodType = $_POST['foodType'];
        $Quantity = $_POST['Quantity'];

        // Define prices for each food type
        $foodPrices = [
            'Pasta' => 1800,
            'Noodles' => 1300,
            'Mongolian Rice' => 1500,
            'Vege Salad' => 1200,
            'Burger' => 980,
            'Waffels' => 900,
            'Orange Juice' => 300,
            'Iced Coffee' => 400,
            'Mojito' => 400
        ];

        // Calculate the total price based on food type and quantity
        $pricePerItem = $foodPrices[$foodType];
        $Total_Price = $Quantity * $pricePerItem;

        $sql = "INSERT INTO reservation (orderType,Cus_name, deliveryAddress, Tel_no, foodType, Receive_date, Quantity, Total_Price)
                VALUES ('$orderType','$Cus_name', '$deliveryAddress', '$Tel_no', '$foodType', '$Receive_date', '$Quantity', '$Total_Price')";
    } else {
        echo "Invalid order type.";
        exit;
    }

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die('Could not enter data: ' . mysqli_error($conn));
    } else {
        echo "Entered data successfully";
        echo "<p>Total Price: $$totalPrice</p>";
        header('location:payment.php');
    }
} else {
    echo "Your Form is not submitted yet. Please fill the form and visit again.";
}
?>

</body>
</html>

