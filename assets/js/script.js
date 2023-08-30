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

//see more btn
// function loadMore(sectionId) {
//     var section = document.getElementById('comic-container-'+sectionId);
//     var moreBtn = document.getElementById('more-btn-'+sectionId);
//     const xhr = new XMLHttpRequest();
//     xhr.open('GET', 'test.php', true);
//     xhr.onload = function () {
//         if (this.status == 200) {
//             moreBtn.remove();
//             section.innerHTML += this.responseText;
//         }
//     }
//     xhr.send();
// }

//rate star ajax
// function ajaxRate (starsNum) {
//     const xhr = new XMLHttpRequest();
//     xhr.open('GET', 'ajax/star_rate.php?starsNum='+starsNum, true);
//     xhr.onload = function () {
//         if (this.status == 200) {
//             document.innerHTML += this.responseText;
//         }
//     }
//     xhr.send();
// }


//rate star glow
let elements = document.querySelectorAll(".fa");
let active = document.querySelectorAll(".checked").length;
let ratedArray = [];

for (let i = 0; i < elements.length; i++) {
    elements[i].addEventListener("click", function() {
        active = i + 1;
        document.querySelector('#rate-star').value = active;

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

// //pages image generation
// let pageImage = document.getElementById('page_image_container');

// let leftArrow = document.getElementById("left_arrow");
// let rightArrow = document.getElementById("right_arrow");
// let jsonPages = document.getElementById('comicPages');
// let pageArrey = [];

// if (jsonPages) {
//     pages = JSON.parse(jsonPages.value);
//     pages.forEach(function (value, key) {
//         pageArrey[key] = {'image': value};
//     });
// }
// let pageLength = pageArrey.length-1;
// let pn = 0;

// renderPage()
// function renderPage() {
//     pageImage.innerHTML = getImage(pageArrey[pn].image);
// }

// function getImage(image)
// {
//     return `<img src="${image}" alt="">`;
// }
// rightArrow.addEventListener("click", function () {
//     pn = (pn != pageLength) ? pn + 1 : 0;
    
//     renderPage();
// });
// leftArrow.addEventListener("click", function () {
//     pn = (pn != 0) ? pn - 1 : 0;
    
//     renderPage();
// });

// // header/footer show/hiding
// let page = document.getElementById('comic-page');
// let header = document.getElementById('header');
// let footer = document.getElementById('footer');
// let timeout;

// function hideHeaderFooter() {
//     header.style.display = 'none';
//     footer.style.display = 'none';
// }

// function showHeaderFooter() {
//     header.style.display = 'block';
//     footer.style.display = 'block';
//     clearTimeout(timeout);
//     timeout = setTimeout(hideHeaderFooter, 3000);
// }

// page.addEventListener('mousemove', showHeaderFooter);
// page.addEventListener('click', showHeaderFooter);

// //zoom in/out

// let zoomIcons = document.querySelectorAll('.btn-zoom');

// for (let i = 0; i < zoomIcons.length; i++) {
//     zoomIcons[i].addEventListener('click', function() {
//         let zoomInIcon = document.querySelector('.btn-zoom.zoom-in');
//         let zoomOutIcon = document.querySelector('.btn-zoom.zoom-out');

//         if (this.classList.contains('zoom-in')) {
//             zoomInIcon.style.display = 'none';
//             zoomOutIcon.style.display = 'block';
//             pageImage.classList.add("zoomed");
//         } else {
//             zoomInIcon.style.display = 'block';
//             zoomOutIcon.style.display = 'none';
//             pageImage.classList.remove("zoomed");
//         }
//     });
// }