<?php
include "admin/db.php"; 

if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('Please log-in to access your wishlist.');
        window.location.href='login.php';
    </script>";
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['clear_all'])) {
//$clear_sql = "DELETE FROM wishlist WHERE user_id = $user_id";
if(delete($db,"wishlist","WHERE user_id = $user_id")) {
echo "<script>window.location.href='wishlist.php';</script>";
exit;
}
}

$sql = "SELECT p.* FROM products p
INNER JOIN wishlist w ON p.id = w.product_id
WHERE w.user_id = $user_id";
$pro = mysqli_query($db, $sql);
$count = mysqli_num_rows($pro);
include("header.php");
?>

<head>
<title>My Wishlist | GG Tech</title>
<style>
body {
    filter: brightness(96%);
}
:root {
--page-bg: #fdfdfd;
--tile-bg: #f8f9fc;
--text-dark: #1a1d23;
            --accent-red: #ff4757;
        }
        body.minimal-bg { background-color: var(--page-bg); font-family: 'Plus Jakarta Sans', sans-serif; }
        
        .wishlist-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 30px; 
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .action-btn { 
            padding: 8px 20px; 
            border-radius: 8px; 
            font-size: 0.85rem; 
            font-weight: 600; 
            cursor: pointer; 
            transition: 0.3s; 
            text-decoration: none;
            display: inline-block;
        }

        .btn-clear { background: transparent; border: 1px solid #ddd; color: var(--text-dark); }
        .btn-clear:hover { background: var(--accent-red); color: white; border-color: var(--accent-red); }

        .btn-shop { background: var(--text-dark); border: 1px solid var(--text-dark); color: white !important; }
        .btn-shop:hover { background: transparent; color: var(--text-dark) !important; }

        /* Centering Wrapper */
        .empty-wishlist-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 60vh; /* Adjusts how 'middle' it looks on screen */
            width: 100%;
            text-align: center;
        }

        /* Product Tile Styles */
        .product-tile { background: var(--tile-bg); border-radius: 16px; overflow: hidden; transition: 0.4s ease; height: 100%; display: flex; flex-direction: column; }
        .tile-img-box { background: #ffffff; height: 180px; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .tile-img-box img { max-height: 100%; object-fit: contain; }
        .tile-info { padding: 16px; }
        .tile-title { font-size: 0.9rem; font-weight: 500; margin-bottom: 8px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .tile-price { font-size: 1.1rem; font-weight: 700; }
        .minimal-link { text-decoration: none !important; color: inherit; }
		
.product-tile { 
    background: var(--tile-bg); 
    border-radius: 16px; 
    overflow: hidden; 
    transition: 0.4s ease; 
    height: 100%; 
    display: flex; 
    flex-direction: column; 

    border: 1px solid #000;  /* 🔥 Black border added */
}

    </style>
</head>

<body class="minimal-bg d-flex flex-column min-vh-100">
<main class="flex-fill py-4">
    <div class="container">
        
        <div class="wishlist-header">
            <h3 class="fw-bold m-0">My Wishlist</h3>
            <div class="header-action">
                <?php if ($count > 0): ?>
                    <form method="POST" onsubmit="return confirm('Clear your entire wishlist?');" style="margin:0;">
                        <button type="submit" name="clear_all" class="action-btn btn-clear">Clear Wishlist</button>
                    </form>
                <?php else: ?>
                    <a href="index.php" class="action-btn btn-shop">Continue Shopping</a>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if ($count == 0): ?>
            <div class="empty-wishlist-wrapper">
                <h4 class="fw-light text-muted">Your wishlist is currently empty.</h4>
            </div>
        <?php else: ?>
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-2">
                <?php while ($product = mysqli_fetch_array($pro)): ?>
                    <div class="col mb-2"> 
                        <div class="product-tile">
                            <a href="product_details.php?id=<?php echo $product['id']; ?>" class="minimal-link">
                                <div class="tile-img-box">
                                    <img src="admin/<?php echo $product['image']; ?>" class="img-fluid">
                                </div>
                                <div class="tile-info">
                                    <h6 class="tile-title"><?php echo $product['p_name']; ?></h6>
                                    <span class="tile-price">₹<?php echo number_format($product['price'], 0); ?></span>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

    </div>
</main>
</body>

<?php include("footer.php"); ?>