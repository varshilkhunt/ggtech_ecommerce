<?php
include "db.php";

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("location:index.php");
    exit;
}

$is_edit = false;
if(@$_REQUEST['dl'])
{
    $is_edit = true;
    $up=@$_REQUEST['dl'];
    $pro = get($db,"*","products","where `id` = '$up'","");
    $product=mysqli_fetch_array($pro);
}

if(@$_REQUEST['btn']=='Update Product'){
	
	$id = $_REQUEST['id'];
	$mrp=$_POST['mrp'];
	$p_name=$_POST['p_name'];
	$price=$_POST['price'];
	$category_id=$_POST['category_id'];
	$description=$_POST['description'];
	$image = $_REQUEST['file'];
	if($_FILES['image']['name']!="")
	{
	$image = 'image/'.rand().$_FILES['image']['name'];
	move_uploaded_file($_FILES['image']['tmp_name'],$image);
	unlink($_REQUEST['file']);
	}
	
	$update = "update products set `p_name`='$p_name', `mrp`='$mrp', `price`='$price', `category_id`='$category_id', `description`='$description', `image`='$image'  where `id`= '$id' ";
	
	mysqli_query($db,$update)or die("Update error".mysqli_error($db));
	header("Location: view_products.php");
	exit();
}

if(@$_REQUEST['btn']=='Add Product'){
	
	$p_name=$_POST['p_name'];
	$mrp=$_POST['mrp'];
	$price=$_POST['price'];
	$category_id=$_POST['category_id'];
	$description=$_POST['description'];
	$image="image/".rand().$_FILES['image']['name'];
	$tmpimage=$_FILES['image']['tmp_name'];
	move_uploaded_file($tmpimage,$image);
	
	$insert = "insert into products set `p_name`='$p_name', `mrp`='$mrp', `price`='$price', `category_id`='$category_id', `description`='$description', `image`='$image' ";
	
	mysqli_query($db,$insert)or die("Insertion error".mysqli_error($db));
	echo "<script>alert('Products Inserted');</script>";
	header("Location: view_products.php");
	exit();
}

include "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $is_edit ? 'Edit' : 'Add'; ?> Product | GG TECH Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-bg">

<div class="admin-container py-5">
    <div class="product-card">
        <div class="card-header-custom">
            <div class="header-icon">
                <i class="fa-solid <?php echo $is_edit ? 'fa-box-open' : 'fa-plus-circle'; ?>"></i>
            </div>
            <div class="header-text">
                <h3><?php echo $is_edit ? 'Edit Product' : 'New Product'; ?></h3>
                <p>Fill in the details to list a tech item</p>
            </div>
        </div>

        <form action="add_product.php" method="post" enctype="multipart/form-data" class="mt-4">
            <input type="hidden" name="id" value="<?php echo @$product['id']; ?>">

            <div class="form-group mb-3">
                <label class="admin-label">Product Name</label>
                <div class="input-with-icon">
                    <i class="fa-solid fa-microchip"></i>
                    <input type="text" name="p_name" placeholder="Enter product name" value="<?php echo @$product['p_name']; ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="admin-label">MRP (Original)</label>
                    <div class="input-with-icon">
                        <i class="fa-solid fa-tag"></i>
                        <input type="text" name="mrp" placeholder="0.00" value="<?php echo @$product['mrp']; ?>" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="admin-label">Sale Price</label>
                    <div class="input-with-icon">
                        <i class="fa-solid fa-indian-rupee-sign"></i>
                        <input type="text" name="price" placeholder="0.00" value="<?php echo @$product['price']; ?>" required>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label class="admin-label">Category</label>
                <div class="input-with-icon">
                    <i class="fa-solid fa-layer-group"></i>
                    <select name="category_id" required>
                        <option value="" disabled selected>Select Category</option>
                        <?php
                        $cat = mysqli_query($db,"SELECT * FROM categories") or die(mysqli_error($db));
                        while($category = mysqli_fetch_array($cat)) {
                            $selected = ($category['id'] == $product['category_id']) ? "selected" : "";
                            echo "<option value='".$category['id']."' $selected>".$category['c_name']."</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group mb-3">
                <label class="admin-label">Product Image</label>
                <div class="file-upload-wrapper">
                    <input type="file" name="image" id="file-input" accept="image/*" <?php if(!$is_edit) echo 'required'; ?>>
                    <div class="file-upload-design">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <p><?php echo $is_edit ? 'Click to replace image' : 'Drag & drop or browse image'; ?></p>
                        <?php if($is_edit): ?>
                            <small class="text-primary mt-1 d-block">Current: <?php echo basename($product['image']); ?></small>
                        <?php endif; ?>
                    </div>
                </div>
                <input type="hidden" name="file" value="<?php echo @$product['image']?>">
            </div>

            <div class="form-group mb-4">
                <label class="admin-label">Full Description</label>
                <textarea name="description" placeholder="Write tech specs, features, etc..."><?php echo @$product['description']; ?></textarea>
            </div>

            <div class="action-buttons">
                <button type="submit" name="btn" value="<?php echo $is_edit ? 'Update Product' : 'Add Product'; ?>" class="btn-admin-primary">
                    <?php echo $is_edit ? 'Update Item' : 'Publish Product'; ?>
                </button>
                <a href="view_products.php" class="btn-admin-outline">
                    View Inventory
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
        --accent: #4318ff;
        --text-main: #1b2559;
        --text-muted: #a3aed0;
    }

    body.admin-bg {
        background-color: var(--admin-bg);
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text-main);
    }

    .product-card {
        background: #ffffff;
        border-radius: 24px;
        padding: 40px;
        width: 100%;
        max-width: 650px;
        margin: 0 auto;
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
        width: 50px;
        height: 50px;
        background: #f4f7fe;
        color: var(--accent);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .header-text h3 { margin: 0; font-weight: 800; font-size: 1.3rem; }
    .header-text p { margin: 0; font-size: 0.85rem; color: var(--text-muted); }

    .admin-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-main);
        margin-bottom: 8px;
        display: block;
    }

    .input-with-icon { position: relative; }
    .input-with-icon i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .input-with-icon input, 
    .input-with-icon select, 
    textarea {
        width: 100%;
        padding: 12px 15px 12px 42px;
        border-radius: 12px;
        border: 1px solid #e0e5f2;
        font-size: 0.95rem;
        font-weight: 500;
        transition: 0.2s;
    }

    textarea {
        padding: 15px;
        min-height: 120px;
        resize: vertical;
    }

    .input-with-icon input:focus, textarea:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0px 8px 20px rgba(67, 24, 255, 0.08);
    }

    /* File Upload Area */
    .file-upload-wrapper {
        position: relative;
        border: 2px dashed #e0e5f2;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        transition: 0.2s;
    }

    .file-upload-wrapper:hover { border-color: var(--accent); background: #f4f7fe; }

    #file-input {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0; left: 0;
        opacity: 0;
        cursor: pointer;
    }

    .file-upload-design i { font-size: 1.5rem; color: var(--accent); margin-bottom: 8px; }
    .file-upload-design p { font-size: 0.8rem; font-weight: 600; color: var(--text-muted); margin: 0; }

    /* Buttons */
    .btn-admin-primary {
        background: var(--accent);
        color: #fff;
        border: none;
        padding: 16px;
        border-radius: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-admin-primary:hover {
        background: #3311db;
        transform: translateY(-2px);
    }

    .btn-admin-outline {
        background: #fff;
        color: var(--text-main);
        border: 1px solid #e0e5f2;
        padding: 14px;
        border-radius: 14px;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .btn-admin-outline:hover { background: #f4f7fe; color: var(--accent); }

    .action-buttons { display: flex; flex-direction: column; gap: 12px; }
</style>

</body>
</html>