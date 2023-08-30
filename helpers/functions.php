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
    $price = isset($_POST['price']) ? $_POST['price'] : '' ;

    return array($title, $published, $writer, $artist, $description, $image, $status, $pages, $prevIssue, $nextIssue, $price);
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
//search relocate
function searchRelocate ($count, $user, $id) {
    if (isset($count['cnt']) && $count['cnt'] == 1) {
        if (isset($user) && $user == 'admin') {
            header('Location: index.php?user=admin&page=comics&action=edit&id='.$id);
        } else {
            header('Location: index.php?action=issue&id='.$id);
        }
    }
}
//condition
function condition($section) {
    if(isset($section['condition']) && $section['condition']) {
        $condition = "AND " . $section['condition'] . " ";
    } else {
        $condition = '';
    }
    return $condition;
}
//logged admin/guest
function isAdmin() {
    if( !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
        header('location: index.php');
    }
}