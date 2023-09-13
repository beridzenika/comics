<?php
include('../helpers/db_connection.php');
include('../helpers/functions.php');
include ('../config.php');


$comicSections = $Config['comics_sections'];
$Page = $_GET['page'];
$SectionID = $_GET['section_id'];

$configSection = getComics($SectionID, $comicSections);
//print_R($configSection);
$Limit = 5;
$Offset = $Page * $Limit - $Page;

$sqlCon = condition($configSection) . " ORDER BY ". $configSection['sortBy'];
$query = $connection->query("SELECT id, image, title FROM books WHERE status = 1 " . search('AND') . " " . $sqlCon . " LIMIT ". $Limit . " OFFSET " . $Offset);
$books = $query->fetch_all(MYSQLI_ASSOC);
include('../components/comic_container.php');
if ($booksNum > $limit):?>
<button id="more-btn-<?=$SectionID?>" onclick="loadMore(<?=$SectionID?>)">მეტის ნახვა</button>
<?php
endif;


//header('Content-Type: application/json; charset=utf-8');
//$Data = $_POST;
//echo json_encode($Data);