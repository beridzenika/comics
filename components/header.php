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
            <a href="login.php">შემოსვლა</a>
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
