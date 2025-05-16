<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Checkout Summary</title>
    <link rel="stylesheet" href="navbar.css" />
    <link rel="stylesheet" href="checkoutDiv.css"/>
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: white;
      }
      .quantity-input {
        width: 50px;
        text-align: center;
      }
      .remove-btn {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
      }
      .remove-btn:hover {
        background-color: #c82333;
      }
      .empty-cart-message {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
        }
      /* Modal Styles */
      .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
      }

      .modal-content {
        background-color: white;
        margin: 15% auto;
        padding: 20px;
        border-radius: 8px;
        width: 80%;
        max-width: 500px;
        text-align: center;
        position: relative;
      }

      .close-modal {
        position: absolute;
        right: 10px;
        top: 10px;
        font-size: 24px;
        cursor: pointer;
      }

      .modal-content button {
        background-color: var(--primary);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 20px;
      }

      .modal-content button:hover {
        background-color: var(--primary-dark);
      }
    </style>
  </head>
  <body>
    <section class="navigation-bar">
      <div class="top-navbar">
        <div class="nav-section">
          <p class="section-title">MAIN</p>
          <a href="../../index.php">Home</a>
          <a href="../Catalogue/index.php">Catalogue</a>
          <a href="../Checkout page/index.php">Cart</a>
        </div>

        <div class="nav-section">
          <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
            <div class="user-account" style="display: flex; align-items: center; gap: 15px;">
              <span class="user-name" style="color: #f9f9f9; font-size: 14px;">Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?></span>
              <a href="../../authorization/logout.php" class="logout-btn" style="color: #f9f9f9; text-decoration: none; font-size: 14px; padding: 8px 12px; border-radius: 6px; background-color: #c97b63; transition: background 0.2s ease;">Logout</a>
            </div>
          <?php else: ?>
            <a href="../../authorization/index.php" class="sign-in-btn" style="color: #f9f9f9; text-decoration: none; font-size: 14px; padding: 8px 12px; border-radius: 6px; transition: background 0.2s ease;">Sign In</a>
            <a href="../../authorization/index.php" class="sign-up-btn" style="color: #f9f9f9; text-decoration: none; font-size: 14px; padding: 8px 12px; border-radius: 6px; transition: background 0.2s ease;">Sign Up</a>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <section class="checkout-container">
      <div class="container">
        <!-- Left side: Checkout Summary -->
        <div class="section1">
          <h1 class="checkout-summary">Checkout Summary</h1>
          <h2 class="left-align">Order Details</h2>
          <table id="cart-table">
            <thead>
              <tr>
                <th>Product</th>
                <th>Price (₱)</th>
                <th>Quantity</th>
                <th>Total (₱)</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="cart-items">
              <!-- Cart items will be loaded here dynamically -->
            </tbody>
          </table>
    
          <div class="summary">
            <p><strong>Total Price:</strong> ₱<span id="total-price">0.00</span></p>
            <p><strong>Discount (5%):</strong> ₱<span id="discount">0.00</span></p>
            <p><strong>Final Price:</strong> ₱<span id="final-price">0.00</span></p>
          </div>
    
          <div class="place-another-bttn">
            <a href="../Catalogue/index.php"><button>Place another Order</button></a>
          </div>
        </div>
    
        <!-- Right side: Customer Info Form -->
        <div class="section2">
          <form id="order-form" style="width: 100%;">
            <h2 class="left-align">Customer Information</h2>
    
            <label for="name" style="display: block; margin-top: 15px; color: #333;">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user_name); ?>" required style="width: 100%; padding: 12px; margin-top: 8px; border-radius: 6px; border: 1px solid #ccc; box-sizing: border-box;">
    
            <label for="email" style="display: block; margin-top: 15px; color: #333;">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_email); ?>" required style="width: 100%; padding: 12px; margin-top: 8px; border-radius: 6px; border: 1px solid #ccc; box-sizing: border-box;">
    
            <label for="address" style="display: block; margin-top: 15px; color: #333;">Address:</label>
            <input type="text" id="address" name="address" required style="width: 100%; padding: 12px; margin-top: 8px; border-radius: 6px; border: 1px solid #ccc; box-sizing: border-box;">
    
            <label for="cellphone" style="display: block; margin-top: 15px; color: #333;">Cellphone Number:</label>
            <input type="tel" id="cellphone" name="cellphone" required pattern="(\+?\d{1,4}[\s\-]?)?(\(?\d{2,3}\)?[\s\-]?)?[\d\s\-]{7,10}" title="Please enter a valid phone number" style="width: 100%; padding: 12px; margin-top: 8px; border-radius: 6px; border: 1px solid #ccc; box-sizing: border-box;">
    
            <label for="socialmedia" style="display: block; margin-top: 15px; color: #333;">Social Media Account (Optional):</label>
            <input type="text" id="socialmedia" name="socialmedia" style="width: 100%; padding: 12px; margin-top: 8px; border-radius: 6px; border: 1px solid #ccc; box-sizing: border-box;">
    
            <input type="submit" value="Submit Order" style="margin-top: 20px; width: 100%; padding: 12px; background-color: #6a2314; color: white; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; transition: 0.3s;">
          </form>
        </div>
      </div>
    </section>

    <!-- Success Modal -->
    <div id="successModal" class="modal" style="display: none;">
      <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Order Successful!</h2>
        <p id="successMessage"></p>
        <button onclick="window.location.href='../homepage/index.html'">Return to Home</button>
      </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Debugging point 1
        console.log('DOM fully loaded');
        
        // Fetch and display cart items immediately
        updateCartDisplay();
        
        setInterval(updateCartDisplay, 2000);

        // Handle form submission
        const orderForm = document.getElementById('order-form');
        orderForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            try {
                const formData = new FormData(orderForm);
                
                // Add cart items to form data
                const cartItems = document.querySelectorAll('#cart-items tr');
                if (cartItems.length === 0 || (cartItems.length === 1 && cartItems[0].querySelector('.empty-cart-message'))) {
                    alert('Your cart is empty. Please add items before placing an order.');
                    return;
                }
                
                const response = await fetch('submit_order.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                console.log('Server response:', result);
                
                if (result.success === true) {
                    // Show success modal
                    const modal = document.getElementById('successModal');
                    const message = document.getElementById('successMessage');
                    message.textContent = result.message || 'Order placed successfully! Thank you for your order.';
                    modal.style.display = 'block';
                    
                    // Clear the form
                    orderForm.reset();
                    
                    // Update cart display
                    updateCartDisplay();
                } else {
                    alert('Error: ' + (result.message || 'Failed to place order'));
                }
            } catch (error) {
                console.error('Error submitting order:', error);
                alert('Failed to submit order. Please try again.');
            }
        });

        // Close modal when clicking the X
        document.querySelector('.close-modal').addEventListener('click', function() {
            document.getElementById('successModal').style.display = 'none';
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('successModal');
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    });

    async function updateCartDisplay() {
        try {
            // Debugging point 2
            console.log('Fetching cart items...');
            
            const response = await fetch('fetch_cart.php');
            const data = await response.json();
            
            // Debugging point 3
            console.log('Received data:', data);
            
            const cartTable = document.getElementById('cart-items');
            
            if (!cartTable) {
                console.error('Cart table element not found!');
                return;
            }
            
            if (!data || data.length === 0 || data.error) {
                cartTable.innerHTML = '<tr><td colspan="5" class="empty-cart-message">Your cart is empty</td></tr>';
                updateTotals(0);
                return;
            }
            
            let html = '';
            let totalPrice = 0;
            
            data.forEach(item => {
                const itemTotal = parseFloat(item.price) * parseInt(item.quantity);
                totalPrice += itemTotal;
                
                html += `
                    <tr>
                        <td>${item.product_name}</td>
                        <td>₱${parseFloat(item.price).toFixed(2)}</td>
                        <td>
                            <input type="number" class="quantity-input" 
                                   value="${item.quantity}" min="1" 
                                   data-id="${item.id}"
                                   onchange="updateQuantity(this)">
                        </td>
                        <td>₱${itemTotal.toFixed(2)}</td>
                        <td>
                            <button class="remove-btn" 
                                    onclick="removeItem(${item.id})">Remove</button>
                        </td>
                    </tr>
                `;
            });
            
            cartTable.innerHTML = html;
            updateTotals(totalPrice);
            
            // Debugging point 4
            console.log('Cart updated successfully');
            
        } catch (error) {
            console.error('Error updating cart:', error);
            const cartTable = document.getElementById('cart-items');
            if (cartTable) {
                cartTable.innerHTML = '<tr><td colspan="5" class="empty-cart-message">Error loading cart. Please refresh.</td></tr>';
            }
        }
    }

    function updateTotals(totalPrice) {
        const discount = totalPrice * 0.05;
        const finalPrice = totalPrice - discount;
        
        document.getElementById('total-price').textContent = totalPrice.toFixed(2);
        document.getElementById('discount').textContent = discount.toFixed(2);
        document.getElementById('final-price').textContent = finalPrice.toFixed(2);
    }

    async function updateQuantity(input) {
        const id = input.dataset.id;
        const quantity = input.value;
        
        try {
            const response = await fetch('update.cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${id}&quantity=${quantity}`
            });
            
            const result = await response.text();
            console.log('Update response:', result);
            
            // Immediately update the display after quantity change
            updateCartDisplay();
        } catch (error) {
            console.error('Error updating quantity:', error);
            alert('Failed to update quantity. Please try again.');
        }
    }

    async function removeItem(id) {
        if (!confirm('Are you sure you want to remove this item?')) return;
        
        try {
            const response = await fetch('remove_from_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${id}`
            });
            
            const result = await response.text();
            console.log('Remove response:', result);
            
            // Immediately update the display after removal
            updateCartDisplay();
        } catch (error) {
            console.error('Error removing item:', error);
            alert('Failed to remove item. Please try again.');
        }
    }
    </script>
</body>
</html>
