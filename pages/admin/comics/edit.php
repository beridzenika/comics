<?php 
include('helpers/db_connection.php');
include('helpers/functions.php');

session_start();
isAdmin();

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

    list($title, $published, $writer, $artist, $description, $image, $status, $pages, $prevIssue, $nextIssue) = actionData($connection);

    if($title && $published && $writer && $artist && $description && $image) {

        $query = $connection->prepare("UPDATE books SET title = ?, published = ?, writer = ?, artist = ?, description = ?, image = ?, status = ?, pages = ?, prev_issue = ?, next_issue = ? WHERE id = ?");
        $query->bind_param('sssssssssss', $title, $published, $writer, $artist, $description, $image, $status, $pages, $prevIssue, $nextIssue, $id);
        if($query->execute()) {
            header('Location: index.php?user=admin&page=comics');
        } else {
            print_r($connection->error);
            echo "Error";
        }
    }
}
//head
$pageTitle = "ჭაბუკის კომიქსები | ადმინი | კომიქსის განახლება";
?>

<?php include('components/head.php')?>
    <?php include('components/header.php')?>

    <main>
        <div class="container-header">
            <h2>კომიქსი #<?= $book['id'] ?></h2>
        </div>
        <form action="" method="post">
            <div class="comic-container">
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
                    <div class="form-group shared">
                        <div class="child-group">
                            <label for="">წინა</label>
                            <input type="text" name="prev_issue" value="<?= $book['prev_issue'] ?>">
                        </div>
                        <div class="child-group">
                            <label for="">შემდეგი</label>
                            <input type="text" name="next_issue" value="<?= $book['next_issue'] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">აღწერილობა</label>
                        <textarea name="description" id="" cols="30" rows="10"><?= $book['description'] ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">სტატუსი</label>
                        <select name="status" id="">
                            <option value="1" <?= $book['status'] == 1 ? 'selected' : '' ?>>მოქმედი</option>
                            <option value="0" <?= $book['status'] == 0 ? 'selected' : '' ?>>უქმი</option>
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
                <input type="hidden" name="action" value="update">
                <input type="hidden" id="pages-to-render" value='<?=$book['pages'] ?>'>
                <button class="btn submit">ატვირთვა</button>
            </div>
        </form>
    </main>

<?php include('components/foot.php')?>