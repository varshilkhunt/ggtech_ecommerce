<footer class="mt-5">
    <div class="container-fluid border-top bg-white">
        <div class="row">
            <div class="col-md-12 py-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center container">
                    
                    <p class="footer-text mb-md-0 mb-3">
                        &copy; <?php echo date("Y"); ?> 
                        <a href="index.php" class="footer-brand-link">GG TECH.</a> 
                        <span class="mx-2 text-muted opacity-50">|</span> 
                        All Rights Reserved
                    </p>

                    <p class="footer-text mb-0">
                        Designed with precision by 
                        <span class="designer-name">Khunt VM</span>
                    </p>
                    
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
body {
    filter: brightness(96%);
}
/* Minimalist Footer Styling */
.footer-text {
    font-size: 0.85rem;
    color: #94a3b8; 
    letter-spacing: -0.01em;
}

/* Brand Link Styling */
.footer-brand-link {
    font-weight: 700;
    color: #1e293b;
    text-decoration: none;
    transition: color 0.2s ease;
    margin-left: 4px;
}

.footer-brand-link:hover {
    color: #5e72e4; /* Your theme accent color */
    text-decoration: none;
}

.designer-name {
    color: #1e293b;
    font-weight: 600;
}

.border-top {
    border-top: 1px solid #000 !important;
}


/* Page Layout Fix */
body {
    display: flex;
    flex-direction: column;
    min-height: 100vh; /* Fixed the typo from min-vh-100 */
}

footer {
    margin-top: auto;
}
</style>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>