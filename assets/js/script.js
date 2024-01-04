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
function loadMore(sectionId, ajaxPageurl) {
    var section = document.getElementById('comic-container-'+sectionId);
    var btnHolder = document.getElementById('load-btn-holder-'+sectionId);

    var page = parseInt(btnHolder.querySelector('#load-page').value);
    var allBooksNum = parseInt(btnHolder.querySelector('#books-num').value);
    var limit = parseInt(btnHolder.querySelector('#limit').value);
    var search = btnHolder.querySelector('#search').value;
    var curBooksNum = (page+1)*limit;
    
    var url = 'ajax/load_'+ajaxPageurl+'_comics.php';
    var params = { page: page, section_id: sectionId, search: search};
    params = formatParams(params);
    const xhr = new XMLHttpRequest();
    xhr.open("GET", url+params, true);
    xhr.onreadystatechange = function()
    {
        if(xhr.readyState == 4 && xhr.status == 200) {
            let moreComics = xhr.responseText;
            section.innerHTML += moreComics;
            if (allBooksNum >= curBooksNum) {
                document.getElementById('load-page').value = page+1;
            } else {
                document.getElementById('load-btn-'+sectionId).remove();
            }
        }
    }
    xhr.send(null);
}

function formatParams( params ){
    return "?" + Object
        .keys(params)
        .map(function(key){
            return key+"="+encodeURIComponent(params[key])
        })
        .join("&")
}



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

//pages image generation
let pageImage = document.getElementById('page_image_container');

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
    pageImage.innerHTML = getImage(pageArrey[pn].image);
}

function getImage(image)
{
    return `<img src="${image}" alt="">`;
}

//changeing pages

function nextPage () {
    pn = (pn != pageLength) ? pn + 1 : 0;
    renderPage();
}
function prevPage () {
    pn = (pn != 0) ? pn - 1 : 0;
    renderPage();
}
rightArrow.addEventListener("click", nextPage);
leftArrow.addEventListener("click", prevPage);

document.addEventListener('keydown', function (event) {
    if (event.code === "ArrowRight"){
        nextPage();
    } else if (event.code === "ArrowLeft"){
        prevPage();
    }
})

//zoom in/out

    let zoomIconIn = document.querySelector('.zoom-in');
    let zoomIconOut = document.querySelector('.zoom-out');

    function zoom() {
        if (pageImage.classList.contains('zoomed')) {
            pageImage.classList.remove('zoomed');
            if (zoomIconOut.style.display = 'block') {
                zoomIconOut.style.display = 'none';
                zoomIconIn.style.display = 'block';
            }
        }
        else{
            pageImage.classList.add('zoomed');
            if (zoomIconIn.style.display = 'block') {
                zoomIconIn.style.display = 'none';
                zoomIconOut.style.display = 'block';
            }
        }
    }


// header/footer show/hiding
let page = document.getElementById('comic-page');
let header = document.getElementById('header');
let footer = document.getElementById('footer');
let timeout;

function hideHeaderFooter() {
    header.style.display = 'none';
    footer.style.display = 'none';
}

function showHeaderFooter() {
    header.style.display = 'block';
    footer.style.display = 'block';
    clearTimeout(timeout);
    timeout = setTimeout(hideHeaderFooter, 3000);
}

page.addEventListener('mousemove', showHeaderFooter);
page.addEventListener('click', showHeaderFooter);

