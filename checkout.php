<?php
include "admin/db.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;   
}
include("header.php");
$uid = $_SESSION['user_id'];
$check = get($db,"*","cart","WHERE uid='$uid'",""); 

if (mysqli_num_rows($check) == 0) {
    header("Location: cart.php");
    exit;
}

$result = mysqli_query($db, "
    SELECT SUM(price) as total 
    FROM cart 
    JOIN products ON cart.pid = products.id 
    WHERE uid='$uid'
");
$row = mysqli_fetch_assoc($result);
$total = $row['total'] ?? 0;

if (isset($_REQUEST['order_now'])) {
    $name = $_POST['shipping_name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $payment = $_POST['payment_method'];
    
    insert($db,"orders",array("user_id"=>"$uid", "shipping_name"=>"$name", "address"=>"$address", "contact"=>"$contact", "payment_method"=>"$payment", "total_amount"=>"$total"));
    
    $order_id = mysqli_insert_id($db);
    $cart_items = mysqli_query($db, "SELECT * FROM cart WHERE uid='$uid'");

    while($item = mysqli_fetch_assoc($cart_items)) {
        $pid = $item['pid'];
        $p = mysqli_query($db, "SELECT * FROM products WHERE id='$pid'");
        $pr = mysqli_fetch_assoc($p);
        $product_name = $pr['p_name'];
        $price = $pr['price'];

        mysqli_query($db, "INSERT INTO order_item SET order_id = '$order_id', pid = '$pid', product_name = '$product_name', price = '$price'") or die(mysqli_error($db));
    }
        
    mysqli_query($db, "DELETE FROM cart WHERE uid='$uid'");

    echo "<script>
      alert('Order Placed Successfully!');
      window.location='index.php';
    </script>";
}
?>

<head>
    <title>Checkout | GG TECH</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="minimal-bg d-flex flex-column min-vh-100">

<main class="flex-fill py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7">
                <div class="checkout-header mb-5">
                    <h2 class="fw-800 text-dark mb-1">Checkout</h2>
                    <p class="text-muted">Fill in your details to finalize your tech upgrade.</p>
                </div>

                <form method="post" class="checkout-form">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <label class="form-label small fw-700 text-uppercase tracking-wider">Full Name</label>
                            <input type="text" name="shipping_name" class="form-control custom-input" placeholder="e.g. John Doe" required>
                        </div>

                        <div class="col-12 mb-4">
                            <label class="form-label small fw-700 text-uppercase tracking-wider">Contact Number</label>
                            <input type="tel" name="contact" class="form-control custom-input" placeholder="+91 XXXXX XXXXX" required>
                        </div>

                        <div class="col-12 mb-4">
                            <label class="form-label small fw-700 text-uppercase tracking-wider">Shipping Address</label>
                            <textarea name="address" class="form-control custom-input" rows="3" placeholder="Street, City, Zip Code" required></textarea>
                        </div>

                        <div class="col-12 mb-5">
                            <label class="form-label small fw-700 text-uppercase tracking-wider d-block mb-3">Payment Method</label>
                            <div class="payment-grid">
                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="Online" required checked>
                                    <div class="option-content">
                                        <i class="fas fa-bolt"></i>
                                        <span>Online</span>
                                    </div>
                                </label>
                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="COD">
                                    <div class="option-content">
                                        <i class="fas fa-truck"></i>
                                        <span>COD</span>
                                    </div>
                                </label>
                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="Card">
                                    <div class="option-content">
                                        <i class="far fa-credit-card"></i>
                                        <span>Card</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="col-12 d-lg-none">
                             <input type="submit" name="order_now" value="Complete Purchase" class="btn btn-checkout w-100 py-3 mb-4">
                        </div>
                    </div>
            </div>

            <div class="col-lg-5">
               <div class="summary-card shadow-sm">
                    <h5 class="fw-700 mb-4">Order Summary</h5>
                    <div class="summary-row">
                        <span>Total Items</span>
                        <span class="text-dark fw-600"><?php echo mysqli_num_rows($check); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping Cost</span>
                        <span class="text-success fw-600">Free</span>
                    </div>
                    <hr class="my-4 opacity-5">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <span class="text-muted fw-600">Total Amount</span>
                        <h3 class="fw-800 mb-0">₹ <?php echo number_format($total, 0); ?></h3>
                    </div>
                    
                    <input type="submit" name="order_now" value="Order Now" class="btn btn-checkout w-100 py-3 d-none d-lg-block">
                    
                    <p class="text-center text-muted small mt-4">
                        <i class="fas fa-shield-alt me-1"></i> Secure Encrypted Checkout
                    </p>
                </div>
            </div>
            </form> </div>
    </div>
</main>

<style>
body {
    filter: brightness(96%);
}
    :root {
        --bg-light: #fdfdfd;
        --input-focus: #5e72e4;
        --text-dark: #1e293b;
    }

    body.minimal-bg {
        background-color: var(--bg-light);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .fw-700 { font-weight: 700; }
    .fw-800 { font-weight: 800; }
    .tracking-wider { letter-spacing: 0.05em; }

    /* Custom Inputs */
    .custom-input {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        transition: all 0.2s ease;
    }

    .custom-input:focus {
        background-color: #fff;
        border-color: var(--input-focus);
        box-shadow: 0 0 0 4px rgba(94, 114, 228, 0.1);
    }

    /* Modern Radio Grid */
    .payment-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }

    .payment-option {
        cursor: pointer;
    }

    .payment-option input {
        display: none;
    }

    .option-content {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .option-content i { font-size: 1.2rem; color: #64748b; }
    .option-content span { font-size: 0.85rem; font-weight: 600; color: #64748b; }

    .payment-option input:checked + .option-content {
        border-color: var(--input-focus);
        background-color: #f5f7ff;
    }

    .payment-option input:checked + .option-content i,
    .payment-option input:checked + .option-content span {
        color: var(--input-focus);
    }

    /* Summary Card */
    .summary-card {
        background: #fff;
        border-radius: 24px;
        padding: 40px;
        position: sticky;
        top: 120px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 0.95rem;
        color: #64748b;
    }

    .btn-checkout {
        background: var(--text-dark);
        color: #fff;
        border-radius: 14px;
        font-weight: 700;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-checkout:hover {
        background: #000;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    @media (max-width: 991px) {
        .summary-card { position: static; padding: 25px; }
    }
	
.summary-card {
    background: #fff;
    border-radius: 24px;
    padding: 40px;
    position: sticky;
    top: 120px;

    border: 1px solid #000;   /* 🔥 Black border added */
}
.checkout-form {
    background: #fff;
    border: 1px solid #000;   /* 🔥 Strong black border */
    border-radius: 24px;
    padding: 35px;
}



</style>

<?php include("footer.php"); ?>
</body>