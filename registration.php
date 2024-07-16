<?php include "./public/includes/header.php";
$app = "<script src='./src/assets/js/registration.js'></script>";
?>
<div class="form-container">
    <span id="error-message"></span>
    <h2 class="text-center">Registration</h2>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="registration-name">
    </div>
    <div class="form-group spacing">
        <label for="email">Email Address</label>
        <input type="email" class="form-control" id="registration-email">
    </div>

    <div class="form-group spacing">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="registration-password">
    </div>
    <div class="form-group spacing">
        <label for="password">Confirm Password</label>
        <input type="password" class="form-control" id="registration-confirmpassword">
    </div>
    <div class="btn-group spacing">
        <button class="submit-btn" type="button" id="reg-btn">Submit</button>
    </div>
    <a href="./registration.php">Sign Up</a>
</div>

<?php include "./public/includes/footer.php"; ?>