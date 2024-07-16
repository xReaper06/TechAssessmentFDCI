<?php include "./public/includes/header.php";
$app = "<script src='./src/assets/js/login.js'></script>"
?>
<div class="form-container">
    <h2 class="text-center">Sign In</h2>
    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="text" class="form-control" id="login-email">
    </div>

    <div class="form-group spacing">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="login-password">
    </div>
    <div class="btn-group spacing">
        <button class="submit-btn" id="login-btn">Submit</button>
    </div>
    <a href="./registration.php">Sign Up</a>
</div>

<?php include "./public/includes/footer.php"; ?>