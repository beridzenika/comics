<?php 
include('helpers/db_connection.php');
include('helpers/functions.php');

session_start();
isAdmin();

// insert
if(isset($_POST['action']) && $_POST['action'] == 'insert') {

    list($title, $published, $writer, $artist, $description, $image, $status, $pages, $prevIssue, $nextIssue, $price) = actionData($connection);

    if($title && $published && $writer && $artist && $description && $image && $pages) {

        $query = $connection->prepare("INSERT INTO `books` (`title`, `published`, `writer`, `artist`, `description`, `image`, `status`, `pages`, `prev_issue`, `next_issue`, `price`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $query->bind_param('ssssssssssd',$title, $published, $writer, $artist, $description, $image, $status, $pages, $prevIssue, $nextIssue, $price);
        if($query->execute()) {
            header('Location: index.php?user=admin&page=comics');
        } else {
            print_r($connection->error);
            echo "Error";
        }
    }
}
//head
$pageTitle = "ჭაბუკის კომიქსები | ადმინი | კომიქსის დამატება";
?>

<?php include('components/head.php')?>
    <?php include('components/header.php')?>
    
    <main>
        <div class="container-header">
            <h2>კომიქსი</h2>
        </div>
        <form action="" method="post">
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
                    <div class="form-group shared">
                        <div class="child-group">
                            <label for="">წინა</label>
                            <input type="text" name="prev_issue">
                        </div>
                        <div class="child-group">
                            <label for="">შემდეგი</label>
                            <input type="text" name="next_issue">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">ფასი</label>
                        <input type="text" name="price">
                    </div>
                    <div class="form-group">
                        <label for="">აღწერილობა</label>
                        <textarea name="description" id="" cols="30" rows="7"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">სტატუსი</label>
                        <select name="status" id="">
                            <option value="1">მოქმედი</option>
                            <option value="0">უქმი</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="container-header">
                <h2>გვერდები</h2>
                <a class="btn" id="pageBtn">დამატება</a>
            </div>
            <div class="page-container">
                <table id="comics-images">
                    <!-- image forms -->
                </table>
            </div>
            <div class="form-sub" id="formSub">
                <input type="hidden" name="action" value="insert">
                <button class="btn submit">ატვირთვა</button>
            </div>
        </form>
    </main>
<?php include('components/foot.php')?>