<?php
session_start();

$log = empty($_SESSION) ? "1" : "2";
?>
<header>
    <div class="logo">
        <a href="http://localhost/comics/">
            <span>ჭაბუკის</span>
            <span>კომიქსები</span>
        </a>
    </div>
    <div class="right-h">
        <div class="search">
            <form action="">        
                <input type="text" name="search" value="<?= isset($_GET['search']) ? $_GET['search'] : "" ?>">
                <button class="btn"><?php include 'assets/icons/search.svg'?></button>
            </form>
        </div>

        <div class="login">
            <?php if ($log == "2"): ?>
                <a href="logout.php" id="logout">გამოსვლა</a>
            <?php else: ?>
                <a href="login.php">შემოსვლა</a>
            <?php endif ?>
        </div>
    </div>
</header>
<menu>
    <ul>
        <li><a href="">ახალი ამბები</a></li>
        <li class="active"><a href="">კომიქსები</a></li>
        <li><a href="">პერსონაჟები</a></li>
        <li><a href="">მაღაზია</a></li>
    </ul>
</menu>