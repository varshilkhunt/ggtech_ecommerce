<?php
include "db.php";

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("location:index.php");
}

if(@$_REQUEST['dl'])
{
    $del=@$_REQUEST['dl'];
    delete($db,"categories","where `id` = '$del'");
}

include "header.php";
?>

<head>
    <title>View Categories | GG TECH Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="admin-bg">

<div class="container" style="padding: 0;">
    
    <div class="d-flex justify-content-end" style="max-width: 900px; margin: 10px auto 10px auto;">
        <a class="add-category-btn" href="add_category.php">
            <i class="fa-solid fa-plus me-2"></i> Add New Category
        </a>
    </div>

    <div class="table-container shadow-sm" style="margin-bottom: 10px;">
        <table class="modern-table">
            <thead>
                <tr>
                    <th width="15%">ID</th>
                    <th>Category Name</th>
                    <th width="20%" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $cat = get($db,"*","categories","","");
                while($category = mysqli_fetch_array($cat))
                {
                    echo "<tr>";
                    echo "<td><span class='id-badge'>#".$category['id']."</span></td>";
                    echo "<td><span class='fw-600 text-dark'>".$category['c_name']."</span></td>";
                    echo "<td class='text-center'>";
                    echo "<div class='action-flex'>";
                    echo "<a class='action-btn edit' href='add_category.php?dl=".$category['id']."' title='Edit'><i class='fa-solid fa-pen-to-square'></i></a>";
                    echo "<a class='action-btn delete' href='view_categories.php?dl=".$category['id']."' onClick='return del()' title='Delete'><i class='fa-solid fa-trash-can'></i></a>";
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
        return confirm('Are you sure you want to delete this category? This cannot be undone.');
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

    .table-container {
        max-width: 900px;
        margin: 0 auto;
        background: #fff;
        border-radius: 20px; /* Slightly reduced radius for tighter fit */
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
        font-size: 0.75rem;
        text-transform: uppercase;
        color: var(--text-muted);
        font-weight: 800;
        border-bottom: 1px solid #f1f5f9;
    }

    .modern-table tbody td {
        padding: 15px 20px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.95rem;
        vertical-align: middle;
    }

    .modern-table tr:hover { background-color: #fcfdfe; }

    .id-badge {
        background: #f4f7fe;
        color: var(--accent);
        padding: 4px 8px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.8rem;
    }

    .action-flex {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .action-btn {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: 0.3s;
    }

    .action-btn.edit { background: #f0eeff; color: var(--accent); }
    .action-btn.delete { background: #fff5f5; color: var(--danger); }

    .add-category-btn {
        background: var(--accent);
        color: #fff;
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