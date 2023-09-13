<?php
//sessionstatus
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$log = empty($_SESSION) ? "1" : "2";

//menu select
$query = $connection->query("SELECT * FROM menu WHERE status = 1");
$menu = $query->fetch_all(MYSQLI_ASSOC);

//search url
if(isset($_GET['user']) && $_GET['user']) {
    $user = $_GET['user'];
} else {
    $user = null;
}
?>
<header>
    <div class="logo">
        <a href="/comics">
            <span>ჭაბუკის</span>
            <span>კომიქსები</span>
        </a>
    </div>
    <div class="right-h">
        <div class="search">
            <form action="" method="get">
                <?php if (isset($_GET['user']) && $_GET['user']) :?>
                <input type="hidden" name="user" value="<?= isset($_GET['user']) ? $_GET['user'] : "" ?>">
                <?php endif?>
                <input type="text" name="search" value="<?= isset($_GET['search']) ? $_GET['search'] : "" ?>">
                <button class="btn"><?php include 'assets/icons/search.svg'?></button>
            </form>
        </div>

        <div class="login">
            <?php if ($log == "2"): ?>
                <a href="logout.php" id="logout">გასვლა</a>
            <?php else: ?>
                <a href="login.php">შემოსვლა</a>
            <?php endif ?>
        </div>
    </div>
</header>
<menu>
    <ul>
        <?php foreach($menu as $link): ?>
            <li class="<?= $page == $link['link'] ? 'active' : ''  ?>">
                <a href="?<?= $user === 'admin/' ? "user=admin&" : "" ?>page=<?= $link['link'] ?>"><?=$link['title']?></a>
            </li>
        <?php endforeach ?>
        <?php if ($user == 'admin') :?>
            <li class="<?= $page == 'menu' ? 'active' : ''  ?>">
                <a href="?user=admin&page=menu">მენიუ</a>
            </li>
        <?php endif ?>
    </ul>
</menu>