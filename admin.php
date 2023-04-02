<?php include('helpers/db_connection.php') ?>

<?php
//delete
if(isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = $_POST['id'];

    $sql = "DELETE FROM books where id = " .$id;

    if(mysqli_query($conn, $sql)) {
    } else {
        echo "Error";
    }
}
//search
if(isset($_GET['search']) && $_GET['search']) {
    $search_value = $_GET['search'];
    $titleLike = "WHERE title LIKE '%" . $search_value . "%'";
} else {
    $titleLike = '';
}

//select
$sql = "SELECT * FROM books " . ($titleLike ? $titleLike : '') . " ORDER BY books.id DESC";
$result = mysqli_query($conn, $sql);
$books = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ჭაბუკის კომიქსები | ადმინი</title>
    <link rel="stylesheet" href="assets/admin_resources/css/style.css">
</head>
<body>
    <?php include('components/header.php')?>

    <main>
        <div class="container-header">
            <h2>კომიქსები</h2>
            <a href="form.php" class="btn">დაამატე</a>
        </div>
        <table class="comic-container">
            <?php foreach($books as $book): ?>
                <tr class="comic-box">
                    <td><img src="<?=$book['image']?>" alt=""></td>
                    <td><span class="title"><?=$book['title']?></span></td>
                    <td>
                        <?php if($book['status'] == 1){ ?>
                            <span class="active">მოქმედი</span>
                        <?php } else { ?>
                            <span class="inactive">უმოქმედო</span>
                        <?php } ?>
                    </td>
                    <td class="actions">
                        <a class="edit" href="edit.php?id=<?= $book['id'] ?>">შეცვლა</a>
                        <form action="" method="post">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $book['id'] ?>">
                            <button class="delete" onclick="return confirm('მართლა გინდა წაშლა?')">წაშლა</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>
</body>
</html>