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

//rate star glow
let elements = document.querySelectorAll(".fa");
let active = document.querySelectorAll(".checked").length;
// let ratedArray = [];

for (let i = 0; i < elements.length; i++) {
    elements[i].addEventListener("click", function() {
        active = i + 1;
        document.querySelector('#rate-star').value = active;

        // ratedArray.push({ 'issue': '', 'number': ''});
        // updateRating();

        document.querySelector('#rateform').submit();
    });

    elements[i].addEventListener("mouseenter", function() {
        for (let j = 0; j <= i; j++) {
            elements[j].classList.add("checked");
        }
        for (let j = i + 1; j < elements.length; j++) {
            elements[j].classList.remove("checked");
        }
    });
    elements[i].addEventListener("mouseleave", function() {
        for (let j = 0; j < active; j++) {
            elements[j].classList.add("checked");
        }
        for (let j = active; j < elements.length; j++) {
            elements[j].classList.remove("checked");
        }
    });
}
// function updateRating() {
//     json = JSON.stringify(ratedArray);
//     document.getElementById("user-rate").value = json;
// }

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
    pn = (pn != pageLength) ? pn + 1 : 0;
    
    renderPage();
});
leftArrow.addEventListener("click", function () {
    pn = (pn != 0) ? pn - 1 : 0;
    
    renderPage();
});

function showHeaderFooter() {
    section.querySelector("header").classList.remove("hidden");
    section.querySelector("footer").classList.remove("hidden");
  }
  
  // Function to hide the header and footer with transition
  function hideHeaderFooter() {
    section.querySelector("header").classList.add("hidden");
    section.querySelector("footer").classList.add("hidden");
  }
  
  // Function to reset the timer and show the header and footer
  function resetTimer() {
    clearTimeout(timer);
    showHeaderFooter();
    timer = setTimeout(hideHeaderFooter, 5000);
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