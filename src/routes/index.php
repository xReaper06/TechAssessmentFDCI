<?php

session_start();
require "../controllers/Controller.php";

if (isset($_POST['method'])) {
    switch ($_POST['method']) {
        case 'register':
            $Controller = new Controller;
            echo $Controller->registration($_POST['name'], $_POST['email'], $_POST['pass']);
            break;
        case 'login':
            $Controller = new Controller;
            echo $Controller->login($_POST['email'], $_POST['pass']);
            break;
        case 'Add':
            $Controller = new Controller;
            echo $Controller->Add($_POST['name'], $_POST['company'], $_POST['phone'], $_POST['email']);
            break;
        case 'Edit':
            $Controller = new Controller;
            echo $Controller->Edit($_POST['id'], $_POST['name'], $_POST['company'], $_POST['phone'], $_POST['email']);
            break;
        case 'Delete':
            $Controller = new Controller;
            echo $Controller->Delete($_POST['id']);
            break;
        case 'Get':
            $Controller = new Controller;
            $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
            $limit = isset($_POST['limit']) ? intval($_POST['limit']) : 10;
            $search = isset($_POST['search']) ? $_POST['search'] : '';
            echo $Controller->getData($page, $limit, $search);
            break;
        case 'getSpecificData':
            $Controller = new Controller;
            echo $Controller->getSpecificData($_POST['id']);
            break;
    }
}