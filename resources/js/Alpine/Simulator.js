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
            setting: {
                lang: 'es',
                gender: 'woman',
                open: false,
                storage: null,
                vibration: false,
                intentFinish: false,
                autoSelect: false, // Auto seleccionar las series de un carton que coincidan
                autoSeries: false, // Auto lanzamiento de series del bolillero
                callSpeed: 'normal',
                timeAutoSeries: { // Estado del tiempo (Temporizador se Series automaticas),
                    instance: null,
                    seconds: 5, // Segundos de duración del cada lanzamiento automatico de serie
                    countDown: {
                        instance: null,
                        currentTime: 0,
                    }
                },
                section: {
                    screen: {
                        height: 0,
                        width: 0,
                    },
                    board: {
                        enabled: true,
                        extended: true,
                        orientation: 'V', // V => Vertical | H => Horizontal,
                        size: 'M', // S => Small | M => Medium | B => Big
                    },
                    submodes: {
                        enabled: true,
                        extended: true,
                    },
                    sequence: {
                        enabled: true,
                        extended: true,
                    },
                },
                module: [ 'setting', 'cartons', 'board', 'ranks', 'mode', 'submodes', 'sequence' ],
                color: {
                    class: ['bg-yellow-500', 'bg-blue-500', 'bg-red-500', 'bg-green-500', 'bg-orange-500'],
                    style: ['#EBB308', 'bg-blue-500', 'bg-red-500', 'bg-green-500', 'bg-orange-500'],
                },
                sound: {
                    general: {
                        active: true,
                        volume: 50,
                    },
                    serie: { // Audio dinamico de cada serie del juego en curso
                        audio: '',
                        volume: 1,
                        play: true,
                        pause: false,
                    },
                    start: { // Mensaje al iniciar un juego
                        audio: 'start.mp3',
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
                        audio: 'ballshaped.mp3',
                        volume: 0.5,
                        play: true,
                        pause: false,
                    },
                    shot: { // Lanzamiento
                        audio: 'shot.mp3',
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
            isMobile(){
                if (
                    navigator.userAgent.match(/Android/i) || 
                    navigator.userAgent.match(/webOS/i) || 
                    navigator.userAgent.match(/iPhone/i) || 
                    navigator.userAgent.match(/iPad/i) 
                    || navigator.userAgent.match(/iPod/i) || 
                    navigator.userAgent.match(/BlackBerry/i) || 
                    navigator.userAgent.match(/Windows Phone/i)
                ){
                    this.setting.section.board.extended = false; // En mobiles por defecto se oculta la tabla de carmacion
                    this.setting.section.board.size = 'B'; // En mobiles por defecto se oculta la tabla de carmacion
                    this.setting.section.submodes.extended = false; // En mobiles por defecto se oculta los modos ganadores
                    return true;
                }else
                    return false;
            },
            loading(){

                // console.log("screen.width",screen.width);
                this.setting.section.screen.width = screen.width;
                // console.log(navigator.userAgent);

                if( !this.isMobile() )
                {
                    // Desktop
                    this.setting.section.board.enabled = true;
                    this.setting.section.board.extended = true;
                    this.setting.section.submodes.enabled = true;
                    this.setting.section.submodes.extended = true;
                }

                this.setting.storage = localStorage.getItem('simulator');

                for (let load = 0; load < this.setting.module.length; load++) {
                    this.progress.process = "Loading "+this.setting.module[load]+" ...";
                    fetch(
                        "loading",
                        {
                            method: "POST",
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                            },
                            body: JSON.stringify({ storage: this.setting.storage, module: this.setting.module[load] })
                        }
                    ).then( res => res.json() )
                    .then( build => {
                        // console.log("module-"+this.setting.module[load],build);
                        switch (this.setting.module[load]) {
                            case 'setting':
                                // Settear setting de acuerdo a la configuracion por defecto y al formulario dash del simulador
                                for (const sett in build) {
                                    // console.log("sett", sett);
                                    if( typeof this.setting[sett] !== undefined ){
                                        // console.log("setting("+sett+")", this.setting[sett]);
                                        // console.log("build("+sett+")", build[sett]);
                                        this.setting[sett] = this.setting[sett] = build[sett];
                                    }
                                    // else console.log("Not exists", this.setting[sett]);
                                }
                                break;
                        
                            default:
                                this[this.setting.module[load]] = build;
                                break;
                        }

                        this.progress.status += ( 100 / this.setting.module.length );
                    });
                }

            },
            sync(modules){

                var sync = new Object();
                for (let m = 0; m < modules.length; m++) {
                    sync[modules[m]] = this[modules[m]];   
                }

                if( ! sync['setting'] ) sync['setting'] = this.setting;
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

                // window.addEventListener('resize', () => {
                //     this.setting.section.width = window.innerWidth;
                //     this.setting.section.height = window.innerHeight;
                // });

                this.loading();

                this.setting.timeAutoSeries.countDown.currentTime = this.setting.timeAutoSeries.seconds;

                // Validar la configuracion inicial
                setTimeout(() => {
                    // console.log("this.setting.autoSeries", this.setting.autoSeries);
                    this.toggleAutoSeries(this.setting.autoSeries);
                    this.toggleAutoSelect(this.setting.autoSelect);
                }, 1000);                
                
                // this.setting.sound.bolillero.audio = 'bolillero.mp3'
                // setInterval(() => {
                //     this.setting.sound.bolillero.audio = ''
                //     this.setting.sound.bolillero.audio = 'bolillero.mp3'
                // }, 30000);

                // console.log("start function");

                // setTimeout(function(){
                //     var bounce = document.getElementById('content-bounce');
                //     console.log("content_bounce",bounce);
                //     console.log("getBoundingClientRect",bounce.getBoundingClientRect());
                //     var balls = document.querySelector('.ball-bounce');
                //     console.log("balls",balls);
                //     console.log("balls.len",balls.length);
                //     console.log("balls.getBoundingClientRect",balls.getBoundingClientRect());
                //     balls.map((ball) => {
                //         console.log("ball",ball); 
                //     });
                // },1000);
                


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
            setRound(returnSerie = false) {
                // $('.btn-round').attr('disabled', true)
                this.inRound = true;

                let randSerie = null;

                if( this.ranks.length ){

                    let number = this.getRandom(1, 75)
                    let newRound = this.getSerie(number)
                    let serie = newRound.letter+newRound.number

                    if( returnSerie ) randSerie = newRound;

                    // console.log('newRound',newRound);
                    const indexRank = this.ranks.findIndex( rank => rank == newRound.number )
                    if( indexRank >= 0) this.ranks.splice(indexRank,1);
                    // console.log('ranks',this.ranks);
                    this.markerBoard(number)
                    this.setting.sound.shot.audio = 'shot.mp3';
                    this.inRound = true;
                    if(this.setting.sound.bolillero.volume <= 0)
                        this.setting.sound.bolillero.audio = '';
                    setTimeout(() => {
                        this.sequence.push(newRound)
                        this.setting.sound.serie.audio = serie
                        this.setting.sound.shot.audio = ''
                        this.inRound = false;
                        if(this.setting.sound.bolillero.volume > 0){
                            this.setting.sound.bolillero.audio = 'ballshaped.mp3';
                            this.setVolume('bolillero');
                        }

                        if( this.setting.autoSeries && this.setting.timeAutoSeries.countDown.currentTime <= 0) this.setting.timeAutoSeries.countDown.currentTime = this.setting.timeAutoSeries.seconds;

                        this.sync(['board', 'ranks', 'sequence']);
                        
                    }, 150);

                }

                if( returnSerie ) return randSerie;

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

                if(this.board[indexObject].ranges[indexPosition].active && this.setting.autoSelect){
                    // console.log("autoSelect::serie",this.board[indexObject].letter+this.board[indexObject].ranges[indexPosition].number);
                    // let serie = this.setRound(true);
                    // if(serie) this.toggleSerie(serie.number, serie.letter);
                    this.proccessAutoSelect(this.board[indexObject].letter, this.board[indexObject].ranges[indexPosition].number);
                }

            },
            // Obtener un número aleatorio entre un rango minimo y máximo
            getRandom (min, max) {
                // return Math.floor(Math.random() * (max - min) + min)
                return this.ranks[Math.floor(Math.random() * this.ranks.length)];
            },
            toggleAutoSeries(toggleManual = null){

                if(toggleManual === null)
                    this.setting.autoSeries = !this.setting.autoSeries;
                else 
                    this.setting.autoSeries = toggleManual;

                if(this.setting.autoSeries){
                    this.setting.timeAutoSeries.instance = setInterval(
                        () => { 
                            this.setRound();
                        }, this.setting.timeAutoSeries.seconds * 1000
                    );

                    this.setting.timeAutoSeries.countDown.instance = setInterval(
                        () => this.setting.timeAutoSeries.countDown.currentTime--, 1000
                    );

                }else this.pauseAutoSeries();

                if(this.ranks.length === 0) this.pauseAutoSeries(); 

            },
            pauseAutoSeries(){
                clearInterval(this.setting.timeAutoSeries.instance);
                clearInterval(this.setting.timeAutoSeries.countDown.instance);
                this.setting.timeAutoSeries.instance = this.setting.timeAutoSeries.countDown.instance = null;
            },
            toggleAutoSelect(toggleManual = null){
                
                if(toggleManual === null)
                    this.setting.autoSelect = !this.setting.autoSelect;
                else 
                    this.setting.autoSelect = toggleManual;

                if(this.setting.autoSelect) this.proccessAutoSelect();

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
                    color: this.setting.color.class[(Math.floor(Math.random() * this.setting.color.class.length))]
                }
            },
            // Player Event Click In Serie From Carton
            toggleSerie(number, letter, key = null){

                this.cartons[number][letter][key].active = !this.cartons[number][letter][key].active;
            
                setTimeout(() => {
                    this.sync(['cartons']);
                }, 550);
                
            },
            proccessAutoSelect(paramLetter = null, paramNumber = null){

                if(this.setting.autoSelect){

                    let proccessedCounter = 0;
                    // console.log("proccessAutoSelect::paramLetter("+paramLetter+"), proccessAutoSelect::paramNumber("+paramNumber+")");

                    for (const carton in this.cartons) {
                        for (const letter in this.cartons[carton]) {
                            for (const serie in this.cartons[carton][letter]) {

                                // console.log("serie("+carton+")",this.cartons[carton][letter][serie].number);
                                // console.log("serie("+carton+")",letter+this.cartons[carton][letter][serie].number);

                                if( paramLetter !== null && paramNumber !== null ){
                                    if( paramLetter === letter && paramNumber === this.cartons[carton][letter][serie].number){
                                        proccessedCounter++;
                                        this.cartons[carton][letter][serie].active = true;
                                    }
                                }else{
                                    let boardLetter = this.board.filter(row => row.letter === letter)[0];
                                    let boardNumber = boardLetter.ranges.filter(range => range.number === this.cartons[carton][letter][serie].number)[0];
                                    // console.log("autoSelect::boardsMarket("+boardNumber?.active||false+")", boardLetter?.letter+boardNumber?.number);
                                    proccessedCounter++;
                                    this.cartons[carton][letter][serie].active = boardNumber?.active || false;
                                    
                                }
                                

                            }
                        }
                    }

                    if(proccessedCounter > 0){
                        setTimeout(() => {
                            this.sync(['cartons']);
                        }, 550);
                    }

                }

                // let rangesActiveBoard = this.board.filter(row => row.ranges.filter(range => range.active === true));
                // let rows = this.board.filter(row => row.letter === 'B');
                // console.log("ranges",rows.ranges);
                // let actives = rows.ranges.filter( range  => range.active === true );
                // console.log("actives",actives);

                // if(this.setting.autoSelect){

                //     for (const number in this.cartons) {
                //         for (const letter in this.cartons[number]) {
                //             for (const serie in this.cartons[number][letter]) {

                //                 console.log("serie("+number+")",this.cartons[number][letter][serie].number);
                //                 console.log("serie("+number+").active",this.cartons[number][letter][serie].active);

                //                 // CONFIGURAR AUTO SELECCION DE CARTONES

                //             }
                //         }
                //     }
                    
                // }

                // if(proccessed){
                //     setTimeout(() => {
                //         this.sync(['cartons']);
                //     }, 550);
                // }
                
            },
            bingo(){
                // console.log("Bingo-submodes",this.submodes);
                // console.log("Bingo-cartons",this.cartons);
                this.setting.checking.status = true;
                let count;
                let completed;
                this.setting.checking.wins = [];
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
                                        let index_carton = this.setting.checking.wins.findIndex( win => win.carton === number );
                                        // console.log("index_carton",index_carton);
                                        if( index_carton > -1 ){

                                            this.setting.checking.wins[index_carton].coords = this.setting.checking.wins[index_carton].coords.concat(submode.coordinates);
                                            this.setting.checking.wins[index_carton].count++;
                                            // this.setting.checking.wins[index_carton].coords.push(
                                            //     { id: submode.submode_id, coords: submode.coordinates }
                                            // );
                                        }else{
                                            this.setting.checking.wins.push({
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
                // console.log("this.setting.checking.wins (simulator)",this.setting.checking.wins);
                if(this.setting.checking.wins.length > 0){
                    this.setting.sound.win.audio = 'winner_male.mp3';
                    this.setting.sound.celebration.audio = 'pyrotechnics.mp3';
                }else{
                    this.setting.sound.celebration.audio = '';
                    this.setting.sound.win.audio = 'losser_male.mp3';
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
            intentFinish(){
                this.setting.intentFinish = true;
            },
            finish(){
                localStorage.removeItem('simulator');
                location.href = "/simulator";
            },
            save(){
                console.log("Save data", this.setting.checking.wins);
                this.setting.checking.status = false;
            },
            setVolume(audio){
                var soundTag = document.getElementById(audio);
                if(soundTag){
                    if(this.setting.sound[audio].volume > 0 && this.setting.sound.bolillero.audio == ''){
                        this.setting.sound.bolillero.audio = audio+'.mp3';
                        soundTag.play();
                    }
                    soundTag.volume = this.setting.sound[audio].volume;
                }
            },
            toggleVolume(audio){
                this.setting.sound[audio].volume = ((this.setting.sound[audio].volume > 0) ? 0 : 1);
                this.setVolume(audio);
            },
            toggleView(name){
                // Object.keys(this.setting.section).forEach(sec => {
                //     if( sec != name  ) this.setting.section[sec].extended = false;
                // });
                this.setting.section[name].extended = !this.setting.section[name].extended;
            }
        })
    );
})