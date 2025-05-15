<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Customer Orders</title>
    <link rel="stylesheet" href="index.css" />
    <link rel="stylesheet" href="nav.css" />
    <style>
      :root {
        --primary: #4361ee;
        --primary-dark: #3a56d4;
        --secondary: #3f37c9;
        --light: #f8f9fa;
        --dark: #212529;
        --gray: #6c757d;
        --light-gray: #e9ecef;
        --success: #4cc9f0;
        --warning: #f8961e;
        --danger: #f72585;
        --border-radius: 8px;
        --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
      }

      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      }

      body {
        background-color: #f5f7fb;
        color: var(--dark);
        line-height: 1.6;
      }

    .loading-message {
        text-align: center;
        padding: 20px;
        color: #666;
        font-style: italic;
    }
    
    .order-items {
        width: 100%;
        margin: 15px 0;
        border-collapse: collapse;
    }
    
    .order-items th, .order-items td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }
    
    .order-items th {
        background-color: #f5f5f5;
    }
    
    .order-total {
        display: flex;
        justify-content: space-between;
        font-weight: bold;
        margin: 15px 0;
        padding: 10px;
        background-color: #f9f9f9;
        border-radius: 4px;
    }
    
    .status-controls {
        margin-top: 20px;
    }
    
    .btn-status {
        padding: 8px 15px;
        margin-right: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-status.active {
        transform: scale(1.05);
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    
    .btn-pending {
        background-color: #ffc107;
        color: #212529;
    }
    
    .btn-processing {
        background-color: #17a2b8;
        color: white;
    }
    
    .btn-completed {
        background-color: #28a745;
        color: white;
    }
    </style>
  </head>
  <body>
    <!-- Navigation Bar -->
    <section class="navigation-bar">

      <div class="top-navbar">
            <!-- 
        <div class="nav-section">
          <p class="section-title">MAIN</p>
          <a href="../index.php">Home</a>
          <a href="../loading/index.html?target=../catalogue/index.php">Catalogue</a>
          <a href="../Checkout page/index.php">Cart</a>
        </div>

        Navigation Bar -->

        <div class="nav-section">
          <p class="section-title">ADMIN PANEL</p>
          <a href="../loading/index.html?target=../dashboard/index.html">Dashboard</a>
          <a href="../loading/index.html?target=../menu/menu.html">Menu List</a>
          <a href="../SeeCustomerOrders/index.php">Orders</a>
        </div>
      </div>
    </section>

    <div class="container">
      <div class="main-content">
        <div class="card">
          <div class="card-header">
            <h2 class="card-title">Active Orders</h2>
          </div>
          <div class="table-responsive">
            <table class="customers-table" id="active-orders-table">
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Customer Name</th>
                  <th>Address</th>
                  <th>Status</th>
                  <th>Actions</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>
                <!-- Active orders will be loaded here -->
              </tbody>
            </table>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h2 class="card-title">Completed Orders</h2>
          </div>
          <div class="table-responsive">
            <table class="customers-table" id="completed-orders-table">
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Customer Name</th>
                  <th>Address</th>
                  <th>Status</th>
                  <th>Actions</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>
                <!-- Completed orders will be loaded here -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Order Details Panel -->
    <div id="orderPanel" class="order-panel">
      <div class="order-panel-header">
        <h3 class="order-panel-title">Order Details</h3>
        <button class="close-btn" onclick="hideOrder()">&times;</button>
      </div>
      <div id="orderPanelBody" class="order-panel-body">
        <!-- Order details will be loaded here -->
      </div>
    </div>

    <!-- Overlay -->
    <div id="overlay" class="overlay"></div>

    <script src="index.js"></script>
  </body>
</html>
