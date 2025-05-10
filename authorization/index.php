<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <script>
          function validateForm(event) {
        const fullname = document.getElementById("fullname").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirm_password").value;
        let errorMessages = [];

        document.getElementById("error-messages").innerHTML = "";

        if (!fullname || !email || !password || !confirmPassword) {
          errorMessages.push("All fields are required.");
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
          errorMessages.push("Please enter a valid email address.");
        }

        if (password.length < 6) {
          errorMessages.push("Password must be at least 6 characters.");
        }

        if (password !== confirmPassword) {
          errorMessages.push("Passwords do not match.");
        }

        if (errorMessages.length > 0) {
          event.preventDefault();
          document.getElementById("error-messages").innerHTML = errorMessages.join("<br>");
          }
        }
    </script>
    <title>Document</title>
  </head>
  <body>
    <div class="container" id="container">
      <div class="form-container sign-up-container">
      <form action="signup_process.php" method="POST" onsubmit="validateForm(event)">
        <h1>Create Account</h1>
          <input type="text" id="fullname" placeholder="Name" name="fullname" required />
          <input type="email" id="email" placeholder="Email" name="email" required />
          <input type="password" id="password" placeholder="Password" name="password" required />
          <input type="password" id="confirm_password" placeholder="Confirm Password" name="confirm_password" required />
          <div id="error-messages" style="color: red; font-size: 14px;"></div>
          <button type="submit" name="submit">Sign Up</button>
        </form>
      </div>
      <div class="form-container sign-in-container">
        <form action="login_process.php" method="POST">
            <h1>Sign in</h1>
            <input type="email" id="email" name="email" placeholder="Email" required />
            <input type="password" id="password" name="password" placeholder="Password" required />
            <button type="submit" name="submit">Sign In</button>
        </form>
      </div>
      <div class="overlay-container">
        <div class="overlay">
          <div class="overlay-panel overlay-left">
            <h1>Welcome Back!</h1>
            <p>
              Indulge in our delicious, freshly baked pastries, crafted with
              care to deliver a perfect blend of flavor and warmth in every
              bite.
            </p>
            <button class="ghost" id="signIn">Sign In</button>
            <?php
                if (isset($_GET['error'])) {
                  if ($_GET['error'] == 'wrongpass') {
                    echo "<p class='error-message'>Wrong password!</p>";
                  } elseif ($_GET['error'] == 'nouser') {
                    echo "<p class='error-message'>No user found with that email!</p>";
                  }
                }
              ?>
          </div>
          <div class="overlay-panel overlay-right">
            <h1>Hello, Customer!</h1>
            <p>
              Treat yourself to our freshly baked pastries, made with love and
              the finest ingredients, offering a delightful taste that’s perfect
              for any occasion.
            </p>
            <button class="ghost" id="signUp">Sign Up</button>
          </div>
        </div>
      </div>
    </div>
    <script>
      const signUpButton = document.getElementById("signUp");
      const signInButton = document.getElementById("signIn");
      const container = document.getElementById("container");

      signUpButton.addEventListener("click", () => {
        container.classList.add("right-panel-active");
      });

      signInButton.addEventListener("click", () => {
        container.classList.remove("right-panel-active");
      });
    </script>
  </body>
</html>

