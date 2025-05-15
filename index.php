<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mitch Pasties HomePage</title>

    <!-- External Stylesheets -->
    <link rel="stylesheet" href="homepage/styleC/section1navbar.css" />
    <link rel="stylesheet" href="homepage/styleC/section1welcom.css" />
    <link rel="stylesheet" href="homepage/styleC/section2.css" />
    <link rel="stylesheet" href="homepage/styleC/section3.css" />
    <link rel="stylesheet" href="homepage/styleC/footer.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Lobster&display=swap"
      rel="stylesheet"
    />

    <!-- Modal Styles -->
    <style>
      /* Shared Modal Styling */
      .modal,
      .about-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 999;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
      }

      /* Account Buttons Styling */
      .sign-in-btn, .sign-up-btn {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
      }

      .sign-in-btn {
        background-color: transparent;
        border: 2px solid #f39c12;
        color: #f39c12;
      }

      .sign-up-btn {
        background-color: #f39c12;
        border: 2px solid #f39c12;
        color: white;
      }

      .sign-in-btn:hover {
        background-color: #f39c12;
        color: white;
      }

      .sign-up-btn:hover {
        background-color: #e67e22;
        border-color: #e67e22;
      }

      /* User Account Styling */
      .user-account {
        display: flex;
        align-items: center;
        gap: 10px;
      }

      .user-name {
        color: #f39c12;
        font-weight: 500;
      }

      .logout-btn {
        background-color: transparent;
        border: 2px solid #e74c3c;
        color: #e74c3c;
        padding: 8px 16px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
      }

      .logout-btn:hover {
        background-color: #e74c3c;
        color: white;
      }

      /* Product Modal */
      #product-modal .modal-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 16px;
        width: 90%;
        max-width: 400px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        animation: fadeIn 0.3s ease;
        position: relative;
      }

      #modal-product-image {
        max-width: 100%;
        max-height: 200px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 10px;
      }

      /* About Modal */
      #aboutModal {
        display: none;
        align-items: center;
        justify-content: center;
      }

      #aboutModal .modal-content {
        background-color: #fff;
        padding: 30px;
        border-radius: 16px;
        width: 90%;
        max-width: 800px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        position: relative;
      }

      .close,
      .close-btn {
        position: absolute;
        top: 10px;
        right: 20px;
        font-size: 28px;
        font-weight: bold;
        color: #aaa;
        cursor: pointer;
      }

      .close:hover,
      .close-btn:hover {
        color: #f39c12;
      }

      .modal-body {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 20px;
      }

      .modal-left img {
        width: 100%;
        max-width: 300px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      }

      .modal-right h3.modal-tagline {
        font-family: "Brush Script MT", cursive;
        font-size: 1.8em;
        color: #2e2e2e;
        margin-bottom: 15px;
      }

      .modal-right p {
        font-size: 1.05em;
        line-height: 1.6;
        color: #444;
      }

      @keyframes fadeIn {
        from {
          opacity: 0;
          transform: translateY(20px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }
    </style>
  </head>
  <body>
    <!-- Navigation Bar -->
    <section class="navigation-bar">
      <div class="top-navbar">
        <div class="nav-section">
          <p class="section-title">MAIN</p>
          <a href="index.php" class="active">Home</a>
          <a href="ClientSide/catalogue/index.php">Catalogue</a>
          <a href="ClientSide/Checkout page/index.php">Cart</a>
        </div>
        <div class="nav-section">
          <p class="section-title">ACCOUNT</p>
          <?php include 'ClientSide/homepage/user_session.php'; displayUserSession(); ?>
        </div>
      </div>
    </section>

    <!-- Hero Section -->
    <section class="hero">
      <div class="overlay">
        <div class="hero-content">
          <div class="welcoming">
            <h1>Welcome to Mitch Pastries!</h1>
            <p class="hero-subtext">Freshly baked, every day.</p>
          </div>
          <button class="button">
            <a href="loading/index.php?target=catalogue/index.php">Order Now</a>
          </button>
        </div>
      </div>
    </section>

    <!-- What's New Section -->
    <div id="best-products" class="section2">
      <div class="bestproduct">What's New</div>
      <div class="product-boxes">
        <div class="box" style="animation-delay: 0s">
          <div
            class="product-card"
            onclick="updateProductDetails('Banana Pudding', '₱3.69', 'A creamy, layered dessert made with fresh bananas, vanilla pudding, and soft wafers, topped with whipped cream.', 'images/banana-pudding.jpg')"
          >
            <img src="images/banana-pudding.jpg" alt="Banana Pudding" />
            <div class="overlay">View More</div>
            <div class="product-card-text">
              <h4>Banana Pudding</h4>
              <p>₱3.69</p>
            </div>
          </div>
        </div>

        <div class="box" style="animation-delay: 0.5s">
          <div
            class="product-card"
            onclick="updateProductDetails('Oreo Brookies', '₱5.99', 'A decadent fusion of fudgy brownies and chewy cookies, packed with Oreo chunks for indulgence.', 'images/oreo-brookies.jpg')"
          >
            <img src="images/oreo-brookies.jpg" alt="Oreo Brookies" />
            <div class="overlay">View More</div>
            <div class="product-card-text">
              <h4>Oreo Brookies</h4>
              <p>₱5.99</p>
            </div>
          </div>
        </div>

        <div class="box" style="animation-delay: 1s">
          <div
            class="product-card"
            onclick="updateProductDetails('Leche Flan', '₱4.50', 'A rich and silky custard topped with a golden caramel glaze—this Filipino classic melts in your mouth.', 'images/leche-flan.jpg')"
          >
            <img src="images/leche-flan.jpg" alt="Leche Flan" />
            <div class="overlay">View More</div>
            <div class="product-card-text">
              <h4>Leche Flan</h4>
              <p>₱4.50</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Product Modal -->
    <div id="product-modal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <img id="modal-product-image" src="" alt="Product Image" />
        <h2 id="modal-product-name">Product Name</h2>
        <p id="modal-product-price">₱0.00</p>
        <p id="modal-product-description">Product description goes here.</p>
        <button onclick="addToCart()">Order Now</button>
      </div>
    </div>

    <!-- About Us Section -->
    <div id="about-us" class="section3">
      <div class="about-content">
        <div class="about-text">
          <h2>About Us</h2>
          <p class="tagline">Crafting joy, one pastry at a time.</p>
          <p>
            At <strong>Mitch's Pastries</strong>, we craft sweet experiences.
            From buttery croissants to indulgent cakes, every treat is handmade
            with the finest ingredients and a whole lot of love.
          </p>
          <a href="about.html" class="btn-learn-more">Learn More</a>
          <div class="social-icons">
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-x-twitter"></i></a>
          </div>
        </div>
        <div class="about-image">
          <img src="homepage/styleC/backgroundland.jpg" alt="Delicious Pastries" />
        </div>
      </div>
    </div>

    <!-- About Modal -->
    <div id="aboutModal" class="about-modal">
      <div class="modal-content">
        <span class="close-btn">&times;</span>
        <div class="modal-body">
          <div class="modal-left">
            <h2>Mitch Lao</h2>
            <img src="images/MitchLao.jpg" alt="Mitch Lao with cakes" />
          </div>
          <div class="modal-right">
            <h3 class="modal-tagline">crafting joy, one pastry at a time</h3>
            <p>
              At Mitch Pastries, what began as a mom's love for baking and
              designing cakes for her kids blossomed into a passion for creating
              delicious treats for everyone. From custom cakes to indulgent
              desserts, each creation is made with care, creativity, and the
              finest ingredients to make your celebrations unforgettable.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
      <div class="footer-content">
        <p>&copy; 2025 Mitch's Pastries. All rights reserved.</p>
        <p>Designed by Fernandez, Tatel, and Tenorio</p>
      </div>
    </footer>

    <!-- JavaScript -->
    <script>
      // Product Modal
      function updateProductDetails(name, price, description, image) {
        document.getElementById("modal-product-name").textContent = name;
        document.getElementById("modal-product-price").textContent = price;
        document.getElementById("modal-product-description").textContent = description;
        document.getElementById("modal-product-image").src = image;
        document.getElementById("product-modal").style.display = "flex";
      }

      function closeModal() {
        document.getElementById("product-modal").style.display = "none";
      }

      function addToCart() {
        window.location.href = "loading/index.php?target=catalogue/index.php";
      }

      window.addEventListener("click", (event) => {
        const productModal = document.getElementById("product-modal");
        const aboutModal = document.getElementById("aboutModal");

        if (event.target === productModal) {
          closeModal();
        }

        if (event.target === aboutModal) {
          aboutModal.style.display = "none";
        }
      });

      // About Modal
      const aboutModal = document.getElementById("aboutModal");
      const learnBtn = document.querySelector(".btn-learn-more");
      const closeAbout = document.querySelector(".close-btn");

      learnBtn.addEventListener("click", (e) => {
        e.preventDefault();
        aboutModal.style.display = "flex";
      });

      closeAbout.addEventListener("click", () => {
        aboutModal.style.display = "none";
      });
    </script>
  </body>
</html>
