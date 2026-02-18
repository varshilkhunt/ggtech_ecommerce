<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
	body {
    filter: brightness(96%);
}
        :root {
            --accent: #4318ff;
            --text-main: #1b2559;
            --text-muted: #a3aed0;
            --white: #ffffff;
            --bg-hover: #f4f7fe;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* NAVBAR MAIN */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(224, 229, 242, 0.5);
        }

        /* BRAND */
        .navbar h1 a {
            font-size: 22px;
            font-weight: 800;
            color: var(--text-main);
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .navbar h1 a span {
            color: var(--accent);
        }

        /* MENU ITEMS */
        .nav-menu {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .nav-menu > a {
            text-decoration: none;
            color: var(--text-main);
            font-weight: 600;
            font-size: 14px;
            padding: 10px 16px;
            border-radius: 12px;
            transition: 0.3s;
        }

        .nav-menu > a:hover,
        .nav-menu > a.active {
            color: var(--accent);
            background: var(--bg-hover);
        }

        /* DROPDOWN CORE LOGIC */
        .nav-dropdown {
            position: relative; /* This is the fix: anchors the content to the button */
            display: inline-block;
        }

        .nav-dropbtn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-main);
            padding: 10px 16px;
            border-radius: 12px;
            transition: 0.3s;
            display: flex;
            align-items: center;
        }

        .nav-dropbtn i {
            font-size: 10px;
            margin-left: 8px;
            transition: 0.3s;
        }

        .nav-dropbtn:hover {
            background: var(--bg-hover);
            color: var(--accent);
        }

        /* FLOATING CONTENT */
        .nav-dropdown-content,
        .profile-dropdown {
            display: none;
            position: absolute;
            top: 100%; /* Position directly below the button */
            left: 0;
            background: #ffffff;
            min-width: 200px;
            border-radius: 16px;
            box-shadow: 0px 20px 45px rgba(112, 144, 176, 0.15);
            border: 1px solid #e0e5f2;
            padding: 8px;
            z-index: 1100;
            margin-top: 8px;
        }

        /* Aligns the profile dropdown to the right edge */
        .nav-right .profile-dropdown {
            left: auto;
            right: 0;
        }

        .nav-dropdown-content a,
        .profile-dropdown a {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            text-decoration: none;
            color: var(--text-main);
            font-size: 14px;
            font-weight: 500;
            border-radius: 10px;
            transition: 0.2s;
        }

        .nav-dropdown-content a:hover,
        .profile-dropdown a:hover {
            background: var(--bg-hover);
            color: var(--accent);
        }

        /* PROFILE SPECIFIC */
        .profile-photo {
            cursor: pointer;
            position: relative;
        }

        .profile-photo img {
            width: 45px;
            height: 45px;
            border-radius: 14px;
            object-fit: cover;
            border: 2px solid #e0e5f2;
            display: block;
            transition: 0.3s;
        }

        .profile-photo:hover img {
            border-color: var(--accent);
            transform: translateY(-2px);
        }

        .profile-header {
            padding: 12px 16px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--text-muted);
            letter-spacing: 0.05em;
            border-bottom: 1px solid #f1f5f9;
            margin-bottom: 5px;
        }

        /* SHOW CLASS */
        .show {
            display: block !important;
            animation: slideDown 0.2s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .ms-1 { margin-left: 0.25rem; }
        .me-2 { margin-right: 0.5rem; }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="nav-left-brand">
            <h1><a href="dashboard.php">GG TECH<span>.</span></a></h1>
        </div>

        <div class="nav-menu">
            <a href="dashboard.php" class="active">Dashboard</a>

            <div class="nav-dropdown">
                <button class="nav-dropbtn" onclick="toggleDropdown(event, 'categoryDropdown')">
                    Categories <i class="fa-solid fa-chevron-down ms-1"></i>
                </button>
                <div class="nav-dropdown-content" id="categoryDropdown">
                    <a href="add_category.php"><i class="fa-solid fa-plus me-2"></i> Add Category</a>
                    <a href="view_categories.php"><i class="fa-solid fa-list me-2"></i> View Categories</a>
                </div>
            </div>

            <div class="nav-dropdown">
                <button class="nav-dropbtn" onclick="toggleDropdown(event, 'productDropdown')">
                    Products <i class="fa-solid fa-chevron-down ms-1"></i>
                </button>
                <div class="nav-dropdown-content" id="productDropdown">
                    <a href="add_product.php"><i class="fa-solid fa-plus me-2"></i> Add Product</a>
                    <a href="view_products.php"><i class="fa-solid fa-boxes-stacked me-2"></i> View Products</a>
                </div>
            </div>

            <div class="nav-dropdown">
                <button class="nav-dropbtn" onclick="toggleDropdown(event, 'orderDropdown')">
                    Orders <i class="fa-solid fa-chevron-down ms-1"></i>
                </button>
                <div class="nav-dropdown-content" id="orderDropdown">
                    <a href="view_orders.php"><i class="fa-solid fa-truck-fast me-2"></i> View Orders</a>
                </div>
            </div>

            <div class="nav-dropdown">
                <button class="nav-dropbtn" onclick="toggleDropdown(event, 'inqueryDropdown')">
                    Inquiries <i class="fa-solid fa-chevron-down ms-1"></i>
                </button>
                <div class="nav-dropdown-content" id="inqueryDropdown">
                    <a href="view_inquiries.php"><i class="fa-solid fa-clipboard-question me-2"></i> View Inquiries</a>
                </div>
            </div>

            <div class="nav-dropdown">
                <button class="nav-dropbtn" onclick="toggleDropdown(event, 'userDropdown')">
                    Users <i class="fa-solid fa-chevron-down ms-1"></i>
                </button>
                <div class="nav-dropdown-content" id="userDropdown">
                    <a href="view_users.php"><i class="fa-solid fa-users-gear me-2"></i> View Users</a>
                </div>
            </div>
        </div>

        <div class="nav-right">
            <div class="nav-dropdown">
                <div class="profile-photo" onclick="toggleDropdown(event, 'profileDropdown')">
                    <img id="profilePic" src="https://api.dicebear.com/7.x/pixel-art/svg?seed=<?php echo rand(1,9999); ?>" alt="Profile">
                </div>
                <div class="profile-dropdown" id="profileDropdown">
                    <div class="profile-header">Admin Account</div>
                    <a href="logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a>
                </div>
            </div>
        </div>
    </div>

<script>
    function closeAll() {
        document.querySelectorAll('.nav-dropdown-content, .profile-dropdown').forEach(el => {
            el.classList.remove('show');
        });
    }

    function toggleDropdown(event, id) {
        event.stopPropagation();
        const element = document.getElementById(id);
        const isCurrentlyVisible = element.classList.contains('show');
        
        closeAll();
        
        if (!isCurrentlyVisible) {
            element.classList.add('show');
        }
    }

    // Close when clicking outside
    document.addEventListener("click", closeAll);
</script>

</body>
</html>