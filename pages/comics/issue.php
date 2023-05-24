<?php 
include('helpers/db_connection.php');
include('helpers/functions.php');

session_start();

$id = isset($_GET['id']) && $_GET['id'] ? $_GET['id'] : null;
$email = isset($_SESSION['email']) && $_SESSION['email'] ? $_SESSION['email'] : null;

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
    $user_query = $connection->query('SELECT `rates` FROM `users` WHERE email = "'.$email.'"');
    $user = $user_query->fetch_assoc();

    if(isset($_POST['starsNum'])) {

        $star = isset($_POST['starsNum']) ? $_POST['starsNum'] : '' ;
        $rating = isset($_POST['peopleRating']) ? $_POST['peopleRating'] : '' ;
        $userRate = isset($user['rates']) ? $user['rates'] : '';

        $userRateArray = json_decode($userRate, true);

        foreach ($userRateArray as $key => $element) {
            if ($element['issue'] == $id) {
                $number = $element['number'];
                unset($userRateArray[$key]);
            }
        }
        $ratedArray[] = ['issue' => $id, 'number' => $star];

        if (isset($ratedArray)) {
            if ($userRateArray !== null) {
                $mergedArray = array_merge($userRateArray, $ratedArray);
                $userRate = json_encode($mergedArray);
            } else {
                $userRate = json_encode($ratedArray);
            }
        }
        if(isset($number)){
            $stars = $book['stars'] + $star - $number;
            $peopleRating = $book['peopleRating'];
        } else {
            $stars = $book['stars'] + $star;
            $peopleRating = $book['peopleRating'] + 1;
        }

        $bookQuery = $connection->prepare("UPDATE books SET stars = ?, peopleRating = ? WHERE id = ?");
        $bookQuery->bind_param('iis', $stars, $peopleRating, $id);
        
        $userQuery = $connection->prepare("UPDATE users SET rates = ? WHERE email = ?");
        $userQuery->bind_param('ss', $userRate, $email);
        
        if($userQuery->execute() && $bookQuery->execute()) {
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
    
    <main>
        <section class="issue-holder">
            <div class="issue-info">
                <div class="left-section">
                    <img src="<?=$book['image']?>" alt="">
                    <form id="rateform" method="post">
                        <input type="hidden" name="starsNum" id="rate-star">
                        <div class="rating">
                            <?php for($i = 1; $i <= 5; $i++) : ?>
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
                        <a href="?action=comic&id=<?= $book['id'] ?>">წაიკითხე</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include('components/footer.php')?>
<?php include('components/foot.php')?>