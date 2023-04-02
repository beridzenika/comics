const imageTextarea = document.querySelector('textarea[name="image"]');
const imageDiv = document.querySelector('.image');
   
imageTextarea.addEventListener('input', function() {
    const imageUrl = this.value;
    imageDiv.style.backgroundImage = `url(${imageUrl})`;
});