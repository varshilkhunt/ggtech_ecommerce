<?php
include "db.php";

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("location:index.php");
    exit;
}

include "header.php";

// Fetch orders
$orders = get($db,"*","orders","","");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Orders | GG TECH Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
	body {
    filter: brightness(96%);
}
        :root {
            --accent: #4318ff;
            --bg-light: #f4f7fe;
            --text-main: #1b2559;
            --text-muted: #a3aed0;
            --border-color: #f1f5f9;
        }

        body.admin-bg {
            background-color: var(--bg-light);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-main);
            margin: 0;
        }

        .admin-container {
            max-width: 1400px;
            margin: 40px auto;
            padding: 0 30px;
        }

        /* Table Container Fixes */
        .custom-table-container {
            background: #fff;
            border-radius: 24px;
            border: 1px solid rgba(0,0,0,0.03);
            overflow: hidden; /* Clips corners of the table */
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        /* Header Alignment */
        .table thead th {
            background-color: #fafcfe;
            color: var(--text-muted);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 800;
            padding: 20px;
            border-bottom: 2px solid var(--border-color);
            white-space: nowrap;
        }

        /* Body Row Alignment */
        .table tbody td {
            padding: 18px 20px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.85rem;
        }

        /* Specific Column Tuning */
        .col-id { width: 100px; }
        .col-customer { width: 220px; }
        .col-address { min-width: 250px; } /* This column will stretch */
        .col-payment { width: 140px; }
        .col-total { width: 130px; }
        .col-status { width: 220px; }
        .col-action { width: 120px; text-align: right; } /* Anchor to the end */

        .order-id-badge {
            background: #f4f7fe;
            color: var(--accent);
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 800;
            font-size: 0.75rem;
        }

        .customer-name {
            display: block;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 2px;
        }

        .customer-phone {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Improved Address Handling */
        .text-truncate-address {
            max-width: 350px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #4A5568;
        }

        .badge-payment {
            background: #eff6ff;
            color: #3b82f6;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 700;
            display: inline-block;
        }

        .fw-800 { font-weight: 800; }
        .text-accent { color: var(--accent); }

        /* Status Form Layout */
        .status-form {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-select {
            padding: 8px 12px;
            border-radius: 10px;
            border: 1px solid #e0e5f2;
            font-size: 0.8rem;
            font-weight: 600;
            background-color: #fff;
            flex-grow: 1;
            cursor: pointer;
        }

        .btn-update-status {
            background: var(--accent);
            color: white;
            border: none;
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .btn-update-status:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(67, 24, 255, 0.2);
        }

        .btn-view-items {
            color: var(--accent);
            background: #f4f7fe;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-block;
        }

        .btn-view-items:hover {
            background: var(--accent);
            color: white;
        }

        /* Mobile Responsive */
        @media (max-width: 992px) {
            .admin-container { padding: 0 15px; }
            .col-address { min-width: 150px; }
        }
    </style>
</head>

<body class="admin-bg">
<div class="admin-container">
    <div class="table-responsive custom-table-container shadow-sm">
        <table class="table">
            <thead>
                <tr>
                    <th class="col-id">Order ID</th>
                    <th class="col-customer">Customer</th>
                    <th class="col-address">Shipping Address</th>
                    <th class="col-payment">Payment</th>
                    <th class="col-total">Total</th>
                    <th class="col-status">Status Action</th>
                    <th class="col-action">Items</th>
                </tr>
            </thead>
            <tbody>
                <?php while($order = mysqli_fetch_assoc($orders)) { ?>
                <tr>
                    <td class="col-id">
                        <span class="order-id-badge">#<?php echo $order['order_id']; ?></span>
                    </td>
                    <td class="col-customer">
                        <span class="customer-name"><?php echo $order['shipping_name']; ?></span>
                        <span class="customer-phone">
                            <i class="fa-solid fa-phone me-1" style="font-size: 9px;"></i>
                            <?php echo $order['contact']; ?>
                        </span>
                    </td>
                    <td class="col-address">
                        <div class="text-truncate-address" title="<?php echo $order['address']; ?>">
                            <?php echo $order['address']; ?>
                        </div>
                    </td>
                    <td class="col-payment">
                        <span class="badge-payment"><?php echo $order['payment_method']; ?></span>
                    </td>
                    <td class="col-total">
                        <span class="fw-800 text-accent">₹<?php echo number_format($order['total_amount'], 0); ?></span>
                    </td>
                    <td class="col-status">
                        <form method="post" action="update_order_status.php" class="status-form">
                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                            <select name="status" class="status-select">
                                <option value="Pending" <?php if($order['status']=='Pending') echo 'selected'; ?>>Pending</option>
                                <option value="Processing" <?php if($order['status']=='Processing') echo 'selected'; ?>>Processing</option>
                                <option value="Shipped" <?php if($order['status']=='Shipped') echo 'selected'; ?>>Shipped</option>
                                <option value="Delivered" <?php if($order['status']=='Delivered') echo 'selected'; ?>>Delivered</option>
                                <option value="Cancelled" <?php if($order['status']=='Cancelled') echo 'selected'; ?>>Cancelled</option>
                            </select>
                            <button type="submit" class="btn-update-status">
                                <i class="fa-solid fa-check"></i>
                            </button>
                        </form>
                    </td>
                    <td class="col-action">
                        <a class="btn-view-items" href="order_items.php?item=<?php echo $order['order_id']; ?>">
                            <i class="fa-solid fa-eye me-1"></i> View
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>