<?php
include "admin/db.php"; 

if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('Please log-in to send an inquiry.');
        window.location.href='login.php';
    </script>";
    exit;
}
include("header.php");
if (isset($_POST['send_inquiry'])) {

    $name    = $_POST['name'];
    $email   = $_POST['email'];
    $phone   = $_POST['phone'];
    $message = $_POST['message'];
    
    insert($db,"inquiry",array("name"=>"$name", "email"=>"$email", "phone"=>"$phone", "message"=>"$message"));

    echo "<script>
        alert('Inquiry sent successfully!');
        window.location='index.php';
    </script>";
}
?>

<head>
    <title>Inquiry | GG TECH</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="minimal-bg d-flex flex-column min-vh-100">

<main class="flex-fill d-flex align-items-center py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                
                <div class="inquiry-card shadow-sm">
                    <div class="text-center mb-5">
                        <div class="icon-circle mb-3">
                            <i class="far fa-envelope"></i>
                        </div>
                        <h2 class="fw-800 text-dark mb-2">Get in Touch</h2>
                        <p class="text-muted px-4">Have a question about a gadget? Our tech experts are ready to help.</p>
                    </div>

                    <form method="post" class="custom-form">
                        <div class="mb-3">
                            <label class="form-label small fw-700 text-muted text-uppercase tracking-wider">Full Name</label>
                            <input type="text" name="name" class="form-control custom-input" placeholder="Enter your name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-700 text-muted text-uppercase tracking-wider">Email Address</label>
                            <input type="email" name="email" class="form-control custom-input" placeholder="name@company.com" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-700 text-muted text-uppercase tracking-wider">Phone Number</label>
                            <input type="text" name="phone" class="form-control custom-input" placeholder="+91 XXXXX XXXXX" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-700 text-muted text-uppercase tracking-wider">Message</label>
                            <textarea name="message" class="form-control custom-input" rows="4" placeholder="How can we help you?" required></textarea>
                        </div>

                        <button type="submit" name="send_inquiry" class="btn btn-inquiry w-100">
                            <span>Send Message</span>
                            <i class="fas fa-paper-plane ms-2"></i>
                        </button>
                    </form>
                </div>

                <div class="text-center mt-4">
                    <p class="small text-muted">
                        Prefer email? <a href="mailto:support@ggtech.com" class="text-primary-minimal fw-600">support@ggtech.com</a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</main>

<style>


body {
    filter: brightness(96%);
}
    :root {
        --bg-light: #fdfdfd;
        --accent: #5e72e4;
        --text-dark: #1e293b;
        --input-bg: #f8fafc;
    }

    body.minimal-bg {
        background-color: var(--bg-light);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .fw-700 { font-weight: 700; }
    .fw-800 { font-weight: 800; }
    .tracking-wider { letter-spacing: 0.05em; font-size: 0.7rem; }

    /* Inquiry Card Styling */
    .inquiry-card {
        background: #fff;
        border-radius: 24px;
        padding: 40px;
        border: 1px solid #f1f5f9;
    }

    .icon-circle {
        width: 60px;
        height: 60px;
        background: #f5f7ff;
        color: var(--accent);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    /* Custom Input Styling */
    .custom-input {
        background-color: var(--input-bg);
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }

    .custom-input:focus {
        background-color: #fff;
        border-color: var(--accent);
        box-shadow: 0 0 0 4px rgba(94, 114, 228, 0.1);
    }

    /* Minimalist Button */
    .btn-inquiry {
        background: var(--text-dark);
        color: #fff;
        border-radius: 12px;
        padding: 14px;
        font-weight: 700;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-inquiry:hover {
        background: #000;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        color: #fff;
    }

    .text-primary-minimal {
        color: var(--accent);
        text-decoration: none;
    }

    @media (max-width: 576px) {
        .inquiry-card { padding: 25px; }
    }
	.inquiry-card {
    background: #fff;
    border-radius: 24px;
    padding: 40px;
    border: 1px solid #000;  /* 🔥 Black border */
}

</style>

<?php include("footer.php"); ?>
</body>