<?php include "./public/includes/header.php";
$app = "<script src='./src/assets/js/editContact.js'></script>";
?>

<div class="form-container">
    <span id="error-message"></span>
    <h2 class="text-center">Edit Contract</h2>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" required>
    </div>
    <div class="form-group spacing">
        <label for="company">Company</label>
        <input type="text" class="form-control" id="company">
    </div>

    <div class="form-group spacing">
        <label for="phone">Phone</label>
        <input type="text" class="form-control" id="phone">
    </div>
    <div class="form-group spacing">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email">
    </div>
    <div class="btn-group spacing">
        <button class="submit-btn" type="button" id="update-btn">Submit</button>
    </div>

</div>

<?php include "./public/includes/footer.php"; ?>