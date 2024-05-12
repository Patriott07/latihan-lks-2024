const canvas = document.getElementById('canvas');
const context = canvas.getContext('2d');

canvas.width = 400;
canvas.height = 400;

let circle = {
    x : 50,
    y : 50,
    w : 50,
    h : 50,
    color : 'green'
}

function update(){

    context.clearRect(0,0,canvas.width, canvas.height);

    context.beginPath();
    context.arc(circle.x, circle.y, 50, 0, 360);

    context.fillStyle = circle.color;
    context.fill()
    context.stroke();
    context.closePath();

    requestAnimationFrame(update);
}

document.addEventListener('mousemove', (e) => {
    // console.log(e)

    let startX = window.screenX
    let x = e.clientX - 200;
    let y = e.clientY -69;

    circle.x = x;
    circle.y = y;
})

// document.addEventListener('click', (e) => console.log(e))

update();