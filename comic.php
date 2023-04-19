<?php include('helpers/db_connection.php') ?>

<?php  
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
     $url = "https://";   
else  
     $url = "http://";   
   
$url.= $_SERVER['REQUEST_URI'];    
  
echo $url;  

//select
$sql = "SELECT * FROM books";
$result = mysqli_query($conn, $sql);
$books = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include('components/header.php')?>

<!--    const imageTextarea = document.querySelector('textarea[name="image"]');-->
<!--    const imageDiv = document.querySelector('.image');-->
<!---->
<!--    imageTextarea.addEventListener('input', function() {-->
<!--    const imageUrl = this.value;-->
<!--    imageDiv.style.backgroundImage = `url(${imageUrl})`;-->
<!--    });-->
<!---->
<!--    let btnClick = document.getElementById("pageBtn");-->
<!--    let i = 1;-->
<!--    btnClick.addEventListener("click", renderImageForm);-->
<!---->
<!--    function renderImageForm()-->
<!--    {-->
<!--    let table =  document.getElementById('comics-images');-->
<!--    let tmp = `         <td>${i}</td>-->
<!--    <td><div id="image_${i}" class="image" style="background-image: url("");"></div></td>-->
<!--    <td><textarea name="image" rows="7" oninput="changeImage(this,${i})"></textarea></td>-->
<!---->
<!--    <td class="actions">-->
<!--        <form action="" method="post">-->
<!--            <button class="delete" onclick="">წაშლა</button>-->
<!--        </form>-->
<!--        <button class="btn submit">ატვირთვა</button>-->
<!--    </td>-->
<!--    `;-->
<!--    var container = document.createElement("tr");-->
<!--    container.classList.add('comic-box');-->
<!--    container.id = 'comic-image'+i;-->
<!--    container.innerHTML = tmp;-->
<!--    table.appendChild(container);-->
<!--    i++;-->
<!--    }-->
<!--    function changeImage(element, elementID)-->
<!--    {-->
<!--    let image = document.getElementById('image_'+elementID);-->
<!--    let imageUrl = element.value;-->
<!--    image.style.backgroundImage = `url(${imageUrl})`;-->
<!---->
<!--    }-->
<!--    function deletePage()-->
<!--    {-->
<!---->
<!--    }-->
</body>
</html>