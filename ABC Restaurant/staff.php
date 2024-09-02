<?php
include("connection.php"); // Ensure this path is correct

// Fetch data for dynamic content if necessary
// fetching users
$sql_users = "SELECT * FROM user";
$result_users = $conn->query($sql_users);

if ($result_users === FALSE) {
    error_log("Database error: " . $conn->error, 3, "error.log");
    $users = [];
} else {
    $users = $result_users->fetch_all(MYSQLI_ASSOC);
}


$sql_queris = "SELECT * FROM queris";
$result_queris = $conn->query($sql_queris);

if ($result_queris === FALSE) {
    error_log("Database error: " . $conn->error, 3, "error.log");
    $queris = [];
} else {
    $queris = $result_queris->fetch_all(MYSQLI_ASSOC);
}

$sql_reservation = "SELECT * FROM reservation";
$result_reservation = $conn->query($sql_reservation);

if ($result_reservation === FALSE) {
    error_log("Database error: " . $conn->error, 3, "error.log");
    $reservation = [];
} else {
    $reservation = $result_reservation->fetch_all(MYSQLI_ASSOC);
}


    if (isset($_GET['action']) && $_GET['action'] === 'delete_reservation' && isset($_GET['Res_id'])) {
        $reservationId = $_GET['Res_id'];
    
        $stmt = $conn->prepare("DELETE FROM reservation WHERE Res_id = ?");
        $stmt->bind_param("i", $reservationId);
    
        if ($stmt->execute()) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => $stmt->error]);
        }
    
        $stmt->close();
        $conn->close();
        exit();
    }

    
// Include PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\wamp64\www\ABC2\phpmailer\src\Exception.php';
require 'C:\wamp64\www\ABC2\phpmailer\src\PHPMailer.php';
require 'C:\wamp64\www\ABC2\phpmailer\src\SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email'], $_POST['query'], $_POST['response'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        
        $response_message = htmlspecialchars(trim($_POST['response']));

        // You may want to log the query and response to the database, or update relevant fields

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = 0;                      // Disable verbose debug output
            $mail->isSMTP();                           // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';      // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                  // Enable SMTP authentication
            $mail->Username   = 'kkavindya51@gmail.com';    // SMTP username
            $mail->Password   = 'ietecvavxecrhxtg';    // SMTP password
            $mail->SMTPSecure = 'tls';                 // Enable TLS encryption
            $mail->Port       = 587;                   // TCP port to connect to

            // Recipients
            $mail->setFrom('kkavindya51@gmail.com', 'ABC Restaurant');
            $mail->addAddress($email);                 // Add recipient email

            // Content
            $mail->isHTML(true);                       // Set email format to HTML
            $mail->Subject = 'Response to Your Query';
            $mail->Body    = "Dear User,<br><br>Thank you for your query.<br><br>Our Response:<br>$response_message<br><br>Best Regards,<br>ABC Restaurant";

            $mail->send();
            $feedback = 'A response email has been sent to ' . $email;
        } catch (Exception $e) {
            $feedback = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $feedback = "Please fill in all the fields and try again.";
    }
    
}

    
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adminstyle.css">
    <title>Staff Panel - ABC Hotel</title>
</head>
<body>
    <div class="sidebar">
        <h2>Staff Panel</h2>
        <ul>
            <li><a href="#reservations">Manage Reservations</a></li>
            <li><a href="#queries">Customer Queries</a></li>
            <li><a href="login.html">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <header>
            <h1>Welcome, Staff</h1>
            <p>Work with your restaurant site efficiently and effectively</p>
        </header>

        <section id="reservations">
            <div class="manage-reservations">
                <h3>Reservation List</h3>
                <button id="refresh-reservations" onclick="refreshPage()">Refresh List</button><br><br>
                <table>
                    <thead>
                        <tr>
                            <th>Reservation ID</th>
                            <th>orderType</th>
                            <th>branchType</th>
                            <th>Cus_name</th>
                            <th>deliveryAddress</th>
                            <th>Tel_no</th>
                            <th>Receive_date</th>
                            <th>Receive_time</th>
                            <th>Number_person</th>
                            <th>foodType</th>
                            <th>Quantity</th>
                            <th>Total_Price</th>
                            <th>Payment_Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($reservation as $res) {
                        echo '<tr>';
                        echo '<td>' . $res['Res_id'] . '</td>';
                        echo '<td>' . $res['orderType'] . '</td>';
                        echo '<td>' . $res['branchType'] . '</td>';
                        echo '<td>' . $res['Cus_name'] . '</td>';
                        echo '<td>' . $res['deliveryAddress'] . '</td>';
                        echo '<td>' . $res['Tel_no'] . '</td>';
                        echo '<td>' . $res['Receive_date'] . '</td>';
                        echo '<td>' . $res['Receive_time'] . '</td>';
                        echo '<td>' . $res['Number_person'] . '</td>';
                        echo '<td>' . $res['foodType'] . '</td>';
                        echo '<td>' . $res['Quantity'] . '</td>';
                        echo '<td>' . $res['Total_Price'] . '</td>';
                        echo '<td>' . $res['Payment_Status'] . '</td>';
                        echo '<td><button class="delete-btn" onclick="deleteReservation(' . $res['Res_id'] . ')">Delete</button></td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
                </table>
            </div>
        </section>
        <br><br>

        <section id="queries">
            <h2>Customer Queries</h2>
            <div class="queries">
                <h3>Query List</h3>

                <form id="respond-query-form" method="POST" >
                <h3>Respond to Query</h3>
                <form action="" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="response">Response Message:</label>
                <textarea id="response" name="response" rows="4" required></textarea>
            </div>
            <button type="submit">Send</button>
        </form>
            </form>

                <table>
                    <thead>
                        <tr>
                            <th>Query_ID</th>
                            <th>name</th>
                          
                            <th>phone</th>
                            <th>subject</th>
                            <th>message</th>
                        </tr>
                    </thead>
                    <tbody id="query-list">
                    
                    <?php if (!empty($queris)): ?>
                        <?php foreach ($queris as $queris): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($queris['Query_id']); ?></td>
                                <td><?php echo htmlspecialchars($queris['name']); ?></td>
                                <td><?php echo htmlspecialchars($queris['phone']); ?></td>
                                <td><?php echo htmlspecialchars($queris['subject']); ?></td>
                                <td><?php echo htmlspecialchars($queris['message']); ?></td>
                                <!-- <td>
                                    <button class="edit-btn" onclick="editUser('<?php echo htmlspecialchars($user['id']); ?>')">Edit</button>
                                    <button class="delete-btn" onclick="deleteUser('<?php echo htmlspecialchars($user['id']); ?>')">Delete</button>
                                </td> -->
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5">No users found</td></tr>
                    <?php endif; ?>
                </tbody>
                    </tbody>
                </table>
            </div>
        </section>
        <br><br>


    <script>

    function deleteReservation(reservationId) {
            if (confirm("Are you sure you want to delete this reservation?")) {
                fetch(`?action=delete_reservation&Reservation_Id=${reservationId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "success") {
                            alert("Reservation deleted successfully!");
                            location.reload();
                        } else {
                            alert("Error deleting reservation: " + data.message);
                        }
                    });
            }
        }

        function refreshPage() {
        location.reload(); // Reloads the current page
    }

    </script>
</body>
</html>
