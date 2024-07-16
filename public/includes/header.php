<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technical Interview</title>
    <link rel="stylesheet" href="./src/assets/css/style.css">
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION['name']) && isset($_SESSION['email'])) {
    ?>
    <h1 class="page-header"></h1>
    <nav><a href="./addContact.php" class='navlink-add'>Add Contact</a>
        <a href="./contact.php" class='navlink-main'>Contacts</a>
        <a href="#">Log Out</a>
    </nav>
    <?php
    } else {
        echo "Session variables 'name' and 'email' are not set.";
    }
    ?>