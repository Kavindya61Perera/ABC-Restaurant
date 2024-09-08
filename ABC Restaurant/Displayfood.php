<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABC Restaurant - Food & Beverages</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body background="Image/tt.jpg">
    <header>
        <div class="logo">
            <img src="Image/logo.jfif" alt="ABC Restaurant Logo">
        </div>
        <nav>
            <ul>
                <li><a href="home.html">Home</a></li>
                <li><a href="gallery.html">Gallery</a></li>
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
            <button class="offer-button" onclick="goToOfferPage('offers.html')">Offers</button>
            <button class="login-button" onclick="goTologinPage('login.html')"><i class="fa-solid fa-user"></i> 
                <span>Login</span>
            </button>
        </div>
    </header>

    <?php
    include('connection.php'); // Ensure your database connection file is correctly included

    $searchResults = [];

    // Check if the form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize the input
        $search = mysqli_real_escape_string($conn, $_POST['Food_name']);

        // Prepare and execute the SQL query
        $sql = "SELECT * FROM food_items WHERE name LIKE '%$search%'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Fetch results
            while ($row = mysqli_fetch_assoc($result)) {
                $searchResults[] = $row;
            }
        } else {
            echo "Couldn't execute query: " . mysqli_error($conn);
        }
    }
    ?>

    <form method="post" action="Displayfood.php" class="search-container">
    <button type="button" class="back-button" onclick="goToFoodPage('Displayf&b.php')"><i class="fa-solid fa-arrow-left"></i> 
        <span>Back</span>
    </button>
        <input type="text" name="Food_name" class="search-input" placeholder="Search...">
        <button class="search-button"><i class="fa-solid fa-search"></i></button>
    </form>

    <main>
        <section class="food-intro">
            <h1>Food & Beverages</h1>
            <p>Explore our diverse menu of delicious dishes and refreshing beverages. At ABC Restaurant, we offer a range of options to satisfy every palate, from traditional favorites to innovative new creations.</p>
        </section>
        <section class="food-menu">
            <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($searchResults)): ?>
                <p>No results found for "<?php echo htmlspecialchars($_POST['Food_name']); ?>"</p>
            <?php else: ?>
                <?php foreach ($searchResults as $food): ?>
                    <div class="food-item">
                        <img src="Image/<?php echo htmlspecialchars($food['image']); ?>" alt="<?php echo htmlspecialchars($food['name']); ?>">
                        <div class="food-info">
                            <h2><?php echo htmlspecialchars($food['name']); ?></h2>
                            <p><?php echo htmlspecialchars($food['description']); ?></p>
                            <span class="price">RS.<?php echo htmlspecialchars($food['price']); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
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
                        <li><a href="service.html">Services</a></li>
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

  function goToFoodPage(page) {
      window.location.href = page;
  }
</script>

</html>
