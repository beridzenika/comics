<?php 
include('helpers/db_connection.php');
include('helpers/functions.php');

session_start();

$id = isset($_GET['id']) && $_GET['id'] ? $_GET['id'] : null;
$userId = isset($_SESSION['userid']) && $_SESSION['userid'] ? $_SESSION['userid'] : null;

//select
if($id) {
    $select_query = $connection->query("SELECT * FROM books WHERE id = " . $id);
    $issue = $select_query->fetch_assoc();
    if(!$issue) {
        die('Error 404');
    }
} else {
    die('invalid id');
}
// select books
    $limit = 5;
    $similTitle = explode('#',$issue['title'])[0];
    $query = $connection->query("SELECT * FROM books WHERE status = 1 AND title LIKE '%" . $similTitle . "%' AND title != '" . $issue['title'] . "' ORDER BY published ASC LIMIT ". $limit);
    $books = $query->fetch_all(MYSQLI_ASSOC);
// books num
    $total = $connection->query("SELECT COUNT(*) AS cnt FROM books WHERE status = 1 AND title LIKE '%" . $similTitle . "%'");
    $count = $total->fetch_assoc();
    $booksNum = $count['cnt'] - 1;

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

        $issueRates = $connection->query('SELECT rate FROM rates WHERE book = '.$id);
        $issueRates = $issueRates->fetch_all(MYSQLI_ASSOC);
        $issueRates = array_column($issueRates, 'rate');
        $stars = array_sum($issueRates);
        $peopleRating = count($issueRates);


        $issueQuery = $connection->prepare("UPDATE books SET stars = ?, peopleRating = ? WHERE id = ?");
        $issueQuery->bind_param('iis', $stars, $peopleRating, $id);

        if($issueQuery->execute()) {
            header('Location: ?action=issue&id=' . $id);
        } else {
            print_r($connection->error);
            echo "Error";
        }
    }
}

//average stars
if($issue['stars'] != 0 && $issue['peopleRating'] != 0) {
    $ratedStars = $issue['stars'] / $issue['peopleRating'];
} else {
    $ratedStars = $issue['stars'];
}

//head
$pageTitle = $issue['title'] . " | კომიქსის სერია";
?>

<?php include('components/head.php')?>
    <?php include('components/header.php')?>

    <div class="issue-nav">
        <div class="issues">
            <?php if ($issue['prev_issue'] > 0) :?>
                <a class="left_arrow" href="?action=issue&id=<?=$issue['prev_issue']?>">
                  <?php include 'assets/icons/arrow.svg'?>
                    <span class="text">წინა</span>
                </a>
            <?php endif?>
            <?php if ($issue['next_issue'] > 0) :?>
                <a class="right_arrow" href="?action=issue&id=<?=$issue['next_issue']?>">
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
                    <img src="<?=$issue['image']?>" alt="">
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
                    <h1><?=$issue['title']?></h1>
                    <div class="info">
                        <strong>გამოცემის თარიღი:</strong>
                        <span><?=date('F j, Y', strtotime($issue['published']))?></span>
                    </div>
                    <div class="info">
                        <strong>მწერალი:</strong>
                        <span><?=$issue['writer']?></span>
                    </div>
                    <div class="info">
                        <strong>მხატვარი:</strong>
                        <span><?=$issue['artist']?></span>
                    </div>
                    <div class="info">
                        <p><?=$issue['description']?></p>
                    </div>
                    <div class="issue-link">
                        <a href="?action=comic&id=<?= $issue['id'] ?>">წაიკითხე</a>
                    </div>
                </div>
            </div>
        </section>

        <div class="comic-section">
            <h2>ამავე სერიიდან</h2>
            <div class="comic-container">
                <?php include('components/comic_container.php')?>
            </div>
            <?php
                if ($booksNum > $limit):
            ?>
            <button id="more-btn" onclick="loadMore('')">მეტის ნახვა</button>
            <?php
                endif; 
            ?>
        </div>
    </main>

    <?php include('components/footer.php')?>
<?php include('components/foot.php')?>