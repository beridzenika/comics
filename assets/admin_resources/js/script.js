const imageTextarea = document.querySelector('textarea[name="image"]');
const imageDiv = document.querySelector('.image');
   
imageTextarea.addEventListener('input', function() {
    const imageUrl = this.value;
    imageDiv.style.backgroundImage = `url(${imageUrl})`;
});

let btnClick = document.getElementById("pageBtn");
let i = 1;
btnClick.addEventListener("click", renderImageForm);

function renderImageForm()
{
    let table =  document.getElementById('comics-images');
    let tmp = `         <td>${i}</td>
                        <td><div id="image_${i}" class="image" style="background-image: url("");"></div></td>
                        <td><textarea name="image" rows="7" oninput="changeImage(this,${i})"></textarea></td>
                        
                        <td class="actions">
                            <form action="" method="post">
                                <button class="delete" type="button" onclick="deletePage(${i})">წაშლა</button>
                            </form>
                            <button class="btn submit">ატვირთვა</button>
                        </td>
                    `;
    var container = document.createElement("tr");
    container.classList.add('comic-box');
    container.id = 'comic-image'+i;
    container.innerHTML = tmp;
    table.appendChild(container);
    i++;
}
function changeImage(element, elementID)
{
    let image = document.getElementById('image_'+elementID);
    let imageUrl = element.value;
    image.style.backgroundImage = `url(${imageUrl})`;

}
function deletePage( id)
{
    const element = document.getElementById('comic-image'+id);
    element.remove();


}