<?php foreach($books as $book): ?>
<div class="comic-box">
    <a class="img-link" href="?action=issue&id=<?=$book['id']?>">
        <img src="<?=$book['image']?>" alt="">
    </a>
    <div class="text">
        <a href="?action=issue&id=<?=$book['id']?>">
            <span class="title"><?=$book['title']?></span>
        </a>
    </div>
</div>
<?php endforeach; ?>