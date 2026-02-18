<?php 
include "admin/db.php"; 


include("header.php");
if($_REQUEST['id']){
    $pid=$_REQUEST['id'];
    $pro_detail = get($db,"*","products","where id = $pid","");
    $detail=mysqli_fetch_array($pro_detail);
}

// Calculate discount percentage for a better UI experience
$discount = 0;
if($detail['mrp'] > $detail['price']) {
    $discount = round((($detail['mrp'] - $detail['price']) / $detail['mrp']) * 100);
}
?>

<head>
    <title><?php echo $detail['p_name']; ?> | GG TECH</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="minimal-bg d-flex flex-column min-vh-100">

<main class="flex-fill py-5">
    <div class="container mt-lg-5">
        <div class="row gx-lg-5 align-items-center">

            <div class="col-md-6 mb-4 mb-md-0">
                <div class="product-gallery-box">
                    <?php if($discount > 0): ?>
                        <span class="discount-badge">-<?php echo $discount; ?>%</span>
                    <?php endif; ?>
                    <img src="admin/<?php echo $detail['image']; ?>" 
                         class="img-fluid main-product-img" 
                         alt="<?php echo $detail['p_name']; ?>">
                </div>
            </div>

            <div class="col-md-6">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="index.php" class="text-muted small text-decoration-none">Store</a></li>
                        <li class="breadcrumb-item active small text-dark fw-600" aria-current="page">Details</li>
                    </ol>
                </nav>

                <h1 class="fw-800 text-dark mb-3 display-6"><?php echo $detail['p_name']; ?></h1>
                
                <div class="price-stack mb-4">
                    <div class="d-flex align-items-baseline gap-2">
                        <h2 class="fw-800 text-accent mb-0">₹<?php echo number_format($detail['price'], 0); ?></h2>
                        <?php if($detail['mrp'] > $detail['price']): ?>
                            <span class="text-muted text-decoration-line-through">₹<?php echo number_format($detail['mrp'], 0); ?></span>
                        <?php endif; ?>
                    </div>
                    <p class="text-success small fw-700 mt-1"><i class="fas fa-check-circle me-1"></i> In Stock & Ready to Ship</p>
                </div>

                <div class="description-box mb-5">
                    <h6 class="fw-700 text-uppercase tracking-wider text-muted mb-3" style="font-size: 0.75rem;">Product Overview</h6>
                    <p class="text-secondary leading-relaxed"><?php echo $detail['description']; ?></p>
                </div>

                <form method="post" action="cart.php">
                    <input type="hidden" name="product_id" value="<?php echo $detail['id']; ?>">
                    <div class="d-grid gap-3 d-md-flex">
                        <a href="index.php" class="btn btn-back-store py-3 px-4">
                            <i class="fas fa-arrow-left"></i>
                        </a>

                        <button type="submit" name="add_to_cart" class="btn btn-add-cart py-3 px-5 flex-grow-1">
                            <i class="fas fa-shopping-bag me-2"></i> Add to Cart
                        </button>
                    </div>
                </form>

                <div class="trust-badges mt-5 pt-4 border-top">
                    <div class="row text-center text-md-start">
                        <div class="col-4">
                            <i class="fas fa-shield-alt d-block mb-2 text-muted"></i>
                            <span class="small fw-600">Secure Warranty</span>
                        </div>
                        <div class="col-4">
                            <i class="fas fa-truck d-block mb-2 text-muted"></i>
                            <span class="small fw-600">Fast Delivery</span>
                        </div>
                        <div class="col-4">
                            <i class="fas fa-undo d-block mb-2 text-muted"></i>
                            <span class="small fw-600">7-Day Return</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<style>
body {
    filter: brightness(96%);
}
    :root {
        --bg-light: #fdfdfd;
        --accent: #5e72e4;
        --text-main: #1e293b;
        --tile-bg: #f8fafc;
    }

    body.minimal-bg {
        background-color: var(--bg-light);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .fw-600 { font-weight: 600; }
    .fw-700 { font-weight: 700; }
    .fw-800 { font-weight: 800; }
    .text-accent { color: var(--accent); }
    .leading-relaxed { line-height: 1.7; }

    /* Gallery Styling */
    .product-gallery-box {
        background: var(--tile-bg);
        border-radius: 30px;
        padding: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        min-height: 450px;
    }

    .main-product-img {
        max-height: 400px;
        object-fit: contain;
        transition: transform 0.5s ease;
    }

    .product-gallery-box:hover .main-product-img {
        transform: scale(1.05);
    }

    .discount-badge {
        position: absolute;
        top: 20px;
        left: 20px;
        background: #f87171;
        color: #fff;
        padding: 6px 14px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.8rem;
    }

    /* Buttons */
    .btn-add-cart {
        background: var(--text-main);
        color: #fff;
        border-radius: 16px;
        font-weight: 700;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-add-cart:hover {
        background: #000;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        color: #fff;
    }

    .btn-back-store {
        background: #fff;
        color: var(--text-main);
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-back-store:hover {
        background: #f8fafc;
    }

    .trust-badges i { font-size: 1.2rem; }
    .trust-badges span { font-size: 0.7rem; color: #94a3b8; }

    @media (max-width: 768px) {
        .product-gallery-box { padding: 30px; min-height: 300px; }
        .main-product-img { max-height: 250px; }
    }
.product-gallery-box {
    background: var(--tile-bg);
    border-radius: 30px;
    padding: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    min-height: 450px;

    border: 1px solid #000;  /* 🔥 Add this */
}


</style>

<?php include("footer.php"); ?>
</body>