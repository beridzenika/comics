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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <section class="page">
        <header>
            <h3><?=$book['title']?></h3>
        </header>
        <div id="page_image_container" class="page">
<!--image-->
        </div>
        <footer>
            <nav>
                <button id="left_arrow" class="left_arrow"><?php include 'assets/icons/arrow.svg'?></button>
                <button id="right_arrow" class="right_arrow"><?php include 'assets/icons/arrow.svg'?></button>
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
                <div class="rating">
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                </div>
            </nav>
        </footer>
    </section>
    <section class="comic-pages-holder">
        <input type="hidden" id="comicPages" value='<?=$book['pages'] ?>'>
    </section>
<script src="assets/js/script.js"></script>
</body>
</html>