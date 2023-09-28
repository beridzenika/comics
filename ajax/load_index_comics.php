<?php
include('../helpers/db_connection.php');
include('../helpers/functions.php');
include ('../config.php');


$comicSections = $Config['comics_sections'];
$Page = $_GET['page'];
$SectionID = $_GET['section_id'];

$configSection = getComics($SectionID, $comicSections);
$Limit = 5;
$Offset = $Page * $Limit;
$sqlCon = condition($configSection) . " ORDER BY ". $configSection['sortBy'];
$query = $connection->query("SELECT id, image, title FROM books WHERE status = 1 " . search('AND') . " " . $sqlCon . " LIMIT ". $Limit . " OFFSET " . $Offset);
$books = $query->fetch_all(MYSQLI_ASSOC);

include('../components/comic_container.php');