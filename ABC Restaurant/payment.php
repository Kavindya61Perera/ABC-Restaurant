<?php
include("connection.php");

// Include PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\wamp64\www\ABC2\phpmailer\src\Exception.php';
require 'C:\wamp64\www\ABC2\phpmailer\src\PHPMailer.php';
require 'C:\wamp64\www\ABC2\phpmailer\src\SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Cus_name'])) {
        $Cus_name = $_POST['Cus_name'];
        $email = $_POST['email'];
        $card_number = $_POST['card_number'];
        $card_exp_month = $_POST['card_exp_month'];
        $card_exp_year = $_POST['card_exp_year'];
        $card_cvc = $_POST['card_cvc'];
        
        // Update the reservation table's payment column where Cus_name matches
        $sql = "UPDATE reservation SET Payment_Status='Paid' WHERE Cus_name='$Cus_name'";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die('Could not update data: ' . mysqli_error($conn));
        } else {
            echo "Payment updated successfully";
            
            // Create a new PHPMailer instance
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->SMTPDebug = 0;                      // Disable verbose debug output
                $mail->isSMTP();                           // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                  // Enable SMTP authentication
                $mail->Username   = 'kkavindya51@gmail.com';    // SMTP username
                $mail->Password   = 'ietecvavxecrhxtg';              // SMTP password
                $mail->SMTPSecure = 'tls';                 // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                   // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS`

                // Recipients
                $mail->setFrom('kkavindya51@gmail.com', 'ABC Restuarant');
                $mail->addAddress($email, $Cus_name);      // Add a recipient

                // Content
                $mail->isHTML(true);                       // Set email format to HTML
                $mail->Subject = 'Payment Confirmation';
                $mail->Body    = "Dear $Cus_name,<br><br>Your payment has been received and processed successfully. Thank you for your reservation.<br><br>Best Regards,<br>ABC Restaurant<br>Thank You!";

                $mail->send();
                echo 'An email confirmation has been sent to ' . $email;
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    } else {
        echo "Your Form is not submitted yet. Please fill the form and submit again.";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
	<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABC Restaurant</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
	<body background="Image/bc.jpg">
        <header>
            <div class="logo">
                <img src="Image/logo.jfif" alt="ABC Restaurant Logo">
            </div>
            <nav>
                <ul>
                    <li><a href="home.html">Home</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li class="dropdown">
                        <a href="#">Our Specialities &#9662;</a>
                        <ul class="dropdown-content">
                            <li><a href="service.html">Services</a></li>
                            <li><a href="facility.html">Facilities</a></li>
                            <li><a href="Displayf&b.php">Food & Beverages</a></li>
                        </ul>
                    </li>
                    <li><a href="contact.html">Contact Us</a></li>
                </ul>
            </nav>
            <div class="nav-buttons">
                <button class="offer-button" onclick="goToOfferPage('offers.php')">Offers</button>
                <button class="login-button" onclick="goTologinPage('login.html')" ><i class="fa-solid fa-user"></i> 
                  <span>Login</span>
                </button>
            </div>
        </header><br>
        <button type="button" class="back-button" onclick="goToReservationPage('reservation.html')"><i class="fa-solid fa-arrow-left"></i> 
        <span>Back</span>
    </button>
		<div class="login">
			<h1>Payment Form</h1>
			<form name="login" action="payment.php" method="POST" id="payment-form" onsubmit="return validateForm()">
            
            <label for="Cus_name"></label>
            <input type="text" name="Cus_name" placeholder="Card Holder Name" id="Cus_name" required>

            <label for="email"></label>
            <input type="text" name="email" placeholder="email" id="Email" pattern="^[^@]+@[^@]+\.[a-zA-Z]{2,}$" 
            title="Email must contain an '@' symbol and a '.' after the '@' symbol, followed by a example Email (e.g., example@domain.com)"  required>

            <label for="card_number"></label>
            <input type="text" name="card_number" placeholder="Card Number" id="card_number" pattern="\d{16}" title="Card number should be between 16 digits" required>

            <label for="card_exp_month"></label>
            <input type="text" name="card_exp_month" placeholder="Expiry Month (MM)" id="card_exp_month" pattern="0[1-9]|1[0-2]" title="Expiry month should be between 01 and 12" required>

            <label for="card_exp_year"></label>
            <input type="text" name="card_exp_year" placeholder="Expiry Year (YYYY)" id="card_exp_year" pattern="\d{4}" 
            title="Expiry year should be 4 digits" required>

            <label for="card_cvc"></label>
            <input type="password" name="card_cvc" placeholder="CVC" id="card_cvc" pattern="\d{3}" title="CVC should be only 3 digits" required>

            <input type="submit" name="submit" value="Submit Payment">

        </form>
    </div>

		</div>
	</body>

    <footer>
        <div class="footer-container">
          <div class="footer-left">
            <h4>ABC Restaurant</h4>
            <p>Our purpose is to serve the best food in town.</p>
          </div>
          <div class="footer-right">
            <div class="quick-links">
              <h4>Quick Links</h4>
              <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="gallery.html">Gallery</a></li>
                <li><a href="service.html"></li>
                <li><a href="contact.html">Contact Us</a></li>
              </ul>
            </div>
            <div class="contact-info">
              <h4>Contact Information</h4>
              <p><strong>Opening Hours:</strong> Mon-Fri 10:00 AM - 10:00 PM</p>
              <p><strong>Location:</strong> 123 Main Street, Colombo</p>
              <p><strong>Phone:</strong> +94 123 456 789</p>
              <p><strong>Email:</strong> info@abcrestaurant.lk</p>
            </div>
          </div>
          <div class="footer-bottom">
            <p>© 2024 ABC Restaurant. All Rights Reserved.</p>
          </div>
        </div>
      </footer>

    <script type="text/javascript">
       
      function goToOfferPage(page) {
          window.location.href = page;
      }

      function goTologinPage(page) {
          window.location.href = page;
      }

      function goToReservationPage(page) {
      window.location.href = page;
  }
      
  function validateForm() {
    var form = document.getElementById('payment-form');
    var cardNumber = document.getElementById('card_number').value;
    var cardExpMonth = document.getElementById('card_exp_month').value;
    var cardExpYear = document.getElementById('card_exp_year').value;
    var cardCvc = document.getElementById('card_cvc').value;

    // Expiry date validation
    var currentYear = new Date().getFullYear();
    var currentMonth = new Date().getMonth() + 1; // Months are zero-based
    if (parseInt(cardExpYear) < currentYear || (parseInt(cardExpYear) === currentYear && parseInt(cardExpMonth) < currentMonth)) {
        alert('Card has expired.');
        return false;
    }

    return true; // Allow form submission
}
      </script>

</html>

