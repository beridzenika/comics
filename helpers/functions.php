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
    $price = isset($_POST['price']) ? $_POST['price'] : '' ;

    return array($title, $published, $writer, $artist, $description, $image, $status, $pages, $price);
}

//search
function search($attach) {
    if(isset($_GET['search']) && $_GET['search']) {
        $searchTerms = explode(" ", $_GET['search']);
        $conditions = array();
        $conditions[] = "title LIKE '%" . $_GET['search'] . "%'";
        $conditions[] = "writer LIKE '%" . $_GET['search'] . "%'";
        $conditions[] = "artist LIKE '%" . $_GET['search'] . "%'";
        $titleLike = $attach . " (" . implode(" OR ", $conditions) . ")";
    } else {
        $titleLike = '';
    }
    return $titleLike;

    if(isset($_GET['search']) && $_GET['search']) {
        $searchTerms = explode(" ", $_GET['search']);
        $cons = array();
        foreach ($searchTerms as $term) {
            $cons[] = "title LIKE '%" . $term . "%'";
            $cons[] = "title LIKE '%" . $term . "%'";
            $cons[] = "title LIKE '%" . $term . "%'";
        }
        $titleLike = $attach . " (" . implode(" OR ", $cons) . ")";
    } else {
        $titleLike = '';
    }
    return $titleLike;
}

//search relocate
function searchRelocate ($count, $user, $id) {
    if (isset($_GET['search']) && isset($_GET['search'])) {
        if (isset($count['cnt']) && $count['cnt'] == 1) {
            if (isset($user) && $user == 'admin') {
                header('Location: index.php?user=admin&page=comics&action=edit&id='.$id);
            } else {
                headers_sent() ?: header('Location: index.php?action=issue&id=' . $id);
            }
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

//prev/next issue generator
function otherIssues($connection, $title, $sign, $orderBy, &$issueName) {
    $similTitle = explode('#',$title)[0];
    $query = $connection->query("SELECT * FROM `books` WHERE title LIKE '" . $similTitle . "%' AND title " . $sign . " '" . $title . "' ORDER BY title " . $orderBy . " LIMIT 1");
    $issue = $query->fetch_assoc();
    $issueName = isset($issue) && $issue ? $issue['id'] : 0;
}

function getComics($ID, $Comics)
{
    $item = array_filter($Comics, function ($item) use ($ID) {
        return $item['id'] == $ID;
    });
    return $item ? reset( $item) : [];
}