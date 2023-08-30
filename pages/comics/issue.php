<?php 
include('helpers/db_connection.php');
include('helpers/functions.php');

session_start();

$id = isset($_GET['id']) && $_GET['id'] ? $_GET['id'] : null;
$userId = isset($_SESSION['userid']) && $_SESSION['userid'] ? $_SESSION['userid'] : null;

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
if (isset($_SESSION['logedin']) && $_SESSION['logedin']) {
    $rates_query = $connection->query('SELECT * FROM rates WHERE user_id = "'.$userId.'" AND book = "'.$id.'"');
    $rate_table = $rates_query->fetch_assoc();

    if(isset($_POST['starsNum'])) {

        $star = isset($_POST['starsNum']) ? $_POST['starsNum'] : '' ;
        $rating = isset($_POST['peopleRating']) ? $_POST['peopleRating'] : '' ;

        if (isset($rate_table)) {
            $rateQuery = $connection->prepare('UPDATE rates SET rate = ? WHERE id = "' .$rate_table['id'].'"');
            $rateQuery->bind_param('i', $star);
        } else {
            $rateQuery = $connection->prepare("INSERT INTO rates (`user_id`, `book`, `rate`) VALUES (?,?,?)");
            $rateQuery->bind_param('iii', $userId, $id, $star);
        }

        if (!$rateQuery->execute()) {
            die('Error');
        }

        $bookRates = $connection->query('SELECT rate FROM rates WHERE book = '.$id);
        $bookRates = $bookRates->fetch_all(MYSQLI_ASSOC);
        $bookRates = array_column($bookRates, 'rate');
        $stars = array_sum($bookRates);
        $peopleRating = count($bookRates);


        $bookQuery = $connection->prepare("UPDATE books SET stars = ?, peopleRating = ? WHERE id = ?");
        $bookQuery->bind_param('iis', $stars, $peopleRating, $id);

        if($bookQuery->execute()) {
            header('Location: ?action=issue&id=' . $id);
        } else {
            print_r($connection->error);
            echo "Error";
        }
    }
}

//average stars
if($book['stars'] != 0 && $book['peopleRating'] != 0) {
    $ratedStars = $book['stars'] / $book['peopleRating'];
} else {
    $ratedStars = $book['stars'];
}

//head
$pageTitle = $book['title'] . " | კომიქსის სერია";
?>

<?php include('components/head.php')?>
    <?php include('components/header.php')?>

    <div class="issue-nav">
        <div class="issues">
            <?php if ($book['prev_issue'] > 0) :?>
                <a class="left_arrow" href="?action=issue&id=<?=$book['prev_issue']?>">
                    <?php include 'assets/icons/arrow.svg'?>
                    <span class="text">წინა</span>
                </a>
            <?php endif?>
            <?php if ($book['next_issue'] > 0) :?>
                <a class="right_arrow" href="?action=issue&id=<?=$book['next_issue']?>">
                    <span class="text">შემდეგი</span>
                    <?php include 'assets/icons/arrow.svg'?>
                </a>
            <?php endif?>
        </div>
        <a href="https://www.facebook.com/share.php?u=<?= urlencode($_SERVER['REQUEST_URI']) ?>"><?php include 'assets/icons/facebook.svg'?></a>
        <a href="https://twitter.com/share?url=<?= urlencode($_SERVER['REQUEST_URI']) ?>"><?php include 'assets/icons/twitter.svg'?></a>
    </div>
    
    <main>
        <section class="issue-holder">
            <div class="issue-info">
                <div class="left-section">
                    <img src="<?=$book['image']?>" alt="">
                    <form id="rateform" method="post">
                        <input type="hidden" name="starsNum" id="rate-star">
                        <div class="rating">
                            <?php for($i = 1; $i <= 5; $i++) : ?>
                                <span class="fa fa-star <?= $ratedStars >= $i ? "checked" : "" ?>" onclick="ajaxRate()"><?php include 'assets/icons/star.svg'?></span>
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
                        <a href="?action=comic&id=<?= $book['id'] ?>">წაიკითხე</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include('components/footer.php')?>
<?php include('components/foot.php')?>