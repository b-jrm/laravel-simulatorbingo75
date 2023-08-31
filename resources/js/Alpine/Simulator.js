document.addEventListener('alpine:init', () => {
    Alpine.data(
        
        'Simulator',

        () => ({
            ranks: [], // Rangos de series que han salido, si estan aqui ya no deben salir mas durante un juego
            board: null, // Tablero de marcación
            cartons: [], // Cartones en juego,
            sequence: [], // Series que han salido
            mode: null, // Modo ganador general
            submodes: null, // Sub-modos ganadores

            inRound: false, // Habilita la bola de bingo
            
            // start: false, // Inicia un juego
            pause: false, // Pausa el juego en curso
            // result: [], // Arreglo de resultados
            // final: null, // Resultado final ganador o perdedor
            // countWinner: 0 // Resultado final ganador o perdedor

            progress: {
                status: 0,
                process: 'Loading game ...',
            },
            config: {
                section: {
                    board: {
                        extended: false,
                    },
                    submodes: {
                        extended: false,
                    },
                    sequence: {
                        extended: false,
                    },
                },
                open: false,
                storage: null,
                module: [ 'cartons', 'board', 'ranks', 'mode', 'submodes', 'sequence' ],
                color: {
                    class: ['bg-yellow-500', 'bg-blue-500', 'bg-red-500', 'bg-green-500', 'bg-orange-500'],
                    style: ['#EBB308', 'bg-blue-500', 'bg-red-500', 'bg-green-500', 'bg-orange-500'],
                },
                // autoSelect: false, // Auto seleccionar las series de un carton que coincidan
                // autoRound: false, // Auto lanzamiento de series del bolillero
                // hours: '00', // Horas de duración del juego
                // minutes: '00', // Minutos de duración del juego
                // seconds: '00', // Segundos de duración del juego
                // time: null, // Estado del tiempo (Temporizador),
                sound: {
                    serie: { // Audio dinamico de cada serie del juego en curso
                        audio: '',
                        volume: 1,
                        play: true,
                        pause: false,
                    },
                    start: { // Mensaje al iniciar un juego
                        audio: 'start_male.mp3',
                        volume: 1,
                        play: true,
                        pause: false,
                    },
                    win: { // Mensaje resultado ganador/perdedor
                        audio: '',
                        volume: 1,
                        play: true,
                        pause: false,
                    },
                    celebration: { // Mensaje resultado ganador/perdedor
                        audio: '',
                        volume: 1,
                        play: true,
                        pause: false,
                    },
                    bolillero: { // bolillero.mp3
                        audio: '',
                        volume: 0.5,
                        play: true,
                        pause: false,
                    },
                    shot: { // Lanzamiento
                        audio: '',
                        volume: 1,
                        play: true,
                        pause: false,
                    },
                },
                checking: {
                    status: false,
                    wins: null,
                }
            },
            loading(){

                this.config.storage = localStorage.getItem('simulator');

                for (let load = 0; load < this.config.module.length; load++) {
                    this.progress.process = "Loading "+this.config.module[load]+" ...";
                    fetch(
                        "loading",
                        {
                            method: "POST",
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                            },
                            body: JSON.stringify({ storage: this.config.storage, module: this.config.module[load] })
                        }
                    ).then( res => res.json() )
                    .then( build => {
                        // console.log("module-"+this.config.module[load],build);
                        this[this.config.module[load]] = build;
                        this.progress.status += ( 100 / this.config.module.length );
                    });
                }

            },
            sync(modules){

                var sync = new Object();
                for (let m = 0; m < modules.length; m++) {
                    sync[modules[m]] = this[modules[m]];   
                }
                // console.log("sync",sync);
                fetch(
                    "sync",
                    {
                        method: "POST",
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ storage: localStorage.getItem('simulator'), sync: sync })
                    }
                );
            },
            start: function(){

                // console.log("simulator",Alpine.$data.simulator);

                this.loading();
                
                // this.config.sound.bolillero.audio = 'bolillero.mp3'
                // setInterval(() => {
                //     this.config.sound.bolillero.audio = ''
                //     this.config.sound.bolillero.audio = 'bolillero.mp3'
                // }, 30000);

                // console.log("start function");

                setTimeout(function(){
                    var bounce = document.getElementById('content-bounce');
                    console.log("content_bounce",bounce);
                    console.log("getBoundingClientRect",bounce.getBoundingClientRect());
                    var balls = document.querySelector('.ball-bounce');
                    console.log("balls",balls);
                    console.log("balls.len",balls.length);
                    console.log("balls.getBoundingClientRect",balls.getBoundingClientRect());
                    balls.map((ball) => {
                        console.log("ball",ball);
                    });
                },1000);
                


                // var clientX = bounce.clientX;
                // var clientY = bounce.clientY;

                // console.log("Clients","X: "+clientX+", Y: "+clientY);

                // var width = bounce.offsetWidth;
                // var height = bounce.offsetHeight;

                // console.log("bounce_size","width: "+width+", height: "+height);

                // var centerX = width / 2;
                // var centerY = height / 2;

                // console.log("Centers","X: "+centerX+", Y: "+centerY);

                // console.log("childNodes",bounce.childNodes);

                // var balls = bounce.getElementsByClassName('ball-bounce');

                // console.log("classname",bounce.getElementsByClassName('ball-bounce'));

                // // bounce.getElementsByClassName('ball-bounce').forEach(function(){
                // //     console.log("ball",this);
                // // });

                // for(var b = 0; b < balls.length; b++){

                //     // this.bounce(balls[b]);

                //     var coords = balls[b].getBoundingClientRect();
                //     console.log("coords-",coords);

                //     var pos = {
                //         x: Math.round(0 - coords.left),
                //         y: Math.round(0 - coords.top)
                //     };

                //     console.log("pos",pos);
                //     // balls[b].style.transform = "translate("+ (centerX - pos.x) + "px, "+ (centerY - pos.y) + "px)";

                //     // const bounceEffect = setInterval(() => {
                //     //     var coords = balls[b].getBoundingClientRect();
                //     //     console.log("coords-",coords);

                //     //     var pos = {
                //     //         x: Math.round(0 - coords.left),
                //     //         y: Math.round(0 - coords.top)
                //     //     };

                //     //     console.log("pos",pos);
                //     //     balls[b].style.transform = "translate("+ (centerX - pos.x) + "px, "+ (centerY - pos.y) + "px)";
                //     // }, 1000);


                // }

            },
            async bounce (ball) {
                var coords = ball.getBoundingClientRect();
                console.log("coords-",coords);

                var pos = {
                    x: Math.round(0 - coords.left),
                    y: Math.round(0 - coords.top)
                };

                console.log("pos",pos);

                // ball.style.transform = "translate("+ (centerX - pos.x) + "px, "+ (centerY - pos.y) + "px)";
            },
            // Lanzamientos
            setRound() {
                // $('.btn-round').attr('disabled', true)
                this.inRound = true;
                if( this.ranks.length ){

                    let number = this.getRandom(1, 75)
                    let newRound = this.getSerie(number)
                    let serie = newRound.letter+newRound.number

                    // console.log('newRound',newRound);
                    const indexRank = this.ranks.findIndex( rank => rank == newRound.number )
                    if( indexRank >= 0) this.ranks.splice(indexRank,1);
                    // console.log('ranks',this.ranks);
                    this.markerBoard(number)
                    this.config.sound.shot.audio = 'shot.mp3';
                    this.inRound = true;
                    if(this.config.sound.bolillero.volume <= 0)
                        this.config.sound.bolillero.audio = '';
                    setTimeout(() => {
                        this.sequence.push(newRound)
                        this.config.sound.serie.audio = serie
                        this.config.sound.shot.audio = ''
                        this.inRound = false;
                        if(this.config.sound.bolillero.volume > 0){
                            this.config.sound.bolillero.audio = 'bolillero.mp3';
                            this.setVolume('bolillero');
                        }
                        this.sync(['board', 'ranks', 'sequence']);
                    }, 550);

                }

                

                // setTimeout(() => { $('.btn-round').attr('disabled', false) }, 2000)
            },
            // Buscar el índice de la tabla de marcación segun el lanzamiento
            markerBoard (number) {
                let indexObject = null
                let rest = null
                if (number >= 1 && number <= 15) { indexObject = 0; rest = 1 }
                if (number >= 16 && number <= 30) { indexObject = 1; rest = 16 }
                if (number >= 31 && number <= 45) { indexObject = 2; rest = 31 }
                if (number >= 46 && number <= 60) { indexObject = 3; rest = 46 }
                if (number >= 61 && number <= 75) { indexObject = 4; rest = 61 }
                const indexPosition = number - rest
                this.board[indexObject].ranges[indexPosition].active = !this.board[indexObject].ranges[indexPosition].active
            },
            // Obtener un número aleatorio entre un rango minimo y máximo
            getRandom (min, max) {
                // return Math.floor(Math.random() * (max - min) + min)
                return this.ranks[Math.floor(Math.random() * this.ranks.length)];
            },
            // Obtener un número aleatorio entre un rango de acuerdo al resultado de getRandom
            getSerie (number) {
                let letter = ''
                switch (true) {
                    case (number <= 15): letter = 'B'; break
                    case (number <= 30): letter = 'I'; break
                    case (number <= 45): letter = 'N'; break
                    case (number <= 60): letter = 'G'; break
                    case (number <= 75): letter = 'O'; break
                }
                return {
                    letter: letter,
                    number: number,
                    color: this.config.color.class[(Math.floor(Math.random() * this.config.color.class.length))]
                }
            },
            // Player Event Click In Serie From Carton
            toggleSerie(number, letter, key){
                this.cartons[number][letter][key].active = !this.cartons[number][letter][key].active;
                setTimeout(() => {
                    this.sync(['cartons']);
                }, 550);
            },
            bingo(){
                // console.log("Bingo-submodes",this.submodes);
                // console.log("Bingo-cartons",this.cartons);
                this.config.checking.status = true;
                let count;
                let completed;
                this.config.checking.wins = [];
                this.submodes.forEach(submode => {
                    // console.log("submode",submode);
                    for (const number in this.cartons) {
                        // console.log("number",number);
                        count = 0;
                        completed = false;
                        // console.log("carton-number (submode-"+submode.submode_id+")",number);
                        for (const letter in this.cartons[number]) {
                            if(completed) break;
                            // console.log("letter",letter);
                            for (const serie in this.cartons[number][letter]) {
                                // console.log("serie",this.cartons[number][letter][serie].number);
                                var inCoord = submode.coordinates.findIndex( coord => coord.x === this.cartons[number][letter][serie].coord.x && coord.y === this.cartons[number][letter][serie].coord.y );
                                if( 
                                    ( (this.inSequence(letter,this.cartons[number][letter][serie].number) 
                                    && this.cartons[number][letter][serie].active ) || this.cartons[number][letter][serie].number === 0 )
                                    && (inCoord > -1)
                                ){
                                    
                                    count++;
                                    completed = (count == submode.coordinates.length);
                                    if(completed){
                                        this.cartons[number][letter][serie].is_win = true;
                                        let index_carton = this.config.checking.wins.findIndex( win => win.carton === number );
                                        // console.log("index_carton",index_carton);
                                        if( index_carton > -1 ){

                                            this.config.checking.wins[index_carton].coords = this.config.checking.wins[index_carton].coords.concat(submode.coordinates);
                                            this.config.checking.wins[index_carton].count++;
                                            // this.config.checking.wins[index_carton].coords.push(
                                            //     { id: submode.submode_id, coords: submode.coordinates }
                                            // );
                                        }else{
                                            this.config.checking.wins.push({
                                                carton: number,
                                                coords: submode.coordinates,
                                                count: 1,
                                            });
                                        }
                                    }
                                }
                            }
                        }
                    } // End for

                });
                // console.log("this.config.checking.wins (simulator)",this.config.checking.wins);
                if(this.config.checking.wins.length > 0){
                    this.config.sound.win.audio = 'winner_male.mp3';
                    this.config.sound.celebration.audio = 'pyrotechnics.mp3';
                }else{
                    this.config.sound.celebration.audio = '';
                    this.config.sound.win.audio = 'losser_male.mp3';
                }
                       

            },
            inSequence(letter, number){
                let has = this.sequence.findIndex((serie) => serie.letter+serie.number === letter+number);
                // console.log("inSequence-"+letter+number,has);
                return (has > -1);
            },
            stop(){
                this.pause = true;
            },
            keep(){
                this.pause = false;
            },
            finish(){
                localStorage.removeItem('simulator');
                location.href = "/simulator";
            },
            save(){
                console.log("Save data", this.config.checking.wins);
                this.config.checking.status = false;
            },
            setVolume(audio){
                var soundTag = document.getElementById(audio);
                if(soundTag){
                    if(this.config.sound[audio].volume > 0 && this.config.sound.bolillero.audio == ''){
                        this.config.sound.bolillero.audio = audio+'.mp3';
                        soundTag.play();
                    }
                    soundTag.volume = this.config.sound[audio].volume;
                }
            },
            toggleVolume(audio){
                this.config.sound[audio].volume = ((this.config.sound[audio].volume > 0) ? 0 : 1);
                this.setVolume(audio);
            },
            toggleView(name){
                Object.keys(this.config.section).forEach(sec => {
                    // this.config.section[sec]
                    if( sec != name  ) this.config.section[sec].extended = false;
                });
                this.config.section[name].extended = !this.config.section[name].extended;
            }
        })
    );
})