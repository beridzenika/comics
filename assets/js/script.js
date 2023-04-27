//logout
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


//pages image generation
let leftArrow = document.getElementById("left_arrow");
let rightArrow = document.getElementById("right_arrow");
let jsonPages = document.getElementById('comicPages');
let pageArrey = [];

if (jsonPages) {
    pages = JSON.parse(jsonPages.value);
    pages.forEach(function (value, key) {
        pageArrey[key] = {'image': value};
    });
}
let pageLength = pageArrey.length-1;
let pn = 0;

renderPage()
function renderPage() {
    document.getElementById("page_image_container").innerHTML = getImage(pageArrey[pn].image);
}

function getImage(image)
{
    return `<img src="${image}" alt="">`;
}
rightArrow.addEventListener("click", function () {
    if (pn!=pageLength) {
        pn++;
    } else {
        pn = 0;
    }
    renderPage();
});
leftArrow.addEventListener("click", function () {
    if (pn!=0){
        pn--;
    }
    renderPage();
});


//rating stars
let elements = document.querySelectorAll(".fa-star");

for (let i=0; i < elements.length; i++) {
    elements.addEventListener("mouseover", function () {
    });
}




// let popUp = document.getElementById('popUp');
// let worning = document.getElementById('worning');
//
// document.getElementById('openerBtn').addEventListener('click', function() {
//     if (popUp.style.display="none") {
//         popUp.style.display="block";
//     }
// });
//
// document.getElementById('closeBtn').addEventListener('click', function() {
//     if (popUp.style.display="block") {
//         popUp.style.display="none";
//     }
// });
// document.getElementById('submitBtn').addEventListener('click', function() {
//     let inputValue = document.getElementById('formInput');
//     if (inputValue.value == "") {
//         worning.style.display="block";
//     }
//     else{
//         if (worning.style.display="block") {
//             worning.style.display="none";
//         }
//     }
//
// });