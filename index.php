<?php
    if(isset($_GET['user']) && $_GET['user']) {
        $user = $_GET['user'].'/';
        $styleLink = 'assets/admin_resources/css/style.css';
        $scriptLink = 'assets/admin_resources/js/script.js';
    } else {
        $user = null;
        $scriptLink = 'assets/js/script.js';
        $styleLink = 'assets/css/style.css';
    }
    if(isset($_GET['page']) && $_GET['page']) {
        $page = $_GET['page'];
    } else {
        $page = 'comics';
    }

    if(isset($_GET['action']) && $_GET['action']) {
        $action = $_GET['action'];
    } else {
        $action = 'index';
    }

    include 'pages/'.$user.$page.'/'.$action.'.php';

?>