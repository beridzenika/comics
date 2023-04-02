<?php include('helpers/db_connection.php') ?>

<?php
    // insert
    if(isset($_POST['action']) && $_POST['action'] == 'insert') {
        $title = isset($_POST['title']) ? $_POST['title'] : '' ;
        $published = isset($_POST['published']) ? $_POST['published'] : '' ;
        $writer = isset($_POST['writer']) ? $_POST['writer'] : '' ;
        $artist = isset($_POST['artist']) ? $_POST['artist'] : '' ;
        $description = isset($_POST['description']) ? $_POST['description'] : '' ;
        $image = isset($_POST['image']) ? $_POST['image'] : '' ;
        $status = isset($_POST['status']) ? $_POST['status'] : '' ;

        if($title && $published && $writer && $artist && $description && $image) {

            $sql = "INSERT INTO `books`(`title`, `published`, `writer`, `artist`, `description`, `image`, `status`) VALUES ('$title', '$published', '$writer', '$artist', '$description', '$image',  '$status')";
            
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
            <h2>კომიქსი</h2>
        </div>
        <div class="comic-container">
            <form action="" method="post">
                <div class="left-grid">
                    <div class="form-group">
                        <div class="image" style="background-image: url('<?= $book['image'] ?>');"></div>
                        <label for="">ყდა</label>
                        <textarea name="image" id="" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="right-grid">
                    <div class="form-group">
                        <label for="">სათაური</label>
                        <input type="text" name="title">
                    </div>
                    <div class="form-group">
                        <label for="">გამოცემის თარიღი</label>
                        <input type="date" name="published">
                    </div>
                    <div class="form-group">
                        <label for="">მწერალი</label>
                        <input type="text" name="writer">
                    </div>
                    <div class="form-group">
                        <label for="">მხატვარი</label>
                        <input type="text" name="artist">
                    </div>
                    <div class="form-group">
                        <label for="">აღწერილობა</label>
                        <textarea name="description" id="" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">სტატუსი</label>
                        <select name="status" id="">
                            <option value="1">მოქმედი</option>
                            <option value="0">უმოქმედო</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="action" value="insert">
                        <button class="btn submit">დაამატე</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
    
    <script src="assets/admin_resources/js/script.js"></script>
</body>
</html>