<?php
session_start();
include "admin/db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$uid = $_SESSION['user_id'];

/* update profile */
if(isset($_POST['update'])){

    $name   = mysqli_real_escape_string($db,$_POST['name']);

    $mobile = mysqli_real_escape_string($db,$_POST['mobile']);
    $pass   = $_POST['password'];

    $data = [
        "name"=>$name,
        "mobile"=>$mobile
    ];

    if(!empty($pass)){
        $data["password"] = password_hash($pass,PASSWORD_DEFAULT);
    }

    update($db,"users_registration",$data,"WHERE id='$uid'");

    $_SESSION['success']="Profile updated successfully ✓";
    header("Location: edit_user.php");
    exit;
}

/* fetch user */
$res = get($db,"*","users_registration","WHERE id='$uid'","");
$user = mysqli_fetch_assoc($res);

include "header.php";
?>

<main class="flex-fill d-flex align-items-center py-5">
<div class="container">
<div class="row justify-content-center">
<div class="col-xl-5 col-lg-6 col-md-8">

<div class="inquiry-card shadow-sm">

<div class="text-center mb-5">
<div class="icon-circle mb-3">
<i class="far fa-user"></i>
</div>
<h2 class="fw-800 text-dark mb-2">Edit Profile</h2>
</div>


<?php if(isset($_SESSION['success'])): ?>
<div class="alert-success-box">
<?= $_SESSION['success']; ?>
</div>

<script>
setTimeout(()=>{
    window.location="index.php";
},1500);
</script>

<?php unset($_SESSION['success']); endif; ?>


<form method="post">

<label>Name</label>
<input type="text" name="name" class="custom-input"
value="<?= $user['name'] ?>" required>

<label>Email</label>
<input type="email"
value="<?= $user['email'] ?>"
class="custom-input"
disabled>



<label>Mobile</label>
<input type="text" name="mobile" class="custom-input"
value="<?= $user['mobile'] ?>" required>

<label>New Password <span>(leave blank to keep same)</span></label>
<input type="password" name="password" class="custom-input">

<button type="submit" name="update" class="btn btn-inquiry w-100">
Update Profile
</button>

</form>

</div>
</div>
</div>
</div>
</main>



<style>
:root{
    --accent:#5e72e4;
    --text-dark:#1e293b;
    --input-bg:#f8fafc;
}

/* card */
.inquiry-card{
    background:#fff;
    border-radius:24px;
    padding:40px;
    border:1px solid #000;
}

/* icon */
.icon-circle{
    width:60px;
    height:60px;
    background:#f5f7ff;
    color:var(--accent);
    border-radius:50%;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    font-size:1.4rem;
}

/* labels */
label{
    font-size:.75rem;
    font-weight:700;
    color:#64748b;
    margin-top:15px;
}

/* inputs */
.custom-input{
    width:100%;
    padding:12px 16px;
    border-radius:12px;
    border:1px solid #e2e8f0;
    background:var(--input-bg);
    margin-top:5px;
    transition:.2s;
}

.custom-input:focus{
    outline:none;
    background:#fff;
    border-color:var(--accent);
    box-shadow:0 0 0 4px rgba(94,114,228,.1);
}

/* button */
.btn-inquiry{
    background:var(--text-dark);
    color:#fff;
    border-radius:12px;
    padding:14px;
    font-weight:700;
    margin-top:20px;
    border:none;
    transition:.25s;
}

.btn-inquiry:hover{
    background:#000;
    transform:translateY(-2px);
}

/* success msg */
.alert-success-box{
    background:#ecfdf5;
    color:#065f46;
    padding:12px;
    border-radius:12px;
    font-size:.9rem;
    margin-bottom:20px;
    text-align:center;
    font-weight:600;
    animation:fadeIn .3s ease;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(-5px);}
    to{opacity:1;}
}
</style>

<?php include "footer.php"; ?>
