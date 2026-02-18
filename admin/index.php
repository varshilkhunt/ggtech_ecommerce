<?php 
include "db.php";

if(isset($_POST['submit'])){
    $email = @$_POST['email'];
    $password = @$_POST['password'];
    
    $result = get($db,"*","admin","WHERE `email`='$email' and `password`='$password'","");
        
    if(mysqli_num_rows($result) != 0 ) 
    { 
        $_SESSION['loggedin'] = true;
        echo "<script>window.location.replace('dashboard.php')</script>";
    } 
    else 
    {
        echo "<script>alert('Incorrect Login Info')</script>"; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Login | GG TECH</title>
    <link rel="icon" type="image/png" href="favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="login-container">
        <div class="wrapper">
            <div class="login-brand">
				<a href="../index.php" style="text-decoration: none; color: inherit;">GG TECH<span>.</span></a>
			</div>
            <h2>Admin Login</h2>
            <p class="subtitle">Please enter your credentials to continue</p>
            
            <form method="post" action="">
                <div class="input-field">
                    <label>E-mail Address</label>
                    <div class="input-wrapper">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" name="email" placeholder="name@company.com" required>
                    </div>
                </div>
                <div class="input-field">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                </div>
                <button name="submit" type="submit" class="btn">
                    Sign In <i class="fa-solid fa-arrow-right ms-2"></i>
                </button>
            </form>
            
            <div class="footer-note">
                &copy; 2026 GG TECH Secure Access
            </div>
        </div>
    </div>
</body>
</html>

<style>
body {
    filter: brightness(96%);
}

    :root {
        --accent: #4318ff;
        --text-main: #1b2559;
        --text-muted: #a3aed0;
        --bg-gradient: radial-gradient(circle at 10% 20%, rgb(239, 246, 255) 0%, rgb(219, 228, 255) 100%);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    body {
        min-height: 100vh;
        background: var(--bg-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .wrapper {
        width: 100%;
        max-width: 420px;
        background: #ffffff;
        padding: 45px;
        border-radius: 24px;
        box-shadow: 0 40px 100px rgba(112, 144, 176, 0.15);
        text-align: left;
        border: 1px solid rgba(255, 255, 255, 0.8);
    }

    /* BRAND LOGO */
    .login-brand {
        font-size: 24px;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 30px;
        letter-spacing: -1px;
    }

    .login-brand span {
        color: var(--accent);
    }

    .wrapper h2 {
        font-size: 28px;
        color: var(--text-main);
        font-weight: 800;
        margin-bottom: 8px;
    }

    .subtitle {
        color: var(--text-muted);
        font-size: 14px;
        margin-bottom: 35px;
    }

    /* INPUT FIELDS */
    .input-field {
        margin-bottom: 24px;
    }

    .input-field label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 8px;
        margin-left: 4px;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-wrapper i {
        position: absolute;
        left: 16px;
        color: var(--text-muted);
        font-size: 14px;
    }

    .input-wrapper input {
        width: 100%;
        padding: 14px 14px 14px 45px;
        border-radius: 14px;
        border: 1px solid #e0e5f2;
        font-size: 14px;
        font-weight: 500;
        outline: none;
        transition: 0.3s;
        color: var(--text-main);
    }

    .input-wrapper input:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 4px rgba(67, 24, 255, 0.08);
    }

    .input-wrapper input::placeholder {
        color: var(--text-muted);
    }

    /* BUTTON */
    .btn {
        width: 100%;
        padding: 16px;
        background: var(--accent);
        border: none;
        border-radius: 16px;
        color: #fff;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 10px;
    }

    .btn:hover {
        background: #3311db;
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(67, 24, 255, 0.2);
    }

    .footer-note {
        margin-top: 40px;
        font-size: 12px;
        color: var(--text-muted);
        text-align: center;
        font-weight: 600;
    }

    .ms-2 { margin-left: 0.5rem; }

    @media (max-width: 480px) {
        .wrapper { padding: 30px; }
    }
</style>