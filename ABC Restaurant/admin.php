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

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add or update operations based on form submissions
    // Example: Add new user
    if (isset($_POST['add_user'])) {
        $name = $_POST['User_name'];
        $email = $_POST['Email'];
        $phone = $_POST['Tel_No'];
        $password = $_POST['Password'];
        $role = $_POST['Roll'];
        
        $sql = "INSERT INTO user". "(User_name, Email, Tel_No, Password, Roll)" . "VALUES ('$name', '$email', '$phone', '$password', '$role')";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die('Could not enter data: ' . mysqli_error($conn));
    } else {
        echo "Entered data successfully";
        // header("location: login.html");
    }
} else {
    echo "Your Form is not submitted yet. Please fill the form and visit again.";
}
    }
    // Add more handling for other forms as needed
    if (isset($_GET['action']) && $_GET['action'] === 'delete_user' && isset($_GET['User_Id'])) {
        $userId = $_GET['User_Id'];
    
        $stmt = $conn->prepare("DELETE FROM user WHERE User_Id = ?");
        $stmt->bind_param("i", $userId);
    
        if ($stmt->execute()) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => $stmt->error]);
        }
    
        $stmt->close();
        $conn->close();
        exit();
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
    if (isset($_POST['email'],  $_POST['response'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        // $query_message = htmlspecialchars(trim($_POST['query']));
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
                $mail->Password   = 'ietecvavxecrhxtg';     // SMTP password
            $mail->SMTPSecure = 'tls';                 // Enable TLS encryption
            $mail->Port       = 587;                   // TCP port to connect to

            // Recipients
            $mail->setFrom('kkavindya51@gmail.com', 'ABC Restuarant');
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
    <title>Admin Panel - ABC Hotel</title>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="#reservations">Manage Reservations</a></li>
            <li><a href="#queries">Customer Queries</a></li>
            <li><a href="#users">Manage Users & Staff</a></li>
            <li><a href="#reports">Reports</a></li>
            <li><a href="login.html">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <header>
            <h1>Welcome, Admin</h1>
            <p>Manage your restaurant efficiently and effectively</p>
        </header>

        <section id="reservations">
            <h2>Manage Reservations</h2>
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

                <form id="respond-query-form" method="POST" action="">
                <h3>Respond to Query</h3>
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
                            <th>email</th>
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
                                <td><?php echo htmlspecialchars($queris['email']); ?></td>
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

        <section id="users">
            <h2>Manage Users & Staff</h2>
            <form id="add-user-form" method="POST">
                <h3>Add New User/Staff</h3>
                <label for="User_name">Name:</label>
                <input type="text" id="User_name" name="User_name" required>
                
                <label for="Email">Email:</label>
                <input type="email" id="Email" name="Email" required>
                
                <label for="Tel_No">Phone Number:</label>
                <input type="tel" id="Tel_No" name="Tel_No" required>

                <label for="Password">Password:</label>
                <input type="password" id="Password" name="Password" required>
                
                <label for="Roll">Role:</label>
                <select id="Roll" name="Roll" required>
                    <option value="customer">Customer</option>
                    <option value="staff">Staff</option>
                </select>
                
                <button type="submit" name="add_user">Add User/Staff</button>
            </form>

            <!-- Edit User Form
    <div id="edit-user-form" style="display: none;">
        <h3>Edit User/Staff</h3>
        <form method="POST" onsubmit="submitEditUser(event)">
            <input type="hidden" id="edit-user-id" name="User_Id">
            <label for="edit-user-name">Name:</label>
            <input type="text" id="User_name" name="User_name" required>
            
            <label for="edit-user-email">Email:</label>
            <input type="email" id="Email" name="Email" required>
            
            <label for="edit-user-phone">Phone Number:</label>
            <input type="tel" id="Tel_No" name="Tel_No" required>

            <label for="edit-user-Password">Password:</label>
            <input type="text" id="Password" name="Password" required>
            
            <label for="edit-user-role">Role:</label>
            <select id="edit-user-role" name="role" required>
                <option value="customer">Customer</option>
                <option value="staff">Staff</option>
            </select>
            
            <button type="submit">Update User/Staff</button>
            <button type="button" onclick="hideEditForm()">Cancel</button>
        </form>
    </div> -->
        

            <h3>User/Staff List</h3>
            <button id="refresh-reservations" onclick="refreshPage()">Refresh List</button><br><br>
            <table>
                <thead>
                    <tr>
                    <th>User_Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Actions</th>
                        
                    </tr>
                </thead>
                <tbody id="user-list">
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['User_id']); ?></td>
                                <td><?php echo htmlspecialchars($user['User_name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['Tel_No']); ?></td>
                                <td><?php echo htmlspecialchars($user['Roll']); ?></td>

                                <td>
                                    <button class="edit-btn"><a href="edituser.php">Edit</a></button>
                                    <button class="delete-btn" onclick="deleteUser('<?php echo htmlspecialchars($user['User_id']); ?>')">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5">No users found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <br><br>


<section id="reports">
    <h2>Reports</h2>
    <div class="reports">
        <h3>Generate Reports</h3>
        <form id="report-form" method="POST" action="generate_report_details.php">
            <label for="report-type">Report Type:</label>
            <select id="report-type" name="report-type" required>
                <option value="delivery">Delivery Total Report</option>
                <option value="dinein">Dine-in Total Report</option>
            </select>
            
            <label for="start-date">Start Date:</label>
            <input type="date" id="start-date" name="start-date" required>
            
            <label for="end-date">End Date:</label>
            <input type="date" id="end-date" name="end-date" required>
            
            <button type="submit" name="generate_report">Generate Report</button>
        </form>
    </div>
</section>


    <script>

function editUser(userId) {
            var form = document.getElementById('add-user-form');
            var row = document.querySelector('tr[data-user-id="' + userId + '"]');
            var cells = row.getElementsByTagName('td');
            
            document.getElementById('User_name').value = cells[1].innerText;
            document.getElementById('Email').value = cells[2].innerText;
            document.getElementById('Tel_No').value = cells[3].innerText;
            document.getElementById('Password').value = '';
            document.getElementById('Roll').value = cells[4].innerText;
            
            form.action = '?action=edit_user';
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'User_Id';
            input.value = userId;
            form.appendChild(input);
        }


    function deleteUser(userId) {
        if (confirm('Are you sure you want to delete this user?')) {
            // Make an AJAX request to handle user deletion
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '?action=delete_user&User_Id=' + encodeURIComponent(userId), true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) { // Request is complete
                    if (xhr.status === 200) { // Status is OK
                        var response = JSON.parse(xhr.responseText);
                        if (response.status === 'success') {
                            // Remove the row from the table
                            var row = document.querySelector('tr[data-user-id="' + userId + '"]');
                            if (row) {
                                row.parentNode.removeChild(row);
                            }
                            alert('User deleted successfully.');
                        } else {
                            alert('Error deleting user: ' + response.message);
                        }
                    } else {
                        alert('Request failed. Please try again.');
                    }
                }
            };
            xhr.send();
        }
    }

    function deleteReservation(reservationId) {
            if (confirm("Are you sure you want to delete this reservation?")) {
                fetch(`?action=delete_reservation&Res_id=${reservationId}`)
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
