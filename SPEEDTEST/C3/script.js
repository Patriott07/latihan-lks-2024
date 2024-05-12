let box = document.querySelector('.absolute-box');

box.addEventListener('dragstart', (e) => {
   
});

box.addEventListener('dragover', (e) => {
    
    let topVal = e.clientY;
    let leftVal = e.clientX;

    box.style.top = topVal + 'px';
    box.style.left = leftVal + 'px';
});
