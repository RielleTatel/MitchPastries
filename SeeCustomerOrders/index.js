let orders = [];
let currentOrderIndex = null;

async function fetchOrders() {
    try {
        console.log('Fetching orders...');
        const response = await fetch('fetch_orders.php');
        const data = await response.json();
        console.log('Received data:', data);
        
        if (data.error) {
            console.error('Error fetching orders:', data.error);
            return;
        }

        console.log('Active orders:', data.active_orders);
        console.log('Completed orders:', data.completed_orders);

        updateOrdersTable('active-orders-table', data.active_orders);
        updateOrdersTable('completed-orders-table', data.completed_orders);
    } catch (error) {
        console.error('Error:', error);
    }
}

function updateOrdersTable(tableId, orders) {
    console.log(`Updating table ${tableId} with orders:`, orders);
    const table = document.getElementById(tableId);
    const tbody = table.querySelector('tbody');
    tbody.innerHTML = '';

    if (!orders || orders.length === 0) {
        const row = document.createElement('tr');
        row.innerHTML = `<td colspan="6" class="loading-message">No orders found</td>`;
        tbody.appendChild(row);
        return;
    }

    orders.forEach(order => {
        console.log('Processing order:', order);
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${order.id || order.order_id}</td>
            <td>${order.customer_name}</td>
            <td>${order.address}</td>
            <td><span class="status-badge ${(order.status || 'Complete').toLowerCase().replace(' ', '-')}">${order.status || 'Complete'}</span></td>
            <td>
                <div class="action-buttons">
                    <button class="view-btn view-order-btn" data-id="${order.id || order.order_id}">View Order</button>
                </div>
            </td>
            <td>
                <button class="delete-btn icon-btn delete-order-btn" data-id="${order.id || order.order_id}" title="Delete Order">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });

    // Attach event listeners for view and delete buttons
    tbody.querySelectorAll('.view-order-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            viewOrder(this.getAttribute('data-id'));
        });
    });
    tbody.querySelectorAll('.delete-order-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            deleteOrder(this.getAttribute('data-id'));
        });
    });
}

async function viewOrder(orderId) {
    try {
        const response = await fetch(`fetch_order_details.php?id=${orderId}`);
        const order = await response.json();

        if (order.error) {
            console.error('Error fetching order details:', order.error);
            return;
        }

        // Create modal if it doesn't exist
        let modal = document.getElementById('orderModal');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'orderModal';
            modal.className = 'modal';
            modal.innerHTML = `
                <div class="modal-content">
                    <span class="close-modal" id="closeOrderModal">&times;</span>
                    <div class="order-info"></div>
                </div>
            `;
            document.body.appendChild(modal);
        }

        // Detect if this is a completed order (has completed_at)
        const isCompleted = !!order.completed_at;

        // Status controls (only for active orders)
        let statusControls = '';
        if (!isCompleted) {
            const statusOptions = [
                { value: 'Pending', label: 'Pending', color: '#ffc107', text: '#856404' },
                { value: 'In Progress', label: 'In Progress', color: '#28a745', text: '#fff' },
                { value: 'Complete', label: 'Complete', color: '#218838', text: '#fff' }
            ];
            statusControls = `<div class="status-controls" style="margin: 1rem 0;">`;
            statusOptions.forEach(opt => {
                statusControls += `<button class="status-btn" data-status="${opt.value}" style="background:${opt.color};color:${opt.text};margin-right:8px;${order.status===opt.value?'font-weight:bold;box-shadow:0 0 0 2px #333':''}">${opt.label}</button>`;
            });
            statusControls += `</div>`;
        }

        // Fill in the order details
        const orderInfo = modal.querySelector('.order-info');
        if (isCompleted) {
            // Show all completed_orders fields
            orderInfo.innerHTML = `
                <h2>Completed Order #${order.order_id || order.id}</h2>
                <p><strong>Customer Name:</strong> ${order.customer_name}</p>
                <p><strong>Address:</strong> ${order.address}</p>
                <p><strong>Phone:</strong> ${order.phone}</p>
                <p><strong>Social Media:</strong> ${order.social_media}</p>
                <p><strong>Order Date:</strong> ${order.created_at ? new Date(order.created_at).toLocaleString() : ''}</p>
                <p><strong>Completed At:</strong> ${order.completed_at ? new Date(order.completed_at).toLocaleString() : ''}</p>
                <p><strong>Status:</strong> <span class="status-badge ${order.status ? order.status.toLowerCase().replace(' ', '-') : ''}">${order.status || 'Complete'}</span></p>
                <table class="order-items">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${(order.items && order.items.length > 0) ? order.items.map(item => `
                            <tr>
                                <td>${item.product_name}</td>
                                <td>₱${parseFloat(item.price).toFixed(2)}</td>
                                <td>${item.quantity}</td>
                                <td>₱${(parseFloat(item.price) * item.quantity).toFixed(2)}</td>
                            </tr>
                        `).join('') : '<tr><td colspan="4">No items available</td></tr>'}
                    </tbody>
                </table>
                <div class="order-total">
                    <span>Total Price:</span>
                    <span>₱${parseFloat(order.total_price).toFixed(2)}</span>
                </div>
                ${order.discount > 0 ? `
                    <div class="order-total">
                        <span>Discount:</span>
                        <span>₱${parseFloat(order.discount).toFixed(2)}</span>
                    </div>
                ` : ''}
                <div class="order-total">
                    <span>Final Price:</span>
                    <span>₱${parseFloat(order.final_price).toFixed(2)}</span>
                </div>
            `;
        } else {
            // Active order modal (with status controls)
            orderInfo.innerHTML = `
                <h2>Order #${order.id}</h2>
                <p><strong>Customer Name:</strong> ${order.customer_name}</p>
                <p><strong>Email:</strong> ${order.user_email}</p>
                <p><strong>Address:</strong> ${order.address}</p>
                <p><strong>Phone:</strong> ${order.phone}</p>
                <p><strong>Social Media:</strong> ${order.social_media}</p>
                <p><strong>Order Date:</strong> ${order.created_at ? new Date(order.created_at).toLocaleString() : ''}</p>
                <p><strong>Status:</strong> <span class="status-badge ${order.status.toLowerCase().replace(' ', '-')}">${order.status}</span></p>
                ${statusControls}
                <table class="order-items">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${(order.items && order.items.length > 0) ? order.items.map(item => `
                            <tr>
                                <td>${item.product_name}</td>
                                <td>₱${parseFloat(item.price).toFixed(2)}</td>
                                <td>${item.quantity}</td>
                                <td>₱${(parseFloat(item.price) * item.quantity).toFixed(2)}</td>
                            </tr>
                        `).join('') : '<tr><td colspan="4">No items available</td></tr>'}
                    </tbody>
                </table>
                <div class="order-total">
                    <span>Total Price:</span>
                    <span>₱${parseFloat(order.total_price).toFixed(2)}</span>
                </div>
                ${order.discount > 0 ? `
                    <div class="order-total">
                        <span>Discount:</span>
                        <span>₱${parseFloat(order.discount).toFixed(2)}</span>
                    </div>
                ` : ''}
                <div class="order-total">
                    <span>Final Price:</span>
                    <span>₱${parseFloat(order.final_price).toFixed(2)}</span>
                </div>
            `;
        }

        // Show modal
        modal.style.display = 'block';

        // Status button event listeners (only for active orders)
        if (!isCompleted) {
            modal.querySelectorAll('.status-btn').forEach(btn => {
                btn.onclick = async function() {
                    const newStatus = this.getAttribute('data-status');
                    if (newStatus === order.status) return;
                    try {
                        const res = await fetch('update_order_status.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ order_id: order.id, status: newStatus })
                        });
                        const data = await res.json();
                        if (data.success) {
                            // Close modal and refresh orders
                            modal.style.display = 'none';
                            await fetchOrders();
                        } else {
                            alert('Failed to update status: ' + (data.error || 'Unknown error'));
                        }
                    } catch (error) {
                        console.error('Error updating status:', error);
                        alert('Failed to update status. Please try again.');
                    }
                };
            });
        }

        // Close modal on click
        document.getElementById('closeOrderModal').onclick = function() {
            modal.style.display = 'none';
        };
        // Close modal when clicking outside modal content
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        };
    } catch (error) {
        console.error('Error:', error);
    }
}

function hideOrder() {
    const orderPanel = document.getElementById('orderPanel');
    const overlay = document.getElementById('overlay');
    orderPanel.style.display = 'none';
    overlay.style.display = 'none';
}

async function updateOrderStatus(orderId) {
    const statuses = ['Pending', 'Processing', 'Completed'];
    const currentStatus = document.querySelector(`tr[data-order-id="${orderId}"] .status-badge`).textContent;
    const currentIndex = statuses.indexOf(currentStatus);
    const nextStatus = statuses[(currentIndex + 1) % statuses.length];

    try {
        const response = await fetch('update_order_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                order_id: orderId,
                status: nextStatus
            })
        });

        const data = await response.json();

        if (data.success) {
            // Refresh the orders table
            fetchOrders();
        } else {
            console.error('Error updating order status:', data.error);
        }
    } catch (error) {
        console.error('Error:', error);
    }
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