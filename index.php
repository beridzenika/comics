<?php include('helpers/db_connection.php') ?>

<?php
//search
if(isset($_GET['search']) && $_GET['search']) {
    $search_value = $_GET['search'];
    $titleLike = "AND title LIKE '%" . $search_value . "%'";
} else {
    $titleLike = '';
}

//select
$sql = "SELECT * FROM books WHERE status = 1 " . ($titleLike ? $titleLike : '') . " ORDER BY books.id DESC";
$result = mysqli_query($conn, $sql);
$books = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ჭაბუკის კომიქსები</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    
    <?php include('components/header.php')?>
    <!-- <?php include('login.php') ?> -->

    <main>
        <h2>კომიქსები</h2>
        <div class="comic-container">
            <?php foreach($books as $book): ?>
            <div class="comic-box">
                <a href="comic.php?id=<?= $book['id'] ?>"><img src="<?=$book['image']?>" alt=""></a>
                <div class="text">
                    <a href="comic.php?id=<?= $book['id'] ?>">
                        <span class="title"><?=$book['title']?></span>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
    </main>


    <?php include('components/footer.php')?>

    <script src="assets/js/script.js"></script>
</body>
</html>