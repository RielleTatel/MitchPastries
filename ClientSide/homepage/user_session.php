<?php
function displayUserSession() {
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        echo '<div class="user-account">';
        echo '<span class="user-name">Welcome, ' . htmlspecialchars($_SESSION['fullname']) . '</span>';
        echo '<a href="authorization/logout.php" class="logout-btn">Logout</a>';
        echo '</div>';
    } else {
        echo '<a href="authorization/index.php" class="sign-in-btn">Sign In</a>';
        echo '<a href="authorization/index.php" class="sign-up-btn">Sign Up</a>';
    }
}
?> 