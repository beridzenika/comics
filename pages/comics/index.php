<?php 
include('helpers/db_connection.php');
include('helpers/functions.php');

//paging
$limit = 5;

//section
$comicSections = [
    ['title' => 'უახლესი', 'sortBy' => 'published DESC'],
    ['title' => 'ყველაზე ნახვადი', 'sortBy' => 'peopleRating DESC', 'condition' => 'peopleRating > 0'],
    ['title' => 'უფასო კომიქსები', 'sortBy' => 'price DESC', 'condition' => 'price = 0'],
];
$btnId = 0;
//head
$pageTitle = "ჭაბუკის კომიქსები";
?>

<?php include('components/head.php')?>
    <?php include('components/header.php')?>
    <main>
        <?php foreach($comicSections as $section): ?>
        <div class="comic-section" id="comic-container-<?=$btnId?>">
            <?php
            //select
            $sqlCon = condition($section) . " ORDER BY ". $section['sortBy'];
            $query = $connection->query("SELECT * FROM books WHERE status = 1 " . search('AND') . " " . $sqlCon . " LIMIT ". $limit);
            $books = $query->fetch_all(MYSQLI_ASSOC);

            //count
            $total = $connection->query("SELECT COUNT(*) AS cnt FROM books WHERE status = 1 ". search('AND') . " " . $sqlCon);
            $count = $total->fetch_assoc();

            foreach ($books as $book) {
                $user = isset($_GET['user']) ? $_GET['user'] : '';
                searchRelocate($count, $user, $book['id']);
            }

            $booksNum = $count['cnt'];
            if($booksNum > 0):
            ?>
            <h2><?=$section['title']?></h2>
            <div class="comic-container">
                <?php foreach($books as $book): ?>
                <div class="comic-box">
                    <a class="img-link" href="?action=issue&id=<?=$book['id']?>">
                        <img src="<?=$book['image']?>" alt="">
                    </a>
                    <div class="text">
                        <a href="?action=issue&id=<?=$book['id']?>">
                            <span class="title"><?=$book['title']?></span>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php
                if ($booksNum > $limit):
            ?>
            <button id="more-btn-<?=$btnId?>" onclick="loadMore(<?=$btnId?>)">მეტის ნახვა</button>
            <?php
                $btnId++;
                endif;
            endif; 
            ?>
        </div>
        <?php endforeach; ?>
    </main>

    <?php include('components/footer.php')?>
<?php include('components/foot.php')?>