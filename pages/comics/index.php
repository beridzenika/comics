<?php 
include('helpers/db_connection.php');
include('helpers/functions.php');
include ('config.php');

//paging
$limit = 5;

//boolean
$searchDone = false;
$selected = false;

//section
$comicSections = $Config['comics_sections'];
$sectionId = 1;
//head
$pageTitle = "ჭაბუკის კომიქსები";
?>

<?php include('components/head.php')?>
    <?php include('components/header.php')?>
    <main>
        <?php foreach($comicSections as $section): ?>
        <div class="comic-section" id="comic-container-<?=$sectionId?>">
            <?php
            //select
            $sqlCon = condition($section) . " ORDER BY ". $section['sortBy'];
            $query = $connection->query("SELECT id, image, title FROM books WHERE status = 1 " . search('AND') . " " . $sqlCon . " LIMIT ". $limit);
            $books = $query->fetch_all(MYSQLI_ASSOC);

            //count
            $total = $connection->query("SELECT COUNT(*) AS cnt FROM books WHERE status = 1 ". search('AND') . " " . $sqlCon);
            $count = $total->fetch_assoc();
            $booksNum = $count['cnt'];

            //search relocate
            if (!$searchDone) {
                foreach ($books as $book) {
                    $user = isset($_GET['user']) ? $_GET['user'] : '';
                    searchRelocate($count, $user, $book['id']);
                }
            }
            $searchDone = true;

            if($booksNum > 0) {
                $selected = true;
            ?>
            <h2><?=$section['title']?></h2>
            
            <?php 
                include('components/comic_container.php');
                if ($booksNum > $limit):
            ?>
                <button id="more-btn-<?=$sectionId?>" onclick="loadMore(<?=$sectionId?>)">მეტის ნახვა</button>
            <?php
                $sectionId++;
                endif;
            } elseif (!$selected) {
            ?>
            <div class="error-404">result not found</div> 
            <?php
            break;
            }
            ?>
        </div>
        <?php endforeach; ?>
    </main>

    <?php include('components/footer.php')?>
<?php include('components/foot.php')?>