<?php
include "db.php";

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("location:index.php");
    exit;
}

include "header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Ordered Items | GG TECH Admin</title>
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
            --border: #f1f5f9;
        }

        body.admin-bg {
            background-color: var(--bg-light);
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
        }

        .main-wrapper {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* Header Alignment */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 25px;
            padding: 0 5px;
        }

        .fw-800 { font-weight: 800; }

        /* Table Container */
        .table-container {
            background: #fff;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.03);
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Column Controls */
        .col-id { width: 120px; }
        .col-img { width: 140px; }
        .col-name { text-align: left; } /* This stretches */
        .col-price { width: 150px; text-align: right; } /* Anchored to end */

        .modern-table thead th {
            background: #fafcfe;
            padding: 20px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            font-weight: 800;
            border-bottom: 2px solid var(--border);
        }

        .modern-table tbody td {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            color: var(--text-main);
        }

        .modern-table tr:last-child td { border-bottom: none; }

        /* UI Elements */
        .id-badge {
            background: #f4f7fe;
            color: var(--accent);
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.8rem;
        }

        .product-thumb {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #edf2f7;
            display: block;
        }

        .product-title {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--text-main);
        }

        .price-tag {
            font-weight: 800;
            color: var(--accent);
            font-size: 1rem;
        }

        /* Back Button */
        .back-btn {
            background: #fff;
            color: var(--text-main);
            padding: 10px 18px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            font-size: 0.85rem;
            border: 1px solid #e0e5f2;
            transition: all 0.2s;
        }

        .back-btn:hover {
            background: var(--bg-light);
            color: var(--accent);
            transform: translateX(-4px);
        }
    </style>
</head>

<body class="admin-bg">

<div class="main-wrapper">
    <div class="page-header">
        <div>
            <h2 class="fw-800 text-dark mb-1" style="margin:0;">Order Details</h2>
            <p class="text-muted small" style="margin:0;">Viewing items for Order #<?php echo @$_REQUEST['item']; ?></p>
        </div>
        <a class="back-btn" href="view_orders.php">
            <i class="fa-solid fa-arrow-left me-2"></i> Back to Orders
        </a>
    </div>

    <div class="table-container shadow-sm">
        <table class="modern-table">
            <thead>
                <tr>
                    <th class="col-id">Order ID</th>
                    <th class="col-img">Image</th>
                    <th class="col-name">Product Name</th>
                    <th class="col-price">Unit Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(@$_REQUEST['item']){
                    $order_item = mysqli_real_escape_string($db, $_REQUEST['item']);
                    $query = "SELECT * FROM order_item 
                              JOIN products ON order_item.pid = products.id 
                              WHERE order_id='$order_item'";
                    
                    $items = mysqli_query($db, $query) or die("Selection error".mysqli_error($db));

                    while($item = mysqli_fetch_array($items)) {
                ?>
                    <tr>
                        <td class="col-id">
                            <span class="id-badge">#<?php echo $item['order_id']; ?></span>
                        </td>
                        <td class="col-img">
                            <img class="product-thumb" src="<?php echo $item['image']; ?>" alt="Product">
                        </td>
                        <td class="col-name">
                            <span class="product-title"><?php echo $item['product_name']; ?></span>
                        </td>
                        <td class="col-price">
                            <span class="price-tag">₹<?php echo number_format($item['price'], 2); ?></span>
                        </td>
                    </tr>
                <?php 
                    } 
                } 
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>