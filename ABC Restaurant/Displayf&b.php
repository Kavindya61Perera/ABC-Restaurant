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
            <button class="login-button" onclick="goTologinPage('login.html')"><i class="fa-solid fa-user"></i> 
                <span>Login</span>
            </button>
        </div>
    </header>

    <form method="post" action="Displayfood.php" class="search-container">
        <input type="text" name="Food_name" class="search-input" placeholder="Search...">
        <button class="search-button"><i class="fa-solid fa-search"></i></button>
    </form>

    <main>
        <section class="food-intro">
            <h1>Food & Beverages</h1>
            <p>Explore our diverse menu of delicious dishes and refreshing beverages. At ABC Restaurant, we offer a range of options to satisfy every palate, from traditional favorites to innovative new creations.</p>
        </section>

        <?php include("connection.php"); ?>

        <section class="food-menu">
            <?php
            

            // Fetch food items from the database
            $sql = "SELECT * FROM food_items";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="food-item">';
                    echo '<img src="uploads/' . $row['image'] . '" alt="' . $row['name'] . '">';
                    echo '<div class="food-info">';
                    echo '<h2>' . $row['name'] . '</h2>';
                    echo '<p>' . $row['description'] . '</p>';
                    echo '<span class="price">RS.' . $row['price'] . '</span>';
                    echo '<div class="rating">';
                    echo '<span class="stars" data-item="' . $row['name'] . '">★★★★★</span>';
                    echo '<button class="rate-button" data-item="' . $row['name'] . '">Rate this dish</button>';
                    echo '<input type="hidden" class="rating-value" data-item="' . $row['name'] . '" value="0">';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<p>No food items available.</p>";
            }

            mysqli_close($conn);
            ?>
        </section>
    </main>

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

    <script>
        function goToOfferPage(page) {
            window.location.href = page;
        }

        function goTologinPage(page) {
            window.location.href = page;
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.rate-button').forEach(button => {
                button.addEventListener('click', () => {
                    const item = button.getAttribute('data-item');
                    const rating = prompt('Rate this dish (1-5 stars):');
                    
                    if (rating >= 1 && rating <= 5) {
                        const stars = button.previousElementSibling;
                        const ratingValue = button.nextElementSibling;
                        
                        stars.textContent = '★'.repeat(rating) + '☆'.repeat(5 - rating);
                        ratingValue.value = rating;
                        
                        alert(`Thank you for rating ${item} with ${rating} stars!`);
                    } else {
                        alert('Please enter a rating between 1 and 5.');
                    }
                });
            });
        });
    </script>

</body>
</html>
