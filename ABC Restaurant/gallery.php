<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ABC Restaurant</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <meta http-equiv="refresh" content="30">
    </head>
<body background="Image/tt.jpg">
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
    </header>

    <?php
include("connection.php"); // Ensure this path is correct

// Fetch gallery items from the database
$sql = "SELECT * FROM gallery";
$result = mysqli_query($conn, $sql);
?>

<main>
    <div class="gallery-section">
        <h2>Our Gallery</h2>
        <p>Here are some of our best dishes</p>
        <div class="gallery">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="gallery-item">';
                    echo '<img src="uploads/' . $row['image'] . '" alt="' . htmlspecialchars($row['caption']) . '">';
                    echo '<div class="caption">' . htmlspecialchars($row['caption']) . '</div>';
                    echo '</div>';
                }
            } else {
                echo "<p>No gallery items available.</p>";
            }
            ?>
        </div>
    </div>
</main>

<?php
mysqli_close($conn);
?>
    
    <!-- <main>
        <div class="gallery-section">
            <h2>Our Gallery</h2>
            <p>Here are some of our best dishes</p>
            <div class="gallery">
                <div class="gallery-item">
                    <img src="Image/bc.jpg" alt="Sushi">
                    <div class="caption">SUSHI</div>
                </div>
                <div class="gallery-item">
                    <img src="Image/bc3.jpg" alt="Special Pasta">
                    <div class="caption">Special Pasta</div>
                </div>
                <div class="gallery-item">
                    <img src="Image/Pasta.jpg" alt="Spaghetti">
                    <div class="caption">Spaghetti</div>
                </div>
                <div class="gallery-item">
                    <img src="Image/Waffel.jpg" alt="Delicious Waffel">
                    <div class="caption">Delicious Waffel</div>
                </div>
                <div class="gallery-item">
                    <img src="Image/bc4.jpg" alt="Special Table">
                    <div class="caption">Special Tabel</div>
                </div>
                <div class="gallery-item">
                    <img src="Image/Noodless.jpg" alt="Noodless">
                    <div class="caption">Noodless</div>
                </div>
                <div class="gallery-item">
                    <img src="Image/Dine_In.jpg" alt="Cofee Tabel">
                    <div class="caption">Cofee Tabel</div>
                </div>
                <div class="gallery-item">
                    <img src="Image/Event_Catering.jpg" alt="Event">
                    <div class="caption">Event</div>
                </div>
                <div class="gallery-item">
                    <img src="Image/Mojito.jpg" alt="Mojito">
                    <div class="caption">Mojito</div>
                </div>
            </div>
        </div>
    </main> -->

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
                <li><a href="home.html">Home</a></li>
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
</body>

<script>
    function goToOfferPage(page) {
        window.location.href = page;
    }
  
    function goTologinPage(page) {
        window.location.href = page;
    }
  </script>

</html>
