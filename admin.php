<?php 
include('helpers/db_connection.php');
include('helpers/functions.php');

session_start();
isAdmin();

//delete
if(isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = $_POST['id'];

    $query = $connection->query("DELETE FROM books where id = " .$id);

    if($query) {
    } else {
        echo "Error";
    }
}

//select
$query = $connection->query("SELECT * FROM books " . search("WHERE") . " ORDER BY books.id DESC");
$books = $query->fetch_all(MYSQLI_ASSOC);

$pageTitle = "ჭაბუკის კომიქსები | ადმინი";
$styleLink = 'assets/admin_resources/css/style.css';
$scriptLink = 'assets/admin_resources/js/script.js';
?>

<?php include('components/head.php')?>

    <?php include('components/header.php')?>
    <main>
        <div class="container-header">
            <h2>კომიქსები</h2>
            <a href="form.php" class="btn">დაამატე</a>
        </div>
        <table class="book-container">
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
<?php include('components/foot.php')?>