<?php include "./public/includes/header.php";
$app = "<script src='./src/assets/js/contactPage.js'></script>";
?>
<input type="text" id="search" placeholder="Search">
<table>
    <thead>
        <tr>
            <th>NAME</th>
            <th>COMPANY</th>
            <th>PHONE</th>
            <th>Email</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="tables-append"></tbody>
</table>
<div id="pagination-controls">
    <button id="prevPage" onclick="prevPage()">Previous</button>
    <span id="pageInfo"></span>
    <button id="nextPage" onclick="nextPage()">Next</button>
</div>


<?php include "./public/includes/footer.php"; ?>