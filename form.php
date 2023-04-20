<?php 
include('helpers/db_connection.php');
include('helpers/functions.php');


// insert
if(isset($_POST['action']) && $_POST['action'] == 'insert') {
    $pages = json_encode($_POST['images']);

    list($title, $published, $writer, $artist, $description, $image, $status) = actionData($connection);

    if($title && $published && $writer && $artist && $description && $image) {

        $query = $connection->prepare("INSERT INTO `books` (`title`, `published`, `writer`, `artist`, `description`, `image`, `status`, `pages`) VALUES (?,?,?,?,?,?,?,?)");
        $query->bind_param('ssssssss',$title, $published, $writer, $artist, $description, $image, $status, $pages);
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
            <h2>კომიქსი</h2>
        </div>
        <form action="" id="comicForm" method="post">
        <div class="comic-container">
                <div class="left-grid">
                    <div class="form-group">
                        <div class="image" style="background-image: url('<?= $book['image'] ?>');"></div>
                        <label for="">ყდა</label>
                        <textarea name="image" cols="30" rows="10"></textarea>
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
                    </div>
                </div>
        </div>
        <div class="container-header">
            <h2>გვერდები</h2>
            <a class="btn" id="pageBtn">დამატება</a>
        </div>
        <div class="page-container">
                <table id="comics-images">
                </table>
                <div class="form-group">
                    <input type="hidden" name="action" value="insert">
                </div>
        </div>
        <div class="form-sub" id="formSub">
            <input type="hidden" name="action" value="insert">
            <button class="btn submit">ატვირთვა</button>
        </div>
    </form>
    </main>
    
    <script src="assets/admin_resources/js/script.js"></script>
</body>
</html>