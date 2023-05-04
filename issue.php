<?php 
include('helpers/db_connection.php');
include('helpers/functions.php');

session_start();

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

//rating
if ($_SESSION['logedin']) {
    if(isset($_POST['action'])) {
        $star = isset($_POST['action']) ? $_POST['action'] : '' ;
        $rating = isset($_POST['peopleRating']) ? $_POST['peopleRating'] : '' ;

        $stars = $book['stars'] + $star;
        $peopleRating = $book['peopleRating'] + 1;

        $query = $connection->prepare("UPDATE books SET stars = ?, peopleRating = ? WHERE id = ?");
        $query->bind_param('sss', $stars, $peopleRating, $id);
    }
}
//head
$pageTitle = $book['title'] . " | კომიქსის სერია";
$styleLink = 'assets/css/style.css';
?>

<?php include('components/head.php')?>
    <?php include('components/header.php')?>

    <div class="issue-nav">
        <a class="left_arrow">
            <?php include 'assets/icons/arrow.svg'?>
            <span class="text">წინა</span>
        </a>
        <a class="right_arrow">
            <span class="text">შემდეგი</span>
            <?php include 'assets/icons/arrow.svg'?>
        </a>
    </div>
    
    <main>
        <section class="issue-holder">
            <div class="issue-info">
                <div class="left-section">
                    <img src="<?=$book['image']?>" alt="">
                    <form id="rateform" method="post">
                        <input type="hidden" name="action" id="rate-star">
                        <div class="rating">
                            <?php for($i = 1; $i <= 5; $i++) : ?>
                                <?php $ratedStars = $book['stars'] / $book['peopleRating'] ?>
                                <span class="fa fa-star <?= $ratedStars >= $i ? "checked" : "" ?>"><?php include 'assets/icons/star.svg'?></span>
                            <?php endfor ?>
                        </div>
                    </form>
                </div>
                <div class="right-section">
                    <h1><?=$book['title']?></h1>
                    <div class="info">
                        <strong>გამოცემის თარიღი:</strong>
                        <span><?=date('F j, Y', strtotime($book['published']))?></span>
                    </div>
                    <div class="info">
                        <strong>მწერალი:</strong>
                        <span><?=$book['writer']?></span>
                    </div>
                    <div class="info">
                        <strong>მხატვარი:</strong>
                        <span><?=$book['artist']?></span>
                    </div>
                    <div class="info">
                        <p><?=$book['description']?></p>
                    </div>
                    <div class="issue-link">
                        <a href="comic.php?id=<?= $book['id'] ?>">წაიკითხე</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include('components/footer.php')?>
<?php include('components/foot.php')?>