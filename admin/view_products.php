<?php
include "db.php";

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("location:index.php");
}

if(@$_REQUEST['dl'])
{
    $del=@$_REQUEST['dl'];
    delete($db,"products","where `id` = '$del'");
    unlink($_REQUEST['img_delete']);
}

include "header.php";
?>

<head>
    <title>View Products | GG TECH Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="admin-bg">

<div class="container-fluid" style="padding: 0 40px;">
    
    <div class="d-flex justify-content-end" style="margin: 10px 0 10px 0;">
        <a class="add-product-btn" href="add_product.php">
            <i class="fa-solid fa-plus me-2"></i> Add New Product
        </a>
    </div>

    <div class="table-container shadow-sm" style="margin-bottom: 10px;">
        <table class="modern-table">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="25%">Product Details</th>
                    <th width="15%">Category</th>
                    <th width="15%">Pricing</th>
                    <th width="25%">Description</th>
                    <th width="15%" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $pro = get($db,"*","products","","");
                while($product = mysqli_fetch_array($pro))
                {
                    $category_id = $product['category_id'];
                    $cat_query = get($db,"*","categories","where id = $category_id","");
                    $category = mysqli_fetch_array($cat_query);
                    
                    echo "<tr>";
                    echo "<td><span class='id-badge'>#".$product['id']."</span></td>";
                    
                    echo "<td>";
                    echo "<div class='product-info-cell'>";
                    echo "<img class='product-img-preview' src='".$product['image']."'>";
                    echo "<div><div class='fw-700 text-dark'>".$product['p_name']."</div></div>";
                    echo "</div>";
                    echo "</td>";
                    
                    echo "<td><span class='cat-tag'>".($category['c_name'] ?? 'N/A')."</span></td>";
                    
                    echo "<td>";
                    echo "<div class='mrp-text'>₹".$product['mrp']."</div>";
                    echo "<div class='price-text'>₹".$product['price']."</div>";
                    echo "</td>";
                    
                    echo "<td><div class='desc-truncate' title='".$product['description']."'>".$product['description']."</div></td>";
                    
                    echo "<td class='text-center'>";
                    echo "<div class='action-flex'>";
                    echo "<a class='action-btn edit' href='add_product.php?dl=".$product['id']."' title='Update'><i class='fa-solid fa-pen-to-square'></i></a>";
                    echo "<a class='action-btn delete' href='view_products.php?dl=".$product['id']."&img_delete=".$product['image']."' onClick='return del()' title='Delete'><i class='fa-solid fa-trash-can'></i></a>";
                    echo "</div>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function del() {
        return confirm('Are you sure you want to delete this product? This will also remove the image file.');
    }
</script>

<style>
body {
    filter: brightness(96%);
}
    :root {
        --accent: #4318ff;
        --bg-light: #f4f7fe;
        --text-main: #1b2559;
        --text-muted: #a3aed0;
        --danger: #ff5252;
    }

    body.admin-bg {
        background-color: var(--bg-light);
        font-family: 'Plus Jakarta Sans', sans-serif;
        margin: 0;
    }

    .fw-700 { font-weight: 700; }

    .table-container {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .modern-table {
        width: 100%;
        border-collapse: collapse;
    }

    .modern-table thead th {
        background: #f8fafc;
        padding: 15px 20px;
        text-align: left;
        font-size: 0.7rem;
        text-transform: uppercase;
        color: var(--text-muted);
        font-weight: 800;
        border-bottom: 1px solid #f1f5f9;
    }

    .modern-table tbody td {
        padding: 12px 20px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.85rem;
        vertical-align: middle;
    }

    .product-info-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .product-img-preview {
        width: 45px;
        height: 45px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #e0e5f2;
    }

    .id-badge {
        background: #f4f7fe;
        color: var(--accent);
        padding: 4px 8px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.75rem;
    }

    .cat-tag {
        background: #eff6ff;
        color: #3b82f6;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
    }

    .mrp-text { text-decoration: line-through; color: var(--text-muted); font-size: 0.7rem; }
    .price-text { color: #10b981; font-weight: 800; }

    .desc-truncate {
        max-width: 180px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: var(--text-muted);
    }

    .action-flex { display: flex; gap: 8px; justify-content: center; }

    .action-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: 0.2s;
    }

    .action-btn.edit { background: #f0eeff; color: var(--accent); }
    .action-btn.delete { background: #fff5f5; color: var(--danger); }

    .add-product-btn {
        background: var(--accent);
        color: #fff !important;
        padding: 8px 18px;
        border-radius: 10px;
        font-weight: 700;
        text-decoration: none;
        font-size: 0.85rem;
    }

    .text-center { text-align: center; }
</style>

</body>
</html>