let orders = [];
let currentOrderIndex = null;

async function fetchOrders() {
    try {
        const response = await fetch('fetch_orders.php');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        console.log("Received data:", data);
        
        if (!data || (!data.active_orders && !data.completed_orders)) {
            throw new Error("No orders found");
        }
        
        // Update both tables
        updateOrdersTable('active-orders-table', data.active_orders || []);
        updateOrdersTable('completed-orders-table', data.completed_orders || []);
    } catch (error) {
        console.error('Error fetching orders:', error);
        // Show error message in both tables
        const tables = ['active-orders-table', 'completed-orders-table'];
        tables.forEach(tableId => {
            const tableBody = document.querySelector(`#${tableId} tbody`);
            if (tableBody) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="error-message">
                            Error loading orders: ${error.message}
                        </td>
                    </tr>
                `;
            }
        });
    }
}

function updateOrdersTable(tableId, orders) {
    const tableBody = document.querySelector(`#${tableId} tbody`);
    if (!tableBody) return;

    if (orders.length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="5" class="no-orders">No orders found</td>
            </tr>
        `;
        return;
    }

    tableBody.innerHTML = orders.map(order => {
        const status = tableId === 'completed-orders-table' ? 'Completed' : (order.status || 'Pending');
        return `
        <tr>
            <td>${order.id}</td>
            <td>${order.customer_name}</td>
            <td>${order.address}</td>
            <td>
                <span class="status-badge ${status.toLowerCase()}">
                    ${status}
                </span>
            </td>
            <td>
                <button class="btn btn-primary btn-sm view-order-btn" onclick="showOrder(${order.id})">View Order</button>
                <button class="btn btn-danger btn-sm remove-order-btn" onclick="deleteOrder(${order.id})">Remove</button>
            </td>
        </tr>
        `;
    }).join('');
}

function createOrderRow(order) {
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>${order.customer_name}</td>
        <td>${order.address}</td>
        <td>
            <span class="status-badge ${order.status.toLowerCase()}">${order.status}</span>
        </td>
        <td>
            <button class="view-btn" onclick="showOrder(${order.id})">View</button>
            <button class="delete-btn" onclick="deleteOrder(${order.id})">Delete</button>
        </td>
    `;
    return row;
}

function createCompletedOrderRow(order) {
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>${order.customer_name}</td>
        <td>${order.address}</td>
        <td>${formatDate(order.completed_at)}</td>
        <td>
            <button class="view-btn" onclick="showOrder(${order.id})">View</button>
            <button class="delete-btn" onclick="deleteOrder(${order.id})">Delete</button>
        </td>
    `;
    return row;
}

function showOrder(orderId) {
    // Create modal if it doesn't exist
    if (!document.getElementById('orderModal')) {
        const modal = document.createElement('div');
        modal.id = 'orderModal';
        modal.className = 'modal';
        modal.innerHTML = `
            <div class="modal-content">
                <span class="close-modal">&times;</span>
                <div class="order-info"></div>
            </div>
        `;
        document.body.appendChild(modal);

        // Create overlay if it doesn't exist
        if (!document.getElementById('overlay')) {
            const overlay = document.createElement('div');
            overlay.id = 'overlay';
            overlay.className = 'overlay';
            document.body.appendChild(overlay);
        }

        // Add event listeners for closing modal
        const closeBtn = modal.querySelector('.close-modal');
        closeBtn.onclick = function() {
            modal.style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
            document.body.style.overflow = 'auto';
        };

        window.onclick = function(event) {
            if (event.target === modal || event.target === document.getElementById('overlay')) {
                modal.style.display = 'none';
                document.getElementById('overlay').style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        };
    }

    const modal = document.getElementById('orderModal');
    const overlay = document.getElementById('overlay');
    const orderInfo = modal.querySelector('.order-info');

    // Show modal and overlay
    modal.style.display = 'block';
    overlay.style.display = 'block';
    document.body.style.overflow = 'hidden';

    // Fetch order details
    fetch(`fetch_order_details.php?id=${orderId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                orderInfo.innerHTML = `<p class="error">${data.error}</p>`;
                return;
            }

            let statusControls = '';
            if (!data.completed_at) {
                statusControls = `
                    <div class="status-controls">
                        <button onclick="updateOrderStatus(${data.id}, 'Pending')" 
                                class="btn-status ${data.status === 'Pending' ? 'active' : ''}">Pending</button>
                        <button onclick="updateOrderStatus(${data.id}, 'Processing')" 
                                class="btn-status ${data.status === 'Processing' ? 'active' : ''}">Processing</button>
                        <button onclick="updateOrderStatus(${data.id}, 'Paid')" 
                                class="btn-status ${data.status === 'Paid' ? 'active' : ''}">Paid</button>
                        <button onclick="updateOrderStatus(${data.id}, 'Completed')" 
                                class="btn-status ${data.status === 'Completed' ? 'active' : ''}">Complete</button>
                    </div>
                `;
            }

            let itemsHtml = '';
            if (data.items && data.items.length > 0) {
                itemsHtml = `
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${data.items.map(item => `
                                <tr>
                                    <td>${item.product_name || 'N/A'}</td>
                                    <td>₱${parseFloat(item.price).toFixed(2)}</td>
                                    <td>${item.quantity}</td>
                                    <td>₱${(parseFloat(item.price) * item.quantity).toFixed(2)}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                `;
            }

            orderInfo.innerHTML = `
                <h2>Order #${data.id}</h2>
                <div class="customer-details">
                    <p><strong>Customer:</strong> ${data.customer_name}</p>
                    <p><strong>Address:</strong> ${data.address}</p>
                    <p><strong>Phone:</strong> ${data.phone || 'N/A'}</p>
                    <p><strong>Social Media:</strong> ${data.social_media || 'N/A'}</p>
                    <p><strong>Status:</strong> ${data.status}</p>
                    ${data.completed_at ? `<p><strong>Completed:</strong> ${formatDate(data.completed_at)}</p>` : ''}
                </div>
                ${itemsHtml}
                <div class="order-total">
                    <p><strong>Subtotal:</strong> ₱${parseFloat(data.total_price).toFixed(2)}</p>
                    <p><strong>Discount:</strong> ₱${parseFloat(data.discount).toFixed(2)}</p>
                    <p><strong>Total:</strong> ₱${parseFloat(data.final_price).toFixed(2)}</p>
                </div>
                ${statusControls}
            `;
        })
        .catch(error => {
            orderInfo.innerHTML = `<p class="error">Error loading order details: ${error.message}</p>`;
        });
}

async function updateOrderStatus(orderId, newStatus) {
    if (newStatus === 'Completed') {
        if (!confirm('Are you sure you want to mark this order as completed? This will move it to the completed orders section.')) {
            return;
        }
    }

    try {
        const response = await fetch('update_order_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `order_id=${orderId}&status=${newStatus}`
        });

        if (!response.ok) throw new Error('Status update failed');

        // Refresh the orders to show updated status
        await fetchOrders();
        
        // Close the panel
        hideOrder();
        
    } catch (error) {
        console.error('Error updating status:', error);
        alert('Failed to update status. Please try again.');
    }
}

function hideOrder() {
    document.getElementById("orderPanel").classList.remove("active");
    document.getElementById("overlay").classList.remove("active");
    document.body.style.overflow = "auto";
}

async function deleteOrder(orderId) {
    if (!confirm('Are you sure you want to delete this order? This action cannot be undone.')) {
        return;
    }

    try {
        console.log('Attempting to delete order:', orderId); // Debug log

        const formData = new FormData();
        formData.append('order_id', orderId);

        console.log('Sending delete request for order ID:', orderId); // Debug log

        const response = await fetch('delete_order.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();
        console.log('Delete response:', data); // Debug log
        
        if (data.error) {
            throw new Error(data.error);
        }

        if (data.success) {
            // Close modal if it's open
            const modal = document.getElementById('orderModal');
            if (modal) {
                modal.style.display = 'none';
                document.getElementById('overlay').style.display = 'none';
                document.body.style.overflow = 'auto';
            }
            
            // Refresh the orders
            await fetchOrders();
            
            // Show success message
            alert('Order deleted successfully');
        } else {
            throw new Error('Failed to delete order');
        }
        
    } catch (error) {
        console.error('Error deleting order:', error);
        alert('Failed to delete order: ' + error.message);
    }
}

function formatDate(dateString) {
    if (!dateString) return 'N/A';
    const date = new Date(dateString);
    return date.toLocaleString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', () => {
    fetchOrders();
    
    // Set up auto-refresh every 30 seconds
    setInterval(fetchOrders, 30000);
    
    // Improved event listeners
    document.getElementById("overlay").addEventListener("click", hideOrder);
    document.getElementById("orderPanel").addEventListener("click", function(e) {
        e.stopPropagation();
    });
});