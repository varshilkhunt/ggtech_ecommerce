<?php
include "db.php";

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("location:index.php");
}

include "header.php";
?>
<head>
<title>Admin Dashboard | GG TECH</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="admin-bg">
<div class="container">
    
    <main class="main-content-area" style="margin-top: 20px;">
       <img 
            src="https://loremflickr.com/1600/900/car"
            alt="Dashboard"
            class="dash-img"
        >
    </main>
</div>

<script>
    function toggleProfileDropdown() {
        const dropdown = document.getElementById("profileDropdown");
        dropdown.style.display =
            dropdown.style.display === "block" ? "none" : "block";
    }

    window.onclick = function (event) {
        if (!event.target.closest('.profile-photo')) {
            const dropdown = document.getElementById("profileDropdown");
            if(dropdown) {
                dropdown.style.display = "none";
            }
        }
    };
</script>

<style>
body {
    filter: brightness(96%);
}
    :root {
        --bg-color: #f8fafc;
        --text-dark: #1e293b;
    }

    body.admin-bg {
        background-color: var(--bg-color);
        font-family: 'Plus Jakarta Sans', sans-serif;
        margin: 0;
    }

    .container {
        max-width: 1200px;
        margin: auto;
    }

    .main-content-area {
        display: flex; 
        justify-content: center; 
        align-items: center; 
        /* min-height adjusted to prevent excessive vertical stretching */
        min-height: 50vh; 
    }

    .dash-img {
        max-width: 100%;
        max-height: 75vh;
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.12);
        object-fit: cover;
        border: 1px solid rgba(0,0,0,0.05);
        transition: transform 0.4s ease;
    }
    
    .dash-img:hover {
        transform: translateY(-5px);
    }
</style>

</body>
</html>