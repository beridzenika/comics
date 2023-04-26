<?php 
include 'helpers/db_connection.php';
include 'helpers/functions.php';

session_start();
isGuest();

$id = isset($_GET['id']) && $_GET['id'] ? $_GET['id'] : null; 

//select
if($id) {
    $select_query = $connection->query("SELECT * FROM books WHERE id = " . $id);
    $book = $select_query->fetch_assoc();
    if(!$book) {
        die('Error 404');
    }
} else {
    die('invalid id');
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$book['title']?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<section class="page">
    <header>
        <h3><?=$book['title']?></h3>
    </header>
    <div class="page">
        <img src="<?=$book['image']?>" alt="">
    </div>
    <footer>
        <nav>
            <span class="left_arrow"><?php include 'assets/icons/arrow.svg'?></span>
            <span class="right_arrow"><?php include 'assets/icons/arrow.svg'?></span>
            <!-- <ul>
                <li class="icon btn-panel">
                    panel
                </li>
                <li class="icon btn-zoom">
                    zoom
                </li>
                <li class="icon btn-screen">
                    screen
                </li>
            </ul> -->
        </nav>
    </footer>
</section>
</body>
</html>