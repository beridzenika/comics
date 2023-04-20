let imageTextarea = document.querySelector('textarea[name="image"]');
let imageDiv = document.querySelector('.image');
   
imageTextarea.addEventListener('input', function() {
    const imageUrl = this.value;
    imageDiv.style.backgroundImage = `url(${imageUrl})`;
});

let addImageInput = document.getElementById("pageBtn");
let pagesToRenderInput = document.getElementById('pages-to-render');
let formArrey = [];
if (pagesToRenderInput) {
    pages = JSON.parse(pagesToRenderInput.value);
    pages.forEach(function (value, key) {
        formArrey[key] = {'image': value};
    });
    upateTable();
}



addImageInput.addEventListener("click", addImageTable);
function addImageTable () {
    formArrey.push({'image':''});
    upateTable();
}
function upateTable() {
    document.getElementById("comics-images").innerHTML = "";
    formArrey.forEach(function (value, key) {
        document.getElementById("comics-images").innerHTML += getImageFormHtml(key, value.image);
    });
}
//
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
    console.log(formArrey);
    document.getElementById("image_"+key).style.backgroundImage = `url(${imageUrl})`;

}
function deletePage(key) {
    formArrey.splice(key, 1);
    upateTable();
}

