<?php
include "db.php";

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("location:index.php");
    exit;
}

if(@$_REQUEST['dl'])
{
    $del=@$_REQUEST['dl'];
    delete($db,"users_registration","where `id` = '$del'");
}

include "header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Users | GG TECH Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
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
            --border: #f1f5f9;
        }

        body.admin-bg {
            background-color: var(--bg-light);
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
        }

        .main-wrapper {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 30px;
        }

        /* Action Bar Alignment */
        .action-bar {
            display: flex;
            justify-content: flex-end; /* Pushes button to the right */
            margin-bottom: 20px;
        }

        .fw-700 { font-weight: 700; }
        .fw-800 { font-weight: 800; }

        .table-container {
            background: #fff;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.03);
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
        }

        .col-id { width: 100px; }
        .col-profile { text-align: left; }
        .col-contact { width: 300px; }
        .col-action { width: 100px; text-align: center; }

        .modern-table thead th {
            background: #fafcfe;
            padding: 20px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            font-weight: 800;
            border-bottom: 2px solid var(--border);
        }

        .modern-table tbody td {
            padding: 18px 20px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            font-size: 0.95rem;
            color: var(--text-main);
        }

        .modern-table tr:hover { background-color: #fcfdfe; }
        .modern-table tr:last-child td { border-bottom: none; }

        .id-badge {
            background: #f4f7fe;
            color: var(--accent);
            padding: 5px 10px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.8rem;
        }

        .contact-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .contact-info {
            font-size: 0.85rem;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .contact-info i {
            color: var(--text-muted);
            width: 16px;
            font-size: 12px;
        }

        /* Add User Button - Right Aligned */
        .add-user-btn {
            background: var(--accent);
            color: #fff;
            padding: 12px 24px;
            border-radius: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.3s;
            font-size: 0.85rem;
            box-shadow: 0 8px 16px rgba(67, 24, 255, 0.15);
        }

        .add-user-btn:hover {
            background: #3311db;
            transform: translateY(-2px);
            color: #fff;
        }

        .action-btn.delete {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: #fff5f5;
            color: var(--danger);
            text-decoration: none;
            transition: all 0.2s;
        }

        .action-btn.delete:hover {
            background: var(--danger);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 82, 82, 0.2);
        }
    </style>
</head>

<body class="admin-bg">

<div class="main-wrapper">
    <div class="action-bar">
        <a class="add-user-btn" href="../register.php">
            <i class="fa-solid fa-user-plus me-2"></i> Add New User
        </a>
    </div>

    <div class="table-container shadow-sm">
        <table class="modern-table">
            <thead>
                <tr>
                    <th class="col-id">ID</th>
                    <th class="col-profile">User Profile</th>
                    <th class="col-contact">Contact Details</th>
                    <th class="col-action">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $users = get($db,"*","users_registration","","");
                while($user = mysqli_fetch_array($users))
                {
                ?>
                <tr>
                    <td class="col-id">
                        <span class="id-badge">#<?php echo $user['id']; ?></span>
                    </td>
                    <td class="col-profile">
                        <div class="fw-700 text-dark"><?php echo $user['name']; ?></div>
                        <div class="text-muted small" style="font-size:12px;">Standard User</div>
                    </td>
                    <td class="col-contact">
                        <div class="contact-group">
                            <div class="contact-info">
                                <i class="fa-regular fa-envelope"></i>
                                <?php echo $user['email']; ?>
                            </div>
                            <div class="contact-info">
                                <i class="fa-solid fa-phone"></i>
                                <?php echo $user['mobile']; ?>
                            </div>
                        </div>
                    </td>
                    <td class="col-action">
                        <a class="action-btn delete" href="view_users.php?dl=<?php echo $user['id']; ?>" onClick="return del()" title="Delete User">
                            <i class="fa-solid fa-trash-can"></i>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function del() {
        return confirm('Are you sure you want to delete this user record? This action cannot be undone.');
    }
</script>

</body>
</html>