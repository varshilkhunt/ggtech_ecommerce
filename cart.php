<?php 
include "admin/db.php"; 

if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('Please log-in to access your shopping-bag.');
        window.location.href='login.php';
    </script>";
    exit;
}


if(@$_REQUEST['dl'])
{
    $del=@$_REQUEST['dl'];
    delete($db,"cart","where `cid` = '$del'");
}

$mb=$_SESSION['email'];
$result = get($db,"*","users_registration","where email='$mb'","");
$record = mysqli_fetch_array($result);

if (isset($_POST['add_to_cart'])) {

    $uid = $record['id'];
    $pid = $_POST['product_id'];

    insert($db,"cart",array("pid" => $pid,"uid" => $uid));

    header("Location: cart.php"); 
    exit;
}


$uid=$_SESSION['user_id'];
$cart_p = mysqli_query($db,"select * from cart join products On cart.pid = products.id where uid='$uid' ") or die("Fetch error".mysqli_error($db));
$cart_count = mysqli_num_rows($cart_p);
include("header.php");
?>

<head>
    <title>Your Cart | GG TECH</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="minimal-bg d-flex flex-column min-vh-100">
<main class="flex-fill py-5">
    <div class="container">
        
        <div class="mb-5">
            <h2 class="fw-800 text-dark mb-1">Shopping Bag</h2>
            <p class="text-muted small"><?php echo $cart_count; ?> items ready for checkout</p>
        </div>

        <?php
        $sum = 0;

        if ($cart_count == 0) {
            echo "
            <div class='text-center py-5 bg-white rounded-20 shadow-sm'>
                <i class='fas fa-shopping-bag mb-3 opacity-20' style='font-size: 3rem;'></i>
                <h4 class='fw-600 text-dark'>Your cart is empty</h4>
                <p class='text-muted mb-4'>Looks like you haven't added any tech yet.</p>
                <a href='index.php' class='btn btn-primary-minimal px-4 py-2'>Start Shopping</a>
            </div>";
        } else {
            echo "<div class='row g-4'>";
            
            // Left Side: Cart Items
            echo "<div class='col-lg-8'>";
            while($cart = mysqli_fetch_array($cart_p)){
                $sum += $cart['price'];
                ?>
                <div class="cart-item-card mb-3">
                    <div class="d-flex align-items-center">
                        <div class="cart-img-box">
                            <img src="admin/<?php echo $cart['image']; ?>" alt="product">
                        </div>
                        <div class="flex-grow-1 ms-4">
                            <h6 class="mb-1 fw-700 text-dark"><?php echo $cart['p_name']; ?></h6>
                            <p class="text-muted small mb-2 d-none d-md-block text-truncate" style="max-width: 300px;">
                                <?php echo $cart['description']; ?>
                            </p>
                            <span class="price-tag">₹<?php echo number_format($cart['price'], 0); ?></span>
                        </div>
                        <div class="ms-auto">
                            <a href="cart.php?dl=<?php echo $cart['cid']; ?>" class="btn-remove" title="Remove Item">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
            }
            echo "<a href='index.php' class='btn btn-link text-muted mt-3 p-0' style='text-decoration:none;'><i class='fas fa-arrow-left me-2'></i> Add More Items</a>";
            echo "</div>";

            // Right Side: Summary
            echo "
            <div class='col-lg-4'>
                <div class='summary-card'>
                    <h5 class='fw-700 mb-4'>Order Summary</h5>
                    <div class='d-flex justify-content-between mb-2 text-muted'>
                        <span>Subtotal</span>
                        <span>₹".number_format($sum, 0)."</span>
                    </div>
                    <div class='d-flex justify-content-between mb-4 text-muted'>
                        <span>Shipping</span>
                        <span class='text-success'>Free</span>
                    </div>
                    <hr class='opacity-5'>
                    <div class='d-flex justify-content-between mb-4'>
                        <span class='fw-700'>Total</span>
                        <span class='fw-800 text-dark' style='font-size: 1.3rem;'>₹".number_format($sum, 0)."</span>
                    </div>
                    <a href='checkout.php' class='btn btn-checkout w-100 py-3'>Proceed to Checkout</a>
                </div>
            </div>";
            
            echo "</div>"; // Close row
        }
        ?>

    </div>
</main>

<style>
body {
    filter: brightness(96%);
}
    :root {
        --page-bg: #fdfdfd;
        --tile-bg: #f8f9fc;
        --accent: #5e72e4;
        --text-dark: #1a1d23;
    }

    body.minimal-bg {
        background-color: var(--page-bg);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .fw-700 { font-weight: 700; }
    .fw-800 { font-weight: 800; }

    /* Cart Item Card */
    .cart-item-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #f1f5f9;
        transition: transform 0.2s ease;
    }

    .cart-item-card:hover {
        transform: translateX(5px);
    }

    .cart-img-box {
        width: 100px;
        height: 100px;
        background: var(--tile-bg);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
    }

    .cart-img-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .price-tag {
        font-weight: 700;
        color: var(--accent);
        font-size: 1.1rem;
    }

    .btn-remove {
        color: #cbd5e1;
        font-size: 1.1rem;
        transition: color 0.2s;
        padding: 10px;
    }

    .btn-remove:hover {
        color: #f87171;
    }

    /* Summary Card */
    .summary-card {
        background: #fff;
        border-radius: 20px;
        padding: 30px;
        border: 1px solid #f1f5f9;
        position: sticky;
        top: 110px;
    }

    .btn-checkout {
        background: var(--text-dark);
        color: #fff;
        border-radius: 12px;
        font-weight: 700;
        border: none;
        transition: opacity 0.2s;
    }

    .btn-checkout:hover {
        opacity: 0.9;
        color: #fff;
    }

    .btn-primary-minimal {
        background: var(--accent);
        color: #fff;
        border-radius: 10px;
        font-weight: 600;
        border: none;
    }

    .opacity-20 { opacity: 0.2; }
    .rounded-20 { border-radius: 20px; }

    @media (max-width: 768px) {
        .cart-img-box { width: 70px; height: 70px; }
        .cart-item-card { padding: 15px; }
    }
	.cart-item-card {
    background: #fff;
    border-radius: 16px;
    padding: 20px;
    border: 1px solid #000;   /* 🔥 Black border */
    transition: transform 0.2s ease;
}


</style>

<?php include("footer.php"); ?>
</body>