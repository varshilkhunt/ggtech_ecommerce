<?php 
include "admin/db.php"; 

if (!isset($_SESSION['user_id'])) {
 echo "<script>window.location.href='login.php';</script>";
 exit;
}
include("header.php");
if(@$_REQUEST['item']){
    $order_item=@$_REQUEST['item'];
    $items= mysqli_query($db,"select * from order_item join products On order_item.pid = products.id where order_id='$order_item'") or die("Selection error".mysqli_error($db));
?>

<head>
    <title>Items in Order #<?php echo $order_item; ?> | GG TECH</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="minimal-bg d-flex flex-column min-vh-100">

<main class="flex-fill py-5">
    <div class="container">
        
        <div class="d-flex align-items-center justify-content-between mb-5">
            <div>
                <h2 class="fw-800 text-dark mb-1">Order Details</h2>
                <p class="text-muted small text-uppercase tracking-wider fw-600">Items for Order #<?php echo str_pad($order_item, 5, "0", STR_PAD_LEFT); ?></p>
            </div>
            <a href="orders.php" class="btn btn-back-minimal">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <?php while($item = mysqli_fetch_array($items)): ?>
                    <div class="item-summary-card mb-3">
                        <div class="d-flex align-items-center">
                            <div class="item-img-container">
                                <img src="admin/<?php echo $item['image']; ?>" alt="product">
                            </div>
                            <div class="ms-4">
                                <span class="text-muted small fw-700 text-uppercase tracking-wider" style="font-size: 0.65rem;">Product</span>
                                <h6 class="fw-700 text-dark mb-1"><?php echo $item['product_name']; ?></h6>
                                <p class="text-accent fw-800 mb-0">₹<?php echo number_format($item['price'], 0); ?></p>
                            </div>
                            <div class="ms-auto d-none d-md-block text-end">
                                <span class="text-muted small d-block">Order Reference</span>
                                <span class="badge-ref">#ID-<?php echo $item['order_id']; ?></span>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="mt-5 text-center">
            <p class="text-muted small">Need help with this order? <a href="inquiry.php" class="text-accent fw-700 text-decoration-none">Contact Support</a></p>
        </div>

    </div>
</main>

<style>
body {
    filter: brightness(96%);
}
    :root {
        --bg-page: #fdfdfd;
        --tile-bg: #f8fafc;
        --accent: #5e72e4;
        --text-main: #1e293b;
        --text-muted: #64748b;
    }

    body.minimal-bg {
        background-color: var(--bg-page);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .fw-600 { font-weight: 600; }
    .fw-700 { font-weight: 700; }
    .fw-800 { font-weight: 800; }
    .text-accent { color: var(--accent); }
    .tracking-wider { letter-spacing: 0.05em; }

    /* Item Card Styling */
    .item-summary-card {
        background: #fff;
        border-radius: 20px;
        padding: 20px;
        border: 1px solid #f1f5f9;
        transition: transform 0.2s ease;
    }

    .item-summary-card:hover {
        transform: scale(1.01);
        border-color: #e2e8f0;
    }

    .item-img-container {
        width: 100px;
        height: 100px;
        background: var(--tile-bg);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
    }

    .item-img-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .badge-ref {
        font-size: 0.75rem;
        background: #f1f5f9;
        color: var(--text-muted);
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 700;
    }

    /* Buttons */
    .btn-back-minimal {
        background: #fff;
        color: var(--text-main);
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 8px 18px;
        font-weight: 700;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .btn-back-minimal:hover {
        background: #f8fafc;
        color: #000;
    }

    @media (max-width: 576px) {
        .item-img-container { width: 70px; height: 70px; }
        .item-summary-card { padding: 15px; }
    }
	
	
	.item-summary-card {
    background: #fff;
    border-radius: 20px;
    padding: 20px;
    border: 1px solid #000;   /* 🔥 Black border */
    transition: transform 0.2s ease;
}

	
	.item-summary-card {
    border: 1px solid rgba(0,0,0,0.1);
    transition: 0.3s ease;
}

.item-summary-card:hover {
    border-color: #000;
    transform: scale(1.01);
}


</style>

<?php 
} // End if REQUEST['item']
include("footer.php"); 
?>
</body>