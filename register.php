<?php
include "admin/db.php";

$message = "";

if (isset($_POST['register'])) {
    $name   = trim($_POST['name']);
    $email  = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $pass   = $_POST['password'];

    if ($name == "" || $email == "" || $mobile == "" || $pass == "") {
        $message = "<div class='message error'>All fields are required</div>";
    } else {
        $name   = mysqli_real_escape_string($db, $name);
        $email  = mysqli_real_escape_string($db, $email);
        $mobile = mysqli_real_escape_string($db, $mobile);
        $password = password_hash($pass, PASSWORD_DEFAULT);
        
        $check = get($db,"id","users_registration","WHERE mobile='$mobile'","");

        if (mysqli_num_rows($check) > 0) {
            $message = "<div class='message success'>Already Registered! Redirecting to Login...</div>
                        <script>
                            setTimeout(function(){
                                window.location.href = 'login.php';
                            }, 1500);
                        </script>";
        } else {
            $condition = insert($db,"users_registration", array(
                "name" => $name, 
                "email" => $email, 
                "mobile" => $mobile, 
                "password" => $password
            ));

            if (mysqli_affected_rows($db) > 0) {

                $_SESSION['login']  = true;
                $_SESSION['email'] = $email;

                $message = "<div class='message success'>Account created! Redirecting to login...</div>
                            <script>
                                setTimeout(function(){
                                    window.location.href = 'login.php';
                                }, 1500);
                            </script>";

            } else {
                $message = "<div class='message error'>Database error: " . mysqli_error($db) . "</div>";
            }



        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | GG TECH</title>
    <link rel="icon" type="image/png" href="favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

<div class="auth-container">
    <div class="form-box shadow-sm">
        <div class="brand-header text-center mb-4">
        <h1><a href="index.php">GG TECH<span>.</span></a></h1>
            <p>Join our community of tech enthusiasts</p>
        </div>

        <?php echo $message; ?>

        <form method="post">
            <div class="input-group">
                <label>Full Name</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="name" placeholder="John Doe" required>
                </div>
            </div>

            <div class="input-group">
                <label>Email Address</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" placeholder="john@example.com" required>
                </div>
            </div>

            <div class="input-group">
                <label>Mobile Number</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-phone"></i>
                    <input type="tel" name="mobile" placeholder="9876543210" pattern="[0-9]{10}" maxlength="10" inputmode="numeric" required>
                </div>
            </div>

            <div class="input-group">
                <label>Secure Password</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" name="register" class="btn-register">Create Account</button>

            <div class="footer-link">
                Already have an account? <a href="login.php">Log In</a>
            </div>
        </form>
    </div>
</div>

<style>

.brand-header h1 a {
    text-decoration: none; /* Removes the underline */
    color: inherit;         /* Takes the color from the h1 (var(--text-main)) */
    display: inline-block;
}

/* Optional: Keep the pointer cursor so users know it's clickable, 
   or use 'cursor: default' if you want it to feel exactly like text */
.brand-header h1 a:hover {
    color: var(--text-main); 
}
:root {
    --bg-page: #fdfdfd;
    --accent: #5e72e4;
    --text-main: #1e293b;
    --text-muted: #64748b;
    --input-fill: #f8fafc;
}

* { box-sizing: border-box; }

body {
    margin: 0;
    font-family: 'Plus Jakarta Sans', sans-serif;
    background-color: var(--bg-page);
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-main);
}

.auth-container {
    width: 100%;
    max-width: 420px;
    padding: 20px;
}

.form-box {
    background: #ffffff;
    padding: 40px;
    border-radius: 24px;
    border: 2px solid #000;
    animation: slideUp 0.5s ease-out;
}


@keyframes slideUp {
    from { transform: translateY(15px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.brand-header h1 {
    font-weight: 800;
    font-size: 1.8rem;
    margin: 0;
    letter-spacing: -1px;
}

.brand-header h1 span { color: var(--accent); }

.brand-header p {
    color: var(--text-muted);
    font-size: 0.85rem;
    margin-top: 5px;
}

/* INPUTS */
.input-group { margin-bottom: 18px; }

.input-group label {
    display: block;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--text-muted);
    margin-bottom: 6px;
}

.input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.input-wrapper i {
    position: absolute;
    left: 15px;
    color: #cbd5e1;
    font-size: 0.85rem;
}

.input-wrapper input {
    width: 100%;
    padding: 12px 12px 12px 42px;
    background: var(--input-fill);
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    font-size: 0.9rem;
    transition: all 0.2s ease;
}

.input-wrapper input:focus {
    outline: none;
    background: #fff;
    border-color: var(--accent);
    box-shadow: 0 0 0 4px rgba(94, 114, 228, 0.1);
}

/* BUTTON */
.btn-register {
    width: 100%;
    padding: 14px;
    background: var(--text-main);
    color: #ffffff;
    border: none;
    border-radius: 12px;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 10px;
}

.btn-register:hover {
    background: #000;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.footer-link {
    text-align: center;
    margin-top: 25px;
    font-size: 0.85rem;
    color: var(--text-muted);
}

.footer-link a {
    color: var(--accent);
    font-weight: 700;
    text-decoration: none;
}

/* NOTIFICATIONS */
.message {
    padding: 12px;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 600;
    text-align: center;
    margin-bottom: 20px;
}

.message.success { background: #f0fdf4; color: #166534; border: 1px solid #dcfce7; }
.message.error { background: #fef2f2; color: #991b1b; border: 1px solid #fee2e2; }


</style>

</body>
</html>