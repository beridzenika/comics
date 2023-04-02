<?php include('helpers/db_connection.php') ?>

<?php  
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
     $url = "https://";   
else  
     $url = "http://";   
   
$url.= $_SERVER['REQUEST_URI'];    
  
echo $url;  

//select
$sql = "SELECT * FROM books";
$result = mysqli_query($conn, $sql);
$books = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include('components/header.php')?>
  

</body>
</html>