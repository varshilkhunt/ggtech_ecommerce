<?php
include "db.php";

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("location:index.php");
    exit;
}

if(@$_REQUEST['dl'])
{
    $del=@$_REQUEST['dl'];
    delete($db,"inquiry","where `id` = '$del'");
}

include "header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Customer Inquiries | GG TECH Admin</title>
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
            max-width: 1300px;
            margin: 20px auto; /* Reduced top margin since title is gone */
            padding: 0 30px;
        }

        .fw-800 { font-weight: 800; }
        .fw-700 { font-weight: 700; }

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

        .col-sender { width: 220px; }
        .col-contact { width: 250px; }
        .col-msg { text-align: left; } 
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
            padding: 20px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .modern-table tr:hover { background-color: #fcfdfe; }
        .modern-table tr:last-child td { border-bottom: none; }

        .sender-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar-box {
            width: 38px;
            height: 38px;
            background: #f4f7fe;
            color: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 14px;
            flex-shrink: 0;
        }

        .contact-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .contact-line {
            font-size: 0.82rem;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .contact-line i {
            color: var(--text-muted);
            width: 14px;
            font-size: 0.8rem;
        }

        .message-bubble {
            background: #f8fafc;
            padding: 14px 18px;
            border-radius: 14px;
            color: #475569;
            font-size: 0.85rem;
            line-height: 1.5;
            max-width: 500px;
            border: 1px solid #f1f5f9;
            word-wrap: break-word;
        }

        .action-btn.delete {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: #fff5f5;
            color: var(--danger);
            text-decoration: none;
            transition: all 0.2s;
            border: 1px solid transparent;
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
    <div class="table-container shadow-sm">
        <table class="modern-table">
            <thead>
                <tr>
                    <th class="col-sender">Sender Info</th>
                    <th class="col-contact">Contact Details</th>
                    <th class="col-msg">Message</th>
                    <th class="col-action">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $inquiry = get($db, "*", "inquiry", "", "");
                while($inq = mysqli_fetch_array($inquiry)) {
                ?>
                <tr>
                    <td class="col-sender">
                        <div class="sender-profile">
                            <div class="avatar-box"><i class="fa-solid fa-user"></i></div>
                            <div class="fw-700 text-dark"><?php echo $inq['name']; ?></div>
                        </div>
                    </td>
                    
                    <td class="col-contact">
                        <div class="contact-group">
                            <div class="contact-line">
                                <i class="fa-regular fa-envelope"></i> 
                                <?php echo $inq['email']; ?>
                            </div>
                            <div class="contact-line">
                                <i class="fa-solid fa-phone-flip"></i> 
                                <?php echo $inq['phone']; ?>
                            </div>
                        </div>
                    </td>
                    
                    <td class="col-msg">
                        <div class="message-bubble" title="<?php echo $inq['message']; ?>">
                            <?php echo $inq['message']; ?>
                        </div>
                    </td>
                    
                    <td class="col-action">
                        <a class="action-btn delete" href="view_inqueries.php?dl=<?php echo $inq['id']; ?>" onClick="return del()" title="Remove Inquiry">
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
        return confirm('Are you sure you want to permanently delete this inquiry?');
    }
</script>

</body>
</html>