<?php 
include('helpers/db_connection.php');
include('helpers/functions.php');

session_start();
isAdmin();

//paging
$limit = 10;
$offset = '';
$pg = isset($_GET['pg']) && $_GET['pg'] ? $_GET['pg'] : '';
if($pg > 1) {
    $offset = ' OFFSET ' . ($_GET['pg'] - 1) * $limit;
}
$total = $connection->query("SELECT COUNT(*) as cnt FROM books " . search('WHERE'));
$count = $total->fetch_assoc();
$pageNumber = ceil($count['cnt'] / $limit);

//delete
if(isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = $_POST['id'];

    $query = $connection->query("DELETE FROM books where id = " .$id);

    if($query) {
    } else {
        echo "Error";
    }
}
//status
if(isset($_POST['action']) && $_POST['action'] == 'status') {
    $id = $_POST['id'];
    $status = isset($_POST['status']) && $_POST['status'] == 1 ? 0 : 1;

    $query = $connection->prepare("UPDATE books SET status = ? where id = " .$id);
    print_r($query);
    $query->bind_param('s', $status);
    if($query->execute()) {
        header('Location: index.php?user=admin&page=comics&pg='.$pg);
    } else {
        print_r($connection->error);
        echo "Error";
    }
}

//select
$query = $connection->query("SELECT id, image, title, status FROM books " . search('WHERE') . " ORDER BY books.id DESC LIMIT ". $limit ."". $offset);
$books = $query->fetch_all(MYSQLI_ASSOC);

//search relocate
foreach ($books as $book) {
    $user = isset($_GET['user']) ? $_GET['user'] : '';
    searchRelocate($count, $user, $book['id']);
}
if ($count['cnt'] == 0) {
    header('Location: index.php?user=admin&page=comics&action=form');
}

$pageTitle = "ჭაბუკის კომიქსები | ადმინი";
?>

<?php include('components/head.php')?>

    <?php include('components/header.php')?>
    <main>
        <div class="container-header">
            <h2>კომიქსები</h2>
            <a href="?user=admin&page=comics&action=form" class="btn">დაამატე</a>
        </div>
        <table class="table-container">
            <?php foreach($books as $book): ?>
                <tr class="comic-box">
                    <td>
                        <a href="?action=issue&id=<?=$book['id']?>">
                            <img src="<?=$book['image']?>" alt="">
                        </a>
                    </td>
                    <td><span class="title"><?=$book['title']?></span></td>
                    <td class="actions">
                        <form action="" method="post">
                            <input type="hidden" name="action" value="status">
                            <input type="hidden" name="id" value="<?= $book['id'] ?>">
                            <input type="hidden" name="status" value="<?= $book['status'] ?>">
                            <button class="<?= $book['status'] == 1 ? 'active' : 'inactive' ?>"><?= $book['status'] == 1 ? 'მოქმედი' : 'უქმი' ?></button>
                        </form>

                        <a class="edit" href="?user=admin&page=comics&action=edit&id=<?= $book['id'] ?>">შეცვლა</a>

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

    <div class="paging">
        <?php 
        if ($count['cnt'] > $limit) :
            for($i = 1; $i <= $pageNumber; $i++): 
        ?>
            <a href="?user=admin&page=comics&<?=isset($_GET['search']) && $_GET['search'] ? 'search='.$_GET['search'].'&' : ''?>pg=<?= $i ?>" class="btn <?= (isset($_GET['pg']) && $_GET['pg'] && $_GET['pg'] == $i) || (!isset($_GET['pg']) && $i == 1) ? 'active' : 'inactive' ?>"><?= $i ?></a>
        <?php 
            endfor; 
        endif;
        ?>
    </div>

<?php include('components/foot.php')?>