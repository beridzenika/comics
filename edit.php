<?php include('helpers/db_connection.php') ?>

<?php

    $id = isset($_GET['id']) && $_GET['id'] ? $_GET['id'] : null; 
    
    if($id) {
        // select
        $select_query = "SELECT * FROM books WHERE id = " . $id;

        $result = mysqli_query($conn, $select_query);
        $book = mysqli_fetch_assoc($result);

        if(!$book) {
            die('student not found');
        }
    } else {
        die('invalid id');
    }

    // update
    if(isset($_POST['action']) && $_POST['action'] == 'update') {
        $title = isset($_POST['title']) ? $_POST['title'] : '' ;
        $published = isset($_POST['published']) ? $_POST['published'] : '' ;
        $writer = isset($_POST['writer']) ? $_POST['writer'] : '' ;
        $artist = isset($_POST['artist']) ? $_POST['artist'] : '' ;
        $description = isset($_POST['description']) ? $_POST['description'] : '' ;
        $image = isset($_POST['image']) ? $_POST['image'] : '' ;
        $status = isset($_POST['status']) ? $_POST['status'] : '' ;

        if($title && $published && $writer && $artist && $description && $image) {

            $sql = "UPDATE books SET title = '$title', published = '$published', writer = '$writer', artist = '$artist', description = '$description', image = '$image', status = '$status' WHERE id = ".$id;

            if(mysqli_query($conn, $sql)) {
                header('Location: admin.php');
            } else {
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
                            <option value="1" <?php echo $book['status'] == 1 ? 'selected' : '' ?>>მოქმედი</option>
                            <option value="0" <?php echo $book['status'] == 0 ? 'selected' : '' ?>>უმოქმედო</option>
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
