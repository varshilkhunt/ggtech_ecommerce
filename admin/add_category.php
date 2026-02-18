<?php
include "db.php";

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("location:index.php");
    exit;
}

// Check for Edit/Update mode
$is_edit = false;
if(@$_REQUEST['dl']) {
    $is_edit = true;
    $up = $_REQUEST['dl'];
    $cat = get($db,"*","categories","","where `id` = '$up'");
    $category = mysqli_fetch_array($cat);
}

// Logic for Update/Insert remains the same
if(@$_REQUEST['btn']=='Update'){
    $c_name = $_REQUEST['category_name'];
    $id = $_REQUEST['id'];
    update($db,"categories",array("c_name"=>"$c_name"),"where `id`= '$id'");
    header("Location: view_categories.php");
    exit();
}

if(@$_REQUEST['btn']=='Insert'){
    $c_name=$_POST['category_name'];
    insert($db,"categories",array("c_name"=>"$c_name"));
    header("Location: view_categories.php");
    exit();
}

include "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $is_edit ? 'Edit' : 'Add'; ?> Category | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-bg">

<div class="admin-container">
    <div class="category-card">
        <div class="card-header-custom">
            <div class="header-icon">
                <i class="fa-solid <?php echo $is_edit ? 'fa-pen-to-square' : 'fa-folder-plus'; ?>"></i>
            </div>
            <div class="header-text">
                <h3><?php echo $is_edit ? 'Update' : 'Create'; ?> Category</h3>
                <p>Manage your product taxonomy</p>
            </div>
        </div>

        <form action="add_category.php" method="post" class="mt-4">
            <input type="hidden" name="id" value="<?php echo @$category['id']?>">
            
            <div class="form-group mb-4">
                <label class="admin-label">Category Name</label>
                <div class="input-with-icon">
                    <i class="fa-solid fa-tag"></i>
                    <input type="text" 
                           name="category_name" 
                           placeholder="e.g. Smartwatches, Laptops..." 
                           value="<?php echo @$category['c_name']?>" 
                           required>
                </div>
				<br>
            </div>

            <div class="action-buttons">
                <button type="submit" name="btn" value="<?php echo $is_edit ? 'Update' : 'Insert'; ?>" class="btn-admin-primary">
                    <?php echo $is_edit ? 'Update Category' : 'Save Category'; ?>
                </button>
                
                <a href="view_categories.php" class="btn-admin-outline">
                    <i class="fa-solid fa-table-list me-2"></i> View All Categories
                </a>
            </div>
        </form>
    </div>
</div>

<style>
body {
    filter: brightness(96%);
}
    :root {
        --admin-bg: #f4f7fe;
        --sidebar-dark: #111c44;
        --accent: #4318ff;
        --text-main: #1b2559;
        --text-muted: #a3aed0;
    }

    body.admin-bg {
        background-color: var(--admin-bg);
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text-main);
        margin: 0;
    }

    .admin-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
        padding: 20px;
    }

    .category-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 40px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0px 20px 50px rgba(112, 144, 176, 0.12);
        border: 1px solid #fff;
    }

    .card-header-custom {
        display: flex;
        align-items: center;
        gap: 20px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 25px;
    }

    .header-icon {
        width: 55px;
        height: 55px;
        background: #f4f7fe;
        color: var(--accent);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
    }

    .header-text h3 {
        margin: 0;
        font-weight: 800;
        font-size: 1.25rem;
        letter-spacing: -0.5px;
    }

    .header-text p {
        margin: 0;
        font-size: 0.85rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    .admin-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-main);
        margin-bottom: 10px;
        display: block;
    }

    .input-with-icon {
        position: relative;
    }

    .input-with-icon i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
    }

    .input-with-icon input {
        width: 100%;
        padding: 14px 14px 14px 45px;
        border-radius: 14px;
        border: 1px solid #e0e5f2;
        background: #fff;
        font-size: 0.95rem;
        transition: 0.2s;
        font-weight: 500;
    }

    .input-with-icon input:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0px 10px 20px rgba(67, 24, 255, 0.1);
    }

    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .btn-admin-primary {
        background: var(--accent);
        color: #fff;
        border: none;
        padding: 16px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-admin-primary:hover {
        background: #3311db;
        transform: translateY(-2px);
        box-shadow: 0px 10px 20px rgba(67, 24, 255, 0.25);
    }

    .btn-admin-outline {
        background: #fff;
        color: var(--text-main);
        border: 1px solid #e0e5f2;
        padding: 14px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 0.85rem;
        text-align: center;
        text-decoration: none;
        transition: 0.2s;
    }

    .btn-admin-outline:hover {
        background: #f4f7fe;
        color: var(--accent);
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

</body>
</html>