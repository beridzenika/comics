//logout confirm
let logout = document.getElementById("logout");

function confirmation(e){
    let con = confirm('დარწმუნებული ხარ?');
    if(con==false){
        e.preventDefault();
    }
}
if (logout){
    logout.addEventListener("click", confirmation);
}

//image changing
let imageTextarea = document.querySelector('textarea[name="image"]');
let imageDiv = document.querySelector('.image'); 
imageTextarea.addEventListener('input', function() {
    let imageUrl = this.value;
    imageDiv.style.backgroundImage = `url(${imageUrl})`;
});

//page form
let addImageInput = document.getElementById("pageBtn");
let pagesToRenderInput = document.getElementById('pages-to-render');
let formArrey = [];
if (pagesToRenderInput && pagesToRenderInput.value !== 'null') {
    try {
        pages = JSON.parse(pagesToRenderInput.value);
        pages.forEach(function (value, key) {
            formArrey[key] = { 'image': value };
        });
        updateTable();
    } catch (error) {
        console.error('Invalid JSON:', error);
    }
}

addImageInput.addEventListener("click", addImageTable);
function addImageTable () {
    formArrey.push({'image':''});
    updateTable();
}
function updateTable() {
    document.getElementById("comics-images").innerHTML = "";
    formArrey.forEach(function (value, key) {
        document.getElementById("comics-images").innerHTML += getImageFormHtml(key, value.image);
    });
}
function getImageFormHtml(key, image)
{
    return `    <tr class="comic-box">
                        <td>${key+1}</td>
                        <td><div id="image_${key}" class="image" style="background-image: url(${image});"></div></td>
                        <td><textarea name="images[]" rows="7" oninput="changeImage(this,${key})">${image}</textarea></td>
                        <td class="actions">
                            <form action="" method="post">
                                <button class="delete" type="button" onclick="deletePage(${key})">წაშლა</button>
                            </form>
                        </td>
                    </tr>`;
}
function changeImage(input, key) {
    let imageUrl = input.value;
    formArrey[key].image = imageUrl;
    document.getElementById("image_"+key).style.backgroundImage = `url(${imageUrl})`;

}
function deletePage(key) {
    formArrey.splice(key, 1);
    updateTable();
}
