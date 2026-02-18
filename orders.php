<?php
include "admin/db.php"; 

if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('Please log-in to access your orders.');
        window.location.href='login.php';
    </script>";
    exit;
}
include("header.php");
$uid = $_SESSION['user_id'];

$orders = mysqli_query($db,"
    SELECT orders.*, COUNT(order_item.id) AS total_items
    FROM orders
    JOIN order_item ON orders.order_id = order_item.order_id
    WHERE orders.user_id = '$uid'
    GROUP BY orders.order_id
    ORDER BY orders.order_id DESC
") or die("Selection error".mysqli_error($db));
?>

<head>
    <title>My Orders | GG TECH</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="minimal-bg d-flex flex-column min-vh-100">

<main class="flex-fill py-5">
    <div class="container">
        
        <div class="mb-5">
            <h2 class="fw-800 text-dark mb-1">Order History</h2>
            <p class="text-muted">Track and manage your recent tech purchases.</p>
        </div>

        <?php if (mysqli_num_rows($orders) == 0): ?>
            <div class="text-center py-5 bg-white rounded-24 border">
                <i class="fas fa-box-open mb-3 opacity-20" style="font-size: 3rem;"></i>
                <h4 class="fw-600">No orders found</h4>
                <p class="text-muted">You haven't placed any orders yet.</p>
                <a href="index.php" class="btn btn-primary-minimal mt-2">Browse Products</a>
            </div>
        <?php else: ?>
            
            <div class="row">
                <div class="col-12">
                    <?php while($order = mysqli_fetch_array($orders)): ?>
                        <div class="order-card mb-4 shadow-sm border">
                            <div class="order-header d-flex flex-wrap justify-content-between align-items-center">
                                <div>
                                    <span class="info-label">Order ID</span>
                                    <h6 class="fw-700 mb-0">#GG-<?php echo str_pad($order['order_id'], 5, "0", STR_PAD_LEFT); ?></h6>
                                </div>
                                <div class="mt-2 mt-md-0">
                                    <span class="status-badge <?php echo strtolower($order['status']); ?>">
                                        <?php echo $order['status']; ?>
                                    </span>
                                </div>
                            </div>

                            <div class="order-body py-4">
                                <div class="row gy-3">
                                    <div class="col-6 col-md-3">
                                        <span class="info-label">Items</span>
                                        <p class="info-value"><?php echo $order['total_items']; ?> Products</p>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <span class="info-label">Total Amount</span>
                                        <p class="info-value text-dark">₹<?php echo number_format($order['total_amount'], 0); ?></p>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <span class="info-label">Payment</span>
                                        <p class="info-value"><?php echo $order['payment_method']; ?></p>
                                    </div>
                                    <div class="col-12 col-md-3 text-md-end">
                                        <div class="d-flex d-md-block gap-2 mt-2 mt-md-0">
                                            <a href="user_order_items.php?item=<?php echo $order['order_id']; ?>" class="btn btn-action w-100 mb-md-2">
                                                View Items
                                            </a>
                                            <?php if ($order['status'] == 'Delivered'): ?>
                                                <a href="invoice.php?bill=<?php echo $order['order_id']; ?>" class="btn btn-invoice w-100">
                                                    <i class="fas fa-file-invoice me-1"></i> Invoice
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

        <?php endif; ?>

    </div>
</main>

<style>
body {
    filter: brightness(96%);
}
    :root {
        --bg-page: #fdfdfd;
        --accent: #5e72e4;
        --text-main: #1e293b;
        --text-muted: #64748b;
    }

    body.minimal-bg {
        background-color: var(--bg-page);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .fw-700 { font-weight: 700; }
    .fw-800 { font-weight: 800; }

    /* Order Card Style */
    .order-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #f1f5f9 !important;
        transition: transform 0.2s ease;
    }

    .order-header {
        background: #f8fafc;
        padding: 15px 25px;
        border-bottom: 1px solid #f1f5f9;
    }

    .order-body {
        padding: 20px 25px;
    }

    .info-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        font-weight: 700;
        color: var(--text-muted);
        letter-spacing: 0.05em;
        display: block;
        margin-bottom: 4px;
    }

    .info-value {
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 0;
    }

    /* Status Badges */
    .status-badge {
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .status-badge.delivered { background: #dcfce7; color: #166534; }
    .status-badge.pending { background: #fff7ed; color: #9a3412; }
    .status-badge.cancelled { background: #fee2e2; color: #991b1b; }

    /* Action Buttons */
    .btn-action {
        background: #f1f5f9;
        color: var(--text-main);
        font-size: 0.85rem;
        font-weight: 700;
        border: none;
        padding: 10px 15px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.2s;
        text-align: center;
    }
    .btn-action:hover { background: #e2e8f0; color: #000; }

    .btn-invoice {
        background: #fff;
        color: var(--accent);
        border: 1.5px solid var(--accent);
        font-size: 0.85rem;
        font-weight: 700;
        padding: 8px 15px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.2s;
        text-align: center;
    }
    .btn-invoice:hover { background: var(--accent); color: #fff; }

    .btn-primary-minimal {
        background: var(--text-main);
        color: #fff;
        padding: 12px 25px;
        border-radius: 12px;
        font-weight: 700;
        text-decoration: none;
    }

    .rounded-24 { border-radius: 24px; }
    .opacity-20 { opacity: 0.2; }

.order-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid #000 !important;
    transition: transform 0.2s ease;
}


.order-card {
    border: 1px solid rgba(0,0,0,0.1) !important;
    transition: 0.3s ease;
}

.order-card:hover {
    border-color: #000 !important;
    transform: translateY(-3px);
}

</style>

<?php include("footer.php"); ?>
</body>