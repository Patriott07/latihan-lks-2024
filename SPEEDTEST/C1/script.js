const canvas = document.getElementById('canvas');
const context = canvas.getContext('2d');


class Chart {

    data = {
        highest: 0,
        lowest: 0,
        length: 0,
        values: [],
        unSortedValues: []
    };

    yAxis = {
        name: null,
        pointDistance: 0,
        pointWidth: 10 //lebar per data yAxis
    }

    xAxis = {
        name: null,
        pointDistance: 0,
        pointWidth: 10 //lebar per data xAxis
    }

    labelY = [
        13, 27, 41, 55, 70
    ]

    padding = 40;


    constructor(title, data) {
        this.title = title;
        this.data.rawData = data;


        this.keys = Object.keys(this.data.rawData[0]); //mengambil key untuk axisX dan axisY

        // Axis name
        this.xAxis.name = this.keys[0].charAt(0).toUpperCase() + this.keys[0].slice(1);
        this.yAxis.name = this.keys[1].charAt(0).toUpperCase() + this.keys[1].slice(1);

    }

    setup(context){
        context.fillStyle = 'white';
        context.fillRect(0,0,canvas.width, canvas.heigth);

        this.countData();
        // this.drawLabelText();
        this.drawLabelText(context);
    }

    countData(){
        this.data.rawData.forEach(element => {
            this.data.values.push(element.jumlah);
        });

        this.data.length = this.data.values.length;
        this.data.unSortedValues = structuredClone(this.data.values); //buat clone structure Arrayobjek 

        this.data.lowest = this.data.values[0]; 
        this.data.highest = this.data.values[this.data.values.length - 1];
        console.log(this);
    }

    drawLabelText(context){
        let xWidth = canvas.width - this.padding;
        let yHeight = canvas.height - this.padding;

        context.fillStyle = 'black';

        // x
        context.fillRect(this.padding, canvas.height - this.padding, xWidth - this.padding, 3);

        // y
        context.fillRect(this.padding, this.padding, 3, yHeight - this.padding);

        // Teks
        context.fillText(this.xAxis.name, canvas.width - this.padding * 2, canvas.height - this.padding - 20);
        context.fillText(this.yAxis.name, this.padding + 20, this.padding);

        // 
        this.yAxis.pointDistance = yHeight - this.padding / 5;
        this.xAxis.pointDistance = xWidth - this.padding / 8;


        for (let i = 0; i < 5; i++) {
            let posY = this.yAxis.pointDistance * i;
            // context.fillStyle = 'black';

            // labelY
            context.fillText(this.labelY[i].toString(), this.padding * 1 - 20, yHeight - (this.padding * i * 1.5 ));
            
        }
        this.data.rawData.forEach((element, i) => {
            let tanggal = element.tanggal;

            // console.log(tanggal)

            context.fillText(tanggal, this.padding + (this.padding * i * 1.6) + 40, canvas.height - this.padding + 20);

            // END 20:57
        })
    }

    run() {
        console.log(this);
    }
}


let data = [
    {
        tanggal: 1,
        jumlah: 13
    },
    {
        tanggal: 2,
        jumlah: 19
    },
    {
        tanggal: 3,
        jumlah: 70
    },
    {
        tanggal: 4,
        jumlah: 40
    },
    {
        tanggal: 5,
        jumlah: 57
    },
    {
        tanggal: 6,
        jumlah: 18
    },
    {
        tanggal: 7,
        jumlah: 48
    },
    {
        tanggal: 8,
        jumlah: 30
    }

];
let chart = new Chart("Populasi muslim di jepang", data);

chart.setup(context);
chart.run();