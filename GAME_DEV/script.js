const canvas = document.getElementById('canvas');
const context = canvas.getContext('2d');

canvas.width = 990;
canvas.height = 600;


class component {
    constructor(w, h, source, x, y, type, angle = 0, speed = 5) {

        this.type = type;
        this.angle = angle;
        this.source = source;

        if (type === 'image' || type === 'grass') {
            this.image = new Image();
            this.image.src = this.source;
        } else if (type === 'player') {
            this.image = new Image();
            this.image.src = playerSprite;
        }

        this.w = w;
        this.h = h;
        this.x = x;
        this.y = y;
        this.speed = speed;
    }

    update(context) {

        context.save();
        context.beginPath();
        // context.translate(this.x + this.w / 2, this.y + this.h / 2);
        // context.translate(this.x, this.y); 

        // context.translate(this.x + this.w / 2, this.y + this.h / 2); // penting buat rotate
        //value
        // context.translate(this.x + this.width / 2, this.y + this.height / 2);
        // context.rotate(this.angle);
        // context.rotate(this.angle);

        if (this.type === "image" || this.type === "grass") {
            // this.image.src = this.src;
            context.drawImage(this.image, this.x, this.y, this.w, this.h);
        } else if (this.type === 'player') {
            this.image.src = playerSprite;
            context.drawImage(this.image, this.x, this.y, this.w, this.h);
        }

        context.restore();
    }

}

// Animation variable atau object image path
let playerSprite = 'CMS_media/Top_Down_Survivor/Top_Down_Survivor/shotgun/idle/survivor-idle_shotgun_0.png';
let bulletSprite = 'CMS_media/Crosshairs_64/image0008.png';

//init object
let playerAngle = 0;
// playerAngle = Math.PI / 2;
let player = new component(100, 100, playerSprite, 0, 0, 'player', playerAngle, 5); //player

let imageGrassobj = new Image();
let imageGrass = 'CMS_media/grass.png';

let zombieImage = new Image();
zombieImage.src = 'CMS_media/tds_zombie/export/skeleton-attack_0.png';

// let zombieImageEl = document.getElementById('zombie');
// zombieImageEl.style.rotate = 180 + 'deg';

imageGrassobj.src = imageGrass;

// Array of  items
let collectionBullet = [];
let collectionZombie = [];


// State functionality game

let setting = {
    isPause: false,
}

let buff = {
    firerate: true,
    ice_break: false,
    movement: true,
    multipleDamage: false,
    bulletExplode: false
}

// function

function startGame() {

}

function zombieColWithBullet(){
    collectionBullet.forEach((element, iBullet) => {
        let bullet = element;

        collectionZombie.forEach(element => {
            let zombie = element;

            if(is_collision(bullet, zombie)){
                // console.log('bullet kena zombie')
                zombie.health--;
                collectionBullet.splice(iBullet, 1);
            }
        });
    });
}

function is_collision(obj1, obj2) {
    let x = obj1.x < obj2.x + obj2.w &&
        obj1.x + obj1.w > obj2.x;
    let y = obj1.y < obj2.y + obj2.y &&
        obj1.y + obj1.y > obj2.y;

    if (x && y) {
        return true;
    }
}

function zombieDestroy() {
    collectionZombie.forEach((element, i) => {
        let zombie = element;

        if (zombie.x + zombie.w <= 0) {
            collectionZombie.splice(i, 1);
        }
    });
}



function drawBullet() {
    for (let i = 0; i < collectionBullet.length; i++) {
        let objek = collectionBullet[i];

        objek.x += objek.speed;
    }

    for (let i = 0; i < collectionBullet.length; i++) {
        let objek = collectionBullet[i];


        context.fillRect(objek.x, objek.y, objek.w, objek.h);
    }
}

function drawZombie() {
    // zombie render
    collectionZombie.forEach(element => {
        let objek = element;

        if(objek.health > 0){
            
            context.drawImage(objek.image, objek.x, objek.y, objek.w, objek.h);
        }
    });
}

// Timer
let spawnZombie;
let zombieMoveByTime;
let setFalseIceBreak;

spawnZombie = setInterval(() => {
    if (!buff.ice_break) {
        let randY = Math.floor(Math.random() * canvas.height);
        // let zombie = new component(70, 70, zombieImage, canvas.width, randY, 'image', 0, 5);
        let zombie = {
            image: zombieImage,
            w: 80,
            h: 80,
            x: canvas.width,
            y: randY,
            speed: 10,
            health : 3
        }
        collectionZombie.push(zombie);
        console.log(collectionZombie);
    }
}, 1200);


zombieMoveByTime = setInterval(() => {
    if (!buff.ice_break) {
        collectionZombie.forEach(element => {
            let objek = element;

            // context.drawImage(objek.image, objek.x, objek.y, objek.w,objek.h);
            objek.x += -objek.speed;
        });
    }
}, 100);


// setFalseIceBreak = setTimeout(() => {
//     buff.ice_break = false;
// }, 3000);



// Controller
onmousemove = (e) => {
    let rect = canvas.getBoundingClientRect();

    let dx = e.clientX - rect.left - (player.x + player.w / 2); // Perubahan posisi mouse di sumbu x
    let dy = e.clientY - rect.top - (player.y + player.h / 2); // Perubahan posisi mouse di sumbu y

    console.log('player x and y', player.x, player.y)
    player.angle = Math.atan2(e.clientY-rect.top - player.y-150/2, e.clientX-rect.left - player.x-256/2); // Menghitung sudut rotasi berdasarkan perubahan posisi mouse
    // player.angle = Math.PI / 2; // Sudut 90 derajat (ke bawah) dalam radian
    // player.angle = Math.atan2(e.clientX - player.x, -(e.clientY - player.y));
}

document.addEventListener('keydown', (e) => {
    // console.log(e.key);
    if(e.key == 'z'){
        if(!buff.ice_break){
            buff.ice_break = true;
            setFalseIceBreak = setTimeout(() => {
                buff.ice_break = false;
            }, 3000);
        }
    }

    if(e.key == 'x'){
        buff.movement = !buff.movement;
    }
    if (e.key == 'w') {
        player.y += -player.speed;

        if(buff.movement){
            player.y += -player.speed * 3;
        }
    }
    if (e.key == 's') {
        player.y += player.speed;
        
        if(buff.movement){
            player.y += player.speed * 3;
        }

    }
    if (e.key == 'a') {
        player.x += -player.speed;

        if(buff.movement){
            player.x += -player.speed * 3;
        }

    }
    if (e.key == 'd') {
        player.x += player.speed;

        if(buff.movement){
            player.x += player.speed * 3;
        }
    }
});

document.addEventListener('mousedown', (e) => {

    let bullet = {
        w: 10,
        h: 3,
        x: player.x + player.w / 2,
        y: player.y + player.h / 2 + 25,
        speed: 5
    }

    collectionBullet.push(bullet);
    console.log('tembak', bullet);
});


// update
function update() {
    // bg
    context.drawImage(imageGrassobj, 0, 0, canvas.width, canvas.height);

    // draw
    drawBullet();
    drawZombie();

    // update
    player.update(context);
    zombieColWithBullet();

    // event
    if (buff.firerate) {
        let bullet = {
            w: 10,
            h: 3,
            x: player.x + player.w / 2,
            y: player.y + player.h / 2 + 25,
            speed: 15
        }

        collectionBullet.push(bullet);
    }

    // delete
    zombieDestroy();
    requestAnimationFrame(update);
}





update();