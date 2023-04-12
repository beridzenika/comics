<?php 
include('helpers/db_connection.php');
include('helpers/functions.php');


$id = isset($_GET['id']) && $_GET['id'] ? $_GET['id'] : null; 

// select
if($id) {
    $select_query = $connection->query("SELECT * FROM books WHERE id = " . $id);
    $book = $select_query->fetch_assoc();
    if(!$book) {
        die('Error 404');
    }
} else {
    die('invalid id');
}

// update
if(isset($_POST['action']) && $_POST['action'] == 'update') {
    list($title, $published, $writer, $artist, $description, $image, $status) = actionData($connection);

    if($title && $published && $writer && $artist && $description && $image) {

        $query = $connection->prepare("UPDATE books SET title = ?, published = ?, writer = ?, artist = ?, description = ?, image = ?, status = ? WHERE id = ?");
        $query->bind_param('ssssssss',$title, $published, $writer, $artist, $description, $image, $status, $id);
        print_r($query);
        if($query->execute()) {
            header('Location: admin.php');
        } else {
            print_r($connection->error);
            echo "Error";
        }
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ჭაბუკის კომიქსები | დამატება</title>
    <link rel="stylesheet" href="assets/admin_resources/css/style.css">
</head>
<body>
    <?php include('components/header.php')?>

    <main>
        <div class="container-header">
            <h2>კომიქსი #<?= $book['id'] ?></h2>
        </div>
        <div class="comic-container">
            <form action="" method="post">
                <div class="left-grid">
                    <div class="form-group">
                        <div class="image" style="background-image: url('<?= $book['image'] ?>');"></div>
                        <label for="">ყდა</label>
                        <textarea name="image" id="" cols="30" rows="10"><?= $book['image'] ?></textarea>
                    </div>
                </div>
                <div class="right-grid">
                    <div class="form-group">
                        <label for="">სათაური</label>
                        <input type="text" name="title" value="<?= $book['title'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="">გამოცემის თარიღი</label>
                        <input type="date" name="published" value="<?= $book['published'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="">მწერალი</label>
                        <input type="text" name="writer" value="<?= $book['writer'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="">მხატვარი</label>
                        <input type="text" name="artist" value="<?= $book['artist'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="">აღწერილობა</label>
                        <textarea name="description" id="" cols="30" rows="10"><?= $book['description'] ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">სტატუსი</label>
                        <select name="status" id="">
                            <option value="1" <?= $book['status'] == 1 ? 'selected' : '' ?>>მოქმედი</option>
                            <option value="0" <?= $book['status'] == 0 ? 'selected' : '' ?>>უმოქმედო</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="action" value="update">
                        <button class="btn submit">განაახლე</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
    
    <script src="assets/admin_resources/js/script.js"></script>
</body>
</html>
