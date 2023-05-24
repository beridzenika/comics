<?php 
include('helpers/db_connection.php');
include('helpers/functions.php');

session_start();
isAdmin();

// insert
if(isset($_POST['action']) && $_POST['action'] == 'insert') {

    $title = isset($_POST['title']) ? $_POST['title'] : '' ;
    $link = isset($_POST['link']) ? $_POST['link'] : '' ;
    $status = isset($_POST['status']) ? $_POST['status'] : '' ;
    if($title && $link) {

        $query = $connection->prepare("INSERT INTO `menu` (`title`, `link`, `status`) VALUES (?,?,?)");
        $query->bind_param('sss', $title, $link, $status);
        if($query->execute()) {
            header('Location: index.php?user=admin&page=menu');
        } else {
            print_r($connection->error);
            echo "Error";
        }
    }
}
//delete
if(isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = $_POST['id'];

    $query = $connection->query("DELETE FROM menu where id = " .$id);

    if($query) {
    } else {
        echo "Error";
    }
}
//status
if(isset($_POST['action']) && $_POST['action'] == 'status') {
    $id = $_POST['id'];
    $status = isset($_POST['status']) && $_POST['status'] == 1 ? 0 : 1;

    $query = $connection->prepare("UPDATE menu SET status = ? where id = " .$id);
    $query->bind_param('s', $status);
    if($query->execute()) {
        header('Location: index.php?user=admin&page=menu');
    } else {
        print_r($connection->error);
        echo "Error";
    }
}

//select
$query = $connection->query("SELECT * FROM menu");
$admMenu = $query->fetch_all(MYSQLI_ASSOC);

// update
if(isset($_POST['title']) && isset($_POST['action']) && $_POST['action'] == 'update') {
    $title = isset($_POST['title']) ? $_POST['title'] : '' ;
    $id = isset($_POST['id']) ? $_POST['id'] : '' ;

    $query = $connection->prepare("UPDATE menu SET title = ? where id=" .$id);
    $query->bind_param('s', $title);
    if($query->execute()) {
        header('Location: index.php?user=admin&page=menu');
    } else {
        print_r($connection->error);
        echo "Error";
    }
}


$pageTitle = "ჭაბუკის კომიქსები | ადმინი | მენიუ";
?>

<?php include('components/head.php')?>

    <?php include('components/header.php')?>
    <main>
        <div class="container-header">
            <h2>მენიუ</h2>
            <button class="pageBtn" onclick="togglePopup()">დაამატე</button>
        </div>

        <table class="table-container">
            <?php foreach($admMenu as $link): ?>
                <tr class="comic-box">
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="id" value="<?= $link['id'] ?>">
                            <input type="text" name="title" value="<?= $link['title'] ?>" onchange="this.form.submit(); return confirm('მართლა გინდა შეცვლა?')">    
                        </form>
                    </td>
                    <td class="actions">
                        <form action="" method="post">
                            <input type="hidden" name="action" value="status">
                            <input type="hidden" name="id" value="<?= $link['id'] ?>">
                            <input type="hidden" name="status" value="<?= $link['status'] ?>">
                            <button class="<?= $link['status'] == 1 ? 'active' : 'inactive' ?>"><?= $link['status'] == 1 ? 'მოქმედი' : 'უქმი' ?></button>
                        </form>
                        <form action="" method="post">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $link['id'] ?>">
                            <button class="delete" onclick="return confirm('მართლა გინდა წაშლა?')">წაშლა</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="overlay" onclick="togglePopup()"></div>
        <div id="popupForm" class="popup darken">
            <form action="" method="post">
                <td>
                    <input type="text" name="title" placeholder="სახელი">
                </td>
                <td>
                    <input type="text" name="link" placeholder="ლინკი">
                </td>
                <td class="actions">
                    <select name="status" id="">
                        <option value="1">მოქმედი</option>
                        <option value="0">უქმი</option>
                    </select>

                    <input type="hidden" name="action" value="insert">
                    <button class="btn submit">ატვირთვა</button>
                </td>
            </form>
        </div>
    </main>
<?php include('components/foot.php')?>