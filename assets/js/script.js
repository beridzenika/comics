let popUp = document.getElementById('popUp');
let worning = document.getElementById('worning');

document.getElementById('openerBtn').addEventListener('click', function() {
    if (popUp.style.display="none") {
        popUp.style.display="block";
    }
});

document.getElementById('closeBtn').addEventListener('click', function() {
    if (popUp.style.display="block") {
        popUp.style.display="none";
    }
});
document.getElementById('submitBtn').addEventListener('click', function() {
    let inputValue = document.getElementById('formInput');
    if (inputValue.value == "") {
        worning.style.display="block";
    }
    else{
        if (worning.style.display="block") {
            worning.style.display="none";
        }
    }

});