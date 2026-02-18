<?php 
include("header.php");

// 1. Setup variables
$user_id = $_SESSION['user_id'] ?? 0; 
$where = [];

// 2. Build the dynamic WHERE clause
if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($db, $_GET['search']);
    $where[] = "p_name LIKE '%$search%'";
}

if (!empty($_GET['category'])) {
    $category = mysqli_real_escape_string($db, $_GET['category']);
    $where[] = "category_id = '$category'";
}

$sql = "SELECT * FROM products";
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$pro = mysqli_query($db, $sql);

/** Helper to check if item is in wishlist */
function is_wishlisted($db, $u_id, $p_id) {
    if (!$u_id) return false;
    $res = mysqli_query($db, "SELECT id FROM wishlist WHERE user_id = $u_id AND product_id = $p_id");
    return mysqli_num_rows($res) > 0;
}
?>

<head>
    <title>GG Tech | Products</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
	body {
    filter: brightness(96%);
}

        :root {
            --page-bg: #fdfdfd;
            --tile-bg: #f8f9fc;
            --text-dark: #1a1d23;
            --text-muted: #8e95a2;
            --accent: #ff4757; /* Heart Red */
        }

        body.minimal-bg {
            background-color: var(--page-bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-dark);
        }

        /* Tile Layout */
        .product-tile {
            background: var(--tile-bg);
            border-radius: 16px;
            overflow: hidden;
            position: relative; /* Needed for absolute wishlist btn */
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        /* Wishlist Button Styling */
        .wishlist-btn {
            position: absolute;
            top: 12px;
            right: 12px;
            z-index: 10;
            background: white;
            border: none;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .wishlist-btn svg {
            width: 18px;
            height: 18px;
            fill: none;
            stroke: #adb5bd;
            stroke-width: 2px;
            transition: all 0.3s ease;
        }

        .wishlist-btn.active svg {
            fill: var(--accent);
            stroke: var(--accent);
        }

        .wishlist-btn:hover {
            transform: scale(1.1);
        }

        .tile-img-box {
            background: #ffffff;
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            transition: transform 0.4s ease;
        }

        .tile-img-box img {
            max-height: 100%;
            object-fit: contain;
        }

        .minimal-link { text-decoration: none !important; color: inherit; }

        /* Hover Effects */
        .product-tile:hover {
            background: #f1f3f9;
            transform: translateY(-4px);
        }

        .tile-info { padding: 16px; }

        .tile-title {
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 8px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .tile-price { font-size: 1.1rem; font-weight: 700; }
        .tile-mrp { font-size: 0.75rem; color: var(--text-muted); text-decoration: line-through; margin-left: 8px; }

        .custom-grid { padding: 5px; }

        @media (max-width: 768px) {
            .tile-img-box { height: 140px; }
        }
		.product-tile {
    background: var(--tile-bg);
    border-radius: 16px;
    overflow: hidden;
    position: relative;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    display: flex;
    flex-direction: column;

    border: 1px solid #000;   /* 🔥 Black border added */
}

    </style>
</head>

<body class="minimal-bg d-flex flex-column min-vh-100">
<main class="flex-fill py-4">
    <div class="container">
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-0 custom-grid">

            <?php 
            if (mysqli_num_rows($pro) == 0) {
                echo "<div class='col-12 text-center py-5'><h4 class='fw-light text-muted'>No products available.</h4></div>";
            }

            while ($product = mysqli_fetch_array($pro)) { 
                $isFav = is_wishlisted($db, $user_id, $product['id']);
            ?>
                <div class="col px-1 mb-2"> 
                    <div class="product-tile">
                        <button class="wishlist-btn <?php echo $isFav ? 'active' : ''; ?>" 
                                data-id="<?php echo $product['id']; ?>"
                                onclick="toggleWishlist(this)">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </button>

                        <a href="product_details.php?id=<?php echo $product['id']; ?>" class="minimal-link">
                            <div class="tile-img-box">
                                <img src="admin/<?php echo $product['image']; ?>" class="img-fluid" alt="img">
                            </div>
                            <div class="tile-info">
                                <h6 class="tile-title"><?php echo $product['p_name']; ?></h6>
                                <div class="tile-price-row">
                                    <span class="tile-price">₹<?php echo number_format($product['price'], 0); ?></span>
                                    <span class="tile-mrp">₹<?php echo number_format($product['mrp'], 0); ?></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</main>
<script>
function toggleWishlist(btn) {

    const productId = btn.getAttribute('data-id');
    const isLoggedIn = <?php echo ($user_id > 0) ? 'true' : 'false'; ?>;

    if (!isLoggedIn) {
        alert('Please login first to manage your wishlist.');
        window.location.href = 'login.php';
        return;
    }

    fetch('toggle_wishlist.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'product_id=' + productId
    })
    .then(res => res.json())
    .then(data => {

        // Toggle heart color
        if(data.status === 'added'){
            btn.classList.add('active');
        } else if(data.status === 'removed'){
            btn.classList.remove('active');
        }

        // 🔥 Update navbar wishlist count
        const wrap = document.querySelector(".cart-wrap");
        let counter = document.getElementById("wishlist-count");

        if(data.count > 0){

            if(!counter){
                counter = document.createElement("span");
                counter.className = "cart-dot";
                counter.id = "wishlist-count";
                wrap.appendChild(counter);
            }

            counter.innerText = data.count;

        } else {
            if(counter){
                counter.remove();
            }
        }

    })
    .catch(err => console.error("Wishlist error:", err));
}
</script>


</body>
<?php include("footer.php"); ?>