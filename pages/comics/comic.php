<?php 
include 'helpers/db_connection.php';
include 'helpers/functions.php';

//isGuest();

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

//head
$pageTitle = $book['title'];
?>

<?php include('components/head.php')?>

    <section class="page" id="comic-page">
        <header id="header">
            <h3><?=$book['title']?></h3>
        </header>
        <div id="page_image_container" class="page">
            <!--image-->
        </div>
        <footer id="footer">
            <nav>
                <span id="left_arrow" class="left_arrow"><?php include 'assets/icons/arrow.svg'?></span>
                <span id="right_arrow" class="right_arrow"><?php include 'assets/icons/arrow.svg'?></span>
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
    <section class="comic-pages-holder">
        <input type="hidden" id="comicPages" value='<?=$book['pages'] ?>'>
    </section>
    
<?php include('components/foot.php')?>