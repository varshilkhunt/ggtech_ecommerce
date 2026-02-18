<?php 
include_once "admin/db.php";

$cart_count = 0;
$wishlist_count = 0;

if (isset($_SESSION['login']) && $_SESSION['login'] === true && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $check = get($db,"*","cart","WHERE uid = '$user_id'","");
    $cart_count = mysqli_num_rows($check);
	$wq = get($db,"*","wishlist","WHERE user_id = '$user_id'","");
    $wishlist_count = mysqli_num_rows($wq);
	
    $mb = $_SESSION['email'];
    $result = get($db,"name","users_registration","WHERE email='".$mb."'","");
    $record = mysqli_fetch_array($result);
}
else {
    $record = ['name' => 'Guest'];
}

// Check if search or category is active to show the "Ref" (X) button
$is_filtered = !empty($_GET['search']) || !empty($_GET['category']);
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="icon" type="image/png" href="favicon.png">

<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

</head>

<body>

<nav class="navbar navbar-expand-lg fixed-top">
<div class="container">

<a href="index.php" class="navbar-brand">GG TECH<span style="color:var(--accent-blue)">.</span></a>

<button type="button" class="navbar-toggler border-0 shadow-none" data-toggle="collapse" data-target="#menu">
    <i class="fas fa-bars text-dark"></i>
</button>

<div class="collapse navbar-collapse" id="menu">

    <ul class="navbar-nav mr-auto">
        <li class="nav-item"><a href="orders.php" class="nav-link">Orders</a></li>
        <li class="nav-item"><a href="inquiry.php" class="nav-link">Inquiry</a></li>
    </ul>

    <form class="form-inline" method="GET" action="index.php">
        
        <div class="search-group mr-lg-4">
            <select name="category" class="form-control cat-select shadow-none" onchange="this.form.submit()">
                <option value="">Categories</option>
                <?php 
                $cat = get($db,"*","categories","","");
                while($category = mysqli_fetch_array($cat)) {
                    $sel = (($_GET['category'] ?? '') == $category['id']) ? 'selected' : '';
                    echo "<option value='{$category['id']}' $sel>{$category['c_name']}</option>";
                }
                ?>
            </select>

            <input type="text" name="search" class="form-control search-input shadow-none" 
                   placeholder="Search products..." value="<?php echo $_GET['search'] ?? ''; ?>">

            <?php if ($is_filtered): ?>
                <a href="index.php" class="btn-clear" title="Clear Filters">
                    <i class="fas fa-times-circle"></i>
                </a>
            <?php endif; ?>

            <button type="submit" class="btn-submit">
                <i class="fas fa-search" style="font-size: 0.8rem;"></i>
            </button>
        </div>

        <div class="d-flex align-items-center">
            <a href="wishlist.php" class="cart-wrap">
				<i class="fas fa-heart"></i>

				<?php if(!empty($wishlist_count) && $wishlist_count > 0): ?>
					<span class="cart-dot" id="wishlist-count">
						<?php echo $wishlist_count; ?>
					</span>
				<?php endif; ?>
			</a>



				<a href="cart.php" class="cart-wrap">
					<i class="fas fa-shopping-bag"></i>
					<?php if(isset($cart_count) && $cart_count > 0): ?>
						<span class="cart-dot"><?php echo $cart_count; ?></span>
					<?php endif; ?>
				</a>

				<!-- Login / Logout -->
				<?php if (!isset($_SESSION['login']) || $_SESSION['login'] !== true): ?>
					<a href="login.php" class="auth-link mr-3">Login</a>
				<?php else: ?>
					<a href="logout.php" class="auth-link text-muted mr-3">Logout</a>
				<?php endif; ?>


            <?php if(isset($_SESSION['login']) && $_SESSION['login']===true): ?>

			<div class="dropdown ml-2" style="position:relative;">

				<div class="user-pill profile-toggle" onclick="toggleProfileMenu(this)">
					<i class="far fa-user mr-1"></i>
					<?php echo htmlspecialchars(explode(' ', $record['name'])[0]); ?>
					<i class="fas fa-chevron-down arrow ml-1"></i>
				</div>

				<div id="profileMenu" class="profile-menu">
					<a href="edit_user.php">Edit Profile</a>
				</div>

			</div>

			<?php else: ?>

			<div class="user-pill">
				<i class="far fa-user mr-1" style="font-size: 0.7rem;"></i>
				Guest
			</div>

			<?php endif; ?>

        </div>

    </form>

</div>
</div>
</nav>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

</body>
<script>
function toggleProfileMenu(el){

    const menu=document.getElementById("profileMenu");

    menu.classList.toggle("show");
    el.classList.toggle("active");
}

window.addEventListener("click",function(e){

    const menu=document.getElementById("profileMenu");
    const toggle=document.querySelector(".profile-toggle");

    if(!e.target.closest(".dropdown")){
        menu.classList.remove("show");
        toggle.classList.remove("active");
    }

});
</script>


</html>
<style>



body {
    filter: brightness(96%);
}
    :root {
        --nav-bg: #ffffff;
        --accent-blue: #5e72e4;
        --input-bg: #f4f6f9;
        --text-main: #1e293b;
        --text-muted: #64748b;
    }

    body { 
        padding-top: 95px; 
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #fdfdfd;
        color: var(--text-main);
    }

    /* Minimalist Glass Navbar */
    .navbar {
		background-color: rgba(255, 255, 255, 0.9) !important;
		backdrop-filter: saturate(180%) blur(15px);
		border-bottom: 1px solid #000;   /* 🔥 Black border */
		padding: 14px 0;
	}


    .navbar-brand {
        font-weight: 800;
        color: var(--text-main) !important;
        font-size: 1.4rem;
        letter-spacing: -1px;
        text-transform: uppercase;
    }

    .nav-link {
        color: var(--text-muted) !important;
        font-weight: 500;
        font-size: 0.9rem;
        padding: 8px 12px !important;
        transition: color 0.2s ease;
    }

    .nav-link:hover {
        color: var(--accent-blue) !important;
    }

    /* Minimalist Search & Category Group */
    .search-group {
        background: var(--input-bg);
        border-radius: 14px;
        padding: 4px;
        display: flex;
        align-items: center;
        border: 1px solid transparent;
        transition: border 0.3s ease;
    }

    .search-group:focus-within {
        border-color: #e2e8f0;
        background: #fff;
    }

    .cat-select, .search-input {
        background: transparent !important;
        border: none !important;
        font-size: 0.85rem !important;
        color: var(--text-main);
        height: 36px;
    }

    .cat-select { width: 130px; border-right: 1px solid #e2e8f0 !important; border-radius: 0; cursor: pointer; }
    .search-input { width: 180px; padding-left: 12px; }

    /* The "Ref" / Clear Button (Minimalist X) */
    .btn-clear {
        color: #cbd5e1;
        background: transparent;
        border: none;
        padding: 0 10px;
        font-size: 0.9rem;
        transition: color 0.2s;
    }

    .btn-clear:hover { color: #f87171; }

    .btn-submit {
        background: var(--text-main);
        color: white;
        border: none;
        border-radius: 10px;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Icons & Badges */
    .cart-wrap {
        position: relative;
        padding: 0 12px;
        color: var(--text-main);
        font-size: 1.1rem;
    }

    .cart-dot {
        position: absolute;
        top: -4px;
        right: 4px;
        background: var(--accent-blue);
        color: white;
        font-size: 9px;
        font-weight: 800;
        height: 16px;
        width: 16px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #fff;
    }

    .user-pill {
        background: #f1f5f9;
        padding: 6px 14px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 700;
        margin-left: 10px;
        color: var(--text-main);
    }

    .auth-link {
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--text-main);
        text-decoration: none !important;
    }

    @media (max-width: 991px) {
        .navbar-collapse { padding-top: 20px; }
        .search-group { margin: 15px 0; width: 100%; }
        .cat-select, .search-input { width: 100%; border-right: none; border-bottom: 1px solid #e2e8f0; }
    }
	
.fa-heart:hover{
    color:#ff4d6d;
}
.dropdown-menu{
    font-size:0.85rem;
    border-radius:12px;
    padding:6px;
}

.dropdown-item{
    border-radius:8px;
}

.dropdown-item:hover{
    background:#f1f5f9;
}
.profile-menu{
    display:none;
    position:absolute;
    right:0;
    top:45px;
    background:#fff;
    border-radius:12px;
    box-shadow:0 8px 25px rgba(0,0,0,0.08);
    padding:6px;
    min-width:160px;
    z-index:999;
}

.profile-menu a{
    display:block;
    padding:8px 12px;
    border-radius:8px;
    font-size:0.85rem;
    color:#1e293b;
    text-decoration:none;
}

.profile-menu{
    opacity:0;
    transform:translateY(10px);
    pointer-events:none;
    position:absolute;
    right:0;
    top:45px;
    background:#fff;
    border-radius:12px;
    box-shadow:0 12px 30px rgba(0,0,0,0.08);
    padding:6px;
    min-width:170px;
    transition:all .18s ease;
}

.profile-menu.show{
    opacity:1;
    transform:translateY(0);
    pointer-events:auto;
}
.profile-toggle{
    cursor:pointer;
    display:flex;
    align-items:center;
    gap:6px;
    transition:all .15s ease;
}

.profile-toggle:hover{
    background:#e9eefc;
}

.arrow{
    font-size:10px;
    transition:transform .2s ease;
}

.profile-toggle.active .arrow{
    transform:rotate(180deg);
}

.profile-menu a:hover{
    background:#f1f5f9;
}
.profile-menu.show{
    display:block;
}


</style>