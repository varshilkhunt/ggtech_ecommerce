<?php
include "admin/db.php"; 

if (!isset($_SESSION['user_id'])) {
 echo "<script>window.location.href='login.php';</script>";
 exit;
}
include("header.php");
if (!isset($_REQUEST['bill'])) {
    die("Invoice ID missing!");
}

$order_id = $_REQUEST['bill'];

/* Fetch order details */
$order_q = get($db,"*","orders","WHERE order_id='$order_id'","");
$order = mysqli_fetch_assoc($order_q);

if (!$order) {
    die("Invalid Order!");
}

/* Fetch order items */
$items = mysqli_query($db, "
    SELECT * from orders join order_item on orders.order_id = order_item.order_id
    WHERE order_item.order_id = '$order_id'
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Invoice #<?php echo $order_id; ?> | GG TECH</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
	body {
    filter: brightness(96%);
}
        :root {
            --text-main: #1e293b;
            --text-muted: #64748b;
            --accent: #5e72e4;
        }

        body { 
            background: #f8fafc; 
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-main);
        }

        .invoice-box {
            background: #fff;
            padding: 50px;
            margin: 50px auto;
            max-width: 850px;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            border: 1px solid #000;

        }

        .brand-logo {
            font-weight: 800;
            font-size: 1.8rem;
            letter-spacing: -1px;
            margin-bottom: 5px;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 60px;
        }

        .info-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--text-muted);
            letter-spacing: 0.05em;
            margin-bottom: 5px;
            display: block;
        }

        .info-value {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 0;
        }

        /* Modern Table Style */
        .items-table {
            width: 100%;
            margin-bottom: 40px;
        }

        .items-table th {
            border-bottom: 2px solid #f1f5f9;
            padding: 15px 10px;
            font-size: 0.8rem;
            text-transform: uppercase;
            color: var(--text-muted);
            font-weight: 700;
        }

        .items-table td {
            padding: 20px 10px;
            border-bottom: 1px solid #f8fafc;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .total-section {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            margin-top: 30px;
        }

        .total-row {
            display: flex;
            gap: 40px;
            padding: 10px 0;
        }

        .grand-total {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .btn-print {
            background: var(--text-main);
            color: #fff;
            border: none;
            padding: 12px 25px;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .btn-print:hover {
            background: #000;
            transform: translateY(-2px);
            color: #fff;
        }

        @media print {
    body { 
        background: #fff; 
        margin: 0;
    }

    .invoice-box { 
        margin: 0;
        padding: 30px;
        box-shadow: none;
        max-width: 100%;
        border: 1px solid #000;   /* 🔥 Force border for print */
    }

    .no-print { 
        display: none !important; 
    }
}

		

    </style>
</head>
<body>

<div class="invoice-box">

    <div class="invoice-header">
        <div>
            <div class="brand-logo">GG TECH<span style="color:var(--accent)">.</span></div>
            <p class="text-muted small">Electronic Gadgets & Tech Store</p>
            
            <div class="mt-4">
                <span class="info-label">Invoice Number</span>
                <p class="info-value">#INV-<?php echo str_pad($order_id, 5, "0", STR_PAD_LEFT); ?></p>
            </div>
        </div>

        <div class="text-end">
            <span class="info-label">Shipping Details</span>
            <p class="info-value"><?php echo $order['shipping_name']; ?></p>
            <p class="text-muted small mb-0"><?php echo $order['address']; ?></p>
            <p class="text-muted small"><?php echo $order['contact']; ?></p>

            <div class="mt-4">
                <span class="info-label">Payment Method</span>
                <p class="info-value"><?php echo $order['payment_method']; ?></p>
            </div>
        </div>
    </div>

    <h6 class="fw-800 text-uppercase tracking-wider mb-4" style="font-size: 0.75rem; color: var(--accent);">Order Items</h6>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 50px;">#</th>
                <th>Product Description</th>
                <th class="text-end">Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $total = 0;
            while($row = mysqli_fetch_assoc($items)) {
                echo "<tr>";
                echo "<td class='text-muted'>".str_pad($i++, 2, "0", STR_PAD_LEFT)."</td>";
                echo "<td>".$row['product_name']."</td>";
                echo "<td class='text-end fw-600'>₹".number_format($row['price'], 0)."</td>";
                echo "</tr>";
                $total += $row['price'];
            }
            ?>
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            <span class="text-muted fw-600">Subtotal</span>
            <span class="fw-600">₹<?php echo number_format($total, 0); ?></span>
        </div>
        <div class="total-row">
            <span class="text-muted fw-600">Shipping</span>
            <span class="text-success fw-600">FREE</span>
        </div>
        <div class="total-row mt-3">
            <span class="fw-800" style="font-size: 1rem;">Amount Due</span>
            <span class="grand-total">₹<?php echo number_format($total, 0); ?></span>
        </div>
    </div>

    <div class="mt-5 pt-4 border-top no-print d-flex justify-content-between align-items-center">
        <a href="orders.php" class="text-muted small fw-600 text-decoration-none">
            <i class="fas fa-arrow-left me-1"></i> Back to Orders
        </a>
        <button onclick="window.print()" class="btn btn-print">
            <i class="fas fa-print me-2"></i> Print Invoice
        </button>
    </div>

</div>

</body>
</html>