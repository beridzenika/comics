<?php 
include('helpers/db_connection.php');
include('helpers/functions.php');

//sort
$SortType = isset($_GET['sort']) && $_GET['sort'] ? $_GET['sort'] : 0;
$sortBy = GetSortBy($SortType);

//paging
$limit = 5;
$offset = '';
if(isset($_GET['pg']) && $_GET['pg'] && $_GET['pg'] > 1) {
    $offset = ' OFFSET ' . ($_GET['pg'] - 1) * $limit;
}
$total = $connection->query("SELECT COUNT(*) as cnt FROM books");
$count = $total->fetch_assoc();

$pageNumber = ceil($count['cnt'] / $limit);

//select
// $query = $connection->query("SELECT * FROM books WHERE status = 1 " . search("AND") . "ORDER BY books.id DESC");
$query = $connection->query("SELECT * FROM books WHERE status = 1 " . search("AND") . "ORDER BY ".$sortBy ." LIMIT ". $limit ."". $offset);
$books = $query->fetch_all(MYSQLI_ASSOC);

//head
$pageTitle = "ჭაბუკის კომიქსები";
?>

<?php include('components/head.php')?>
    <?php include('components/header.php')?>

    <form action="">
        <div class="form-group">
            <select name="sort" id="" onchange="this.form.submit()">
                <option value="0" <?=$SortType == "0" ? "selected" : ""?>>თარიღი კლებადობით</option>
                <option value="1" <?=$SortType == "1" ? "selected" : ""?>>თაროღი მატობით</option>
                <option value="2" <?=$SortType == "2" ? "selected" : ""?>>სათაური კლებადობით</option>
                <option value="3" <?=$SortType == "3" ? "selected" : ""?>>სათაური მატობით</option>
                <option value="4" <?=$SortType == "4" ? "selected" : ""?>>ფასი კლებადობით</option>
                <option value="5" <?=$SortType == "5" ? "selected" : ""?>>ფასი მატობით</option>
            </select>
        </div>
    </form>
    <main>
        <h2>კომიქსები</h2>
        <div class="comic-container">
            <?php foreach($books as $book): ?>
            <div class="comic-box">
                <a href="?action=issue&id=<?=$book['id']?>">
                    <img src="<?=$book['image']?>" alt="">
                </a>
                <div class="text">
                    <a href="?action=issue&id=<?=$book['id']?>">
                        <span class="title"><?=$book['title']?></span>
                    </a>
                </div>
                <div class="rating">
                    <?php for($i = 1; $i <= 5; $i++) : ?>
                    <?php 
                        if($book['stars'] != 0 && $book['peopleRating'] != 0) {
                            $ratedStars = $book['stars'] / $book['peopleRating'];
                        } else {
                            $ratedStars = 5;
                        }
                    ?>
                       <span class="fa-star <?= $ratedStars >= $i ? "checked" : "" ?>"><?php include 'assets/icons/star.svg'?></span>
                    <?php endfor; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <div class="paging">
        <?php for($i = 1; $i <= $pageNumber; $i++): ?>
            <a href="?pg=<?= $i ?>&sort=<?= $SortType ?>" class="btn"><?= $i ?></a>
        <?php endfor; ?>
    </div>

    <?php include('components/footer.php')?>
<?php include('components/foot.php')?>