<?php
include('../helpers/db_connection.php');
include('../helpers/functions.php');
include ('../config.php');


$Page = $_GET['page'];
$issue = $_GET['search'];
$Limit = 5;
$Offset = $Page * $Limit;

$similTitle = explode('#',$issue)[0];
$query = $connection->query("SELECT * FROM books WHERE status = 1 AND title LIKE '%" . $similTitle . "%' AND title != '" . $issue . "' ORDER BY published ASC LIMIT ". $Limit . " OFFSET " . $Offset);
$books = $query->fetch_all(MYSQLI_ASSOC);
include('../components/comic_container.php');