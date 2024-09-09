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
<body background="Image/bc4.jpg">
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

    <main>
        <section class="service-intro">
            <h1 style="color: black;">ABC Restaurant Offers</h1>
            <p>Exclusive deals and discounts just for you!</p>
        </section>

        <?php include("connection.php"); ?>

        <section class="offers">

            <?php
            // Fetch offers from the database
            $sql = "SELECT * FROM offers";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="offer-card">';
                    echo '<img src="uploads/' . $row['image'] . '" alt="' . htmlspecialchars($row['title']) . '">';
                    echo '<div class="offer-info">';
                    echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
                    echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<p>No offers available.</p>";
            }

            mysqli_close($conn);
            ?>
        </section>
    </main>
    
    <!-- <main>
        <section class="service-intro">
            <h1 style="color: black;">ABC Restaurant Offers</h1>
            <p>Exclusive deals and discounts just for you!</p>
        </section>
        <section class="offers">
            <div class="offer-card">
                <img src="Image/bc.jpg" alt="Offer 1">
                <div class="offer-info">
                    <h2>Offer Title 1</h2>
                    <p>Details about the first offer. Enjoy a special discount on our best dishes.</p>
                    <button>Learn More</button>
                </div>
            </div>
            <div class="offer-card">
                <img src="Image/bc3.jpg" alt="Offer 2">
                <div class="offer-info">
                    <h2>Offer Title 2</h2>
                    <p>Details about the second offer. Get a free dessert with your meal!</p>
                    <button>Learn More</button>
                </div>
            </div>
            <div class="offer-card">
                <img src="Image/bc3.jpg" alt="Offer 2">
                <div class="offer-info">
                    <h2>Offer Title 2</h2>
                    <p>Details about the second offer. Get a free dessert with your meal!</p>
                    <button>Learn More</button>
                </div>
            </div>
        </section>

        <section class="offers">
            <div class="offer-card">
                <img src="Image/bc.jpg" alt="Offer 1">
                <div class="offer-info">
                    <h2>Offer Title 1</h2>
                    <p>Details about the first offer. Enjoy a special discount on our best dishes.</p>
                    <button>Learn More</button>
                </div>
            </div>
            <div class="offer-card">
                <img src="Image/bc3.jpg" alt="Offer 2">
                <div class="offer-info">
                    <h2>Offer Title 2</h2>
                    <p>Details about the second offer. Get a free dessert with your meal!</p>
                    <button>Learn More</button>
                </div>
            </div>
            <div class="offer-card">
                <img src="Image/bc3.jpg" alt="Offer 2">
                <div class="offer-info">
                    <h2>Offer Title 2</h2>
                    <p>Details about the second offer. Get a free dessert with your meal!</p>
                    <button>Learn More</button>
                </div>
            </div>
        </section>

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
