document.addEventListener('alpine:init', () => {
    Alpine.data(
        
        'Layout',

        () => ({
            account: {
                show: false,
            },
            aside: {
                show: false,
            },
            scroll: {
                top: 0,
            },
            options: [
                { title: "LogIn", url: "{{ route('login') }}" },
                { title: "SignIn", url: "{{ route('register') }}" },
            ],
            responsive(){
                this.moveScroll(0, 0);
            },
            moveScroll(top, left, el = null, add = false) {
                // console.log("moveScroll-top",top);
                // console.log("moveScroll-left",left);
                // console.log("moveScroll-el",el);
                // console.log("moveScroll-add",add);
                if( el !== null && el !== '' ){
                    // console.log("scrollLeft",document.querySelector(el).scrollLeft);
                    // console.log("width",document.querySelector(el).clientWidth);
                    if(add){
                        if(left) left += document.querySelector(el).scrollLeft;
                        if(top) top += document.querySelector(el).scrollTop;
                    }
                    // console.log("moveScroll","top-"+top);
                    // console.log("moveScroll","left-"+left);
                    document.querySelector(el).scroll({
                        top: top,
                        left: left,
                        behavior: "smooth",
                    });
                }else{
                    this.scroll.top = top;
                    window.scroll({
                        top: top,
                        left: left,
                        behavior: "smooth",
                    });
                }
                
            },
            // Balls Home
            balls: Array.from({ length: 16 }, (_, i) => ({
                    id: i,
                    num: Math.floor(Math.random() * 75) + 1,
                    left: Math.random() * 100,
                    delay: (Math.random() * 10).toFixed(2),
                    duration: (12 + Math.random() * 10).toFixed(2),
                    size: 40 + Math.floor(Math.random() * 30)
                })
            )
        })
    );
})