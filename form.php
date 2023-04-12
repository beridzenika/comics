<?php 
include('helpers/db_connection.php');
include('helpers/functions.php');


// insert
if(isset($_POST['action']) && $_POST['action'] == 'insert') {
    list($title, $published, $writer, $artist, $description, $image, $status) = actionData($connection);

    if($title && $published && $writer && $artist && $description && $image) {

        $query = $connection->prepare("INSERT INTO `books` (`title`, `published`, `writer`, `artist`, `description`, `image`, `status`) VALUES (?,?,?,?,?,?,?)");
        $query->bind_param('sssssss',$title, $published, $writer, $artist, $description, $image, $status);
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
        <div class="comic-container">
            <form action="" method="post">
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
                        <button class="btn submit">ატვირთვა</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="container-header">
            <h2>გვერდები</h2>
            <a href="form.php" class="btn">გვერდის დამატება</a>
        </div>
        <div class="page-container">
            <form action="" method="post">
                <table>
                    <tr class="comic-box">
                        <td>1</td>
                        <td><div class="image" style="background-image: url('<?= $book['image'] ?>');"></div></td>
                        <td><textarea name="image" rows="7"></textarea></td>
                        
                        <td class="actions">
                            <form action="" method="post">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $book['id'] ?>">
                                <button class="delete" onclick="return confirm('მართლა გინდა წაშლა?')">წაშლა</button>
                            </form>
                            <button class="btn submit">ატვირთვა</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </main>
    
    <script src="assets/admin_resources/js/script.js"></script>
</body>
</html>