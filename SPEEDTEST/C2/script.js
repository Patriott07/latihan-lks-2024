let imageGray = document.getElementById('grayscale'); 
//container

function update(){
    let input = document.querySelector('.slider').value;
    let imageSize = imageGray.width / input;

    imageGray.style.width = input + '%'; 
    requestAnimationFrame(update);
}

update();