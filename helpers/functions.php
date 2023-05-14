<?php
//data cetchion
function actionData($connection) {
    $title = isset($_POST['title']) ? $_POST['title'] : '' ;
    $published = isset($_POST['published']) ? $_POST['published'] : '' ;
    $writer = isset($_POST['writer']) ? $_POST['writer'] : '' ;
    $artist = isset($_POST['artist']) ? $_POST['artist'] : '' ;
    $description = isset($_POST['description']) ? $_POST['description'] : '' ;
    $image = isset($_POST['image']) ? $_POST['image'] : '' ;
    $status = isset($_POST['status']) ? $_POST['status'] : '' ;
    $pages = isset($_POST['images']) ? json_encode($_POST['images']) : '' ;
    $prevIssue = isset($_POST['prev_issue']) ? $_POST['prev_issue'] : '' ;
    $nextIssue = isset($_POST['next_issue']) ? $_POST['next_issue'] : '' ;

    return array($title, $published, $writer, $artist, $description, $image, $status, $pages, $prevIssue, $nextIssue);
}

//search
function search($attach) {
    if(isset($_GET['search']) && $_GET['search']) {
        $titleLike = $attach . " title LIKE '%" . $_GET['search'] . "%'";
    } else {
        $titleLike = '';
    }
    return $titleLike;
}
//logged admin/guest
function isAdmin() {
    if( !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
        header('location: index.php');
    }
}
//
//function isGuest() {
//    if( isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
//        header('location: index.php');
//    }
//}


//sort
function GetSortBy($SortID) {
    switch ($SortID) {
        case 1: return 'id ASC';
        case 2: return 'title DESC';
        case 3: return 'title ASC';
        case 4:  return 'price DESC';
        case 5: return 'price ASC';
        default: return 'id DESC';
    }
}