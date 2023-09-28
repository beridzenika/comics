<?php 
include('helpers/db_connection.php');
include('helpers/functions.php');
include ('config.php');

//paging
$limit = 5;

//boolean
$searchRelocateDone = false;
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
        <div class="comic-section">
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
            if (!$searchRelocateDone) {
                foreach ($books as $book) {
                    $user = isset($_GET['user']) ? $_GET['user'] : '';
                    searchRelocate($count, $user, $book['id']);
                }
            }
            $searchRelocateDone = true;

            if($booksNum > 0) {
                $selected = true;
            ?>
            <h2><?=$section['title']?></h2>
            <div class="comic-container" id="comic-container-<?=$sectionId?>">
                <?php 
                include('components/comic_container.php');
                if ($booksNum > $limit):
                ?>
            </div>
            <div id="load-btn-holder-<?=$sectionId?>">
                <input type="hidden" id="load-page" value="1">
                <input type="hidden" id="books-num" value="<?=$booksNum?>">
                <input type="hidden" id="limit" value="<?=$limit?>">
                <input type="hidden" id="search" value="<?=isset($_GET['search']) ? $_GET['search'] : ''?>">
                <button id="load-btn-<?=$sectionId?>" onclick="loadMore(<?=$sectionId?>, 'index')">მეტის ნახვა</button>
            </div>
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