c<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Caveat:wght@600&family=Montserrat:ital,wght@1,300&family=Poppins:ital,wght@0,200;0,400;1,200;1,300&display=swap"
        rel="stylesheet">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <style>
        .home-img {
            height: 350px;
            object-fit: cover;
            object-position: 50% 50%;
        }

        .row-space {
            height: 30px;
        }


        .box-item {
            position: relative;
            -webkit-backface-visibility: hidden;
            width: 415px;
            margin-bottom: 35px;
            max-width: 100%;
        }

        .flip-box {
            -ms-transform-style: preserve-3d;
            transform-style: preserve-3d;
            -webkit-transform-style: preserve-3d;
            perspective: 1000px;
            -webkit-perspective: 1000px;
        }

        .flip-box-front,
        .flip-box-back {
            background-size: cover;
            background-position: center;
            border-radius: 8px;
            min-height: 475px;
            -ms-transition: transform 0.7s cubic-bezier(.4, .2, .2, 1);
            transition: transform 0.7s cubic-bezier(.4, .2, .2, 1);
            -webkit-transition: transform 0.7s cubic-bezier(.4, .2, .2, 1);
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }

        .flip-box-front {
            -ms-transform: rotateY(0deg);
            -webkit-transform: rotateY(0deg);
            transform: rotateY(0deg);
            -webkit-transform-style: preserve-3d;
            -ms-transform-style: preserve-3d;
            transform-style: preserve-3d;
        }

        .flip-box:hover .flip-box-front {
            -ms-transform: rotateY(-180deg);
            -webkit-transform: rotateY(-180deg);
            transform: rotateY(-180deg);
            -webkit-transform-style: preserve-3d;
            -ms-transform-style: preserve-3d;
            transform-style: preserve-3d;
        }

        .flip-box-back {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;

            -ms-transform: rotateY(180deg);
            -webkit-transform: rotateY(180deg);
            transform: rotateY(180deg);
            -webkit-transform-style: preserve-3d;
            -ms-transform-style: preserve-3d;
            transform-style: preserve-3d;
        }

        .flip-box:hover .flip-box-back {
            -ms-transform: rotateY(0deg);
            -webkit-transform: rotateY(0deg);
            transform: rotateY(0deg);
            -webkit-transform-style: preserve-3d;
            -ms-transform-style: preserve-3d;
            transform-style: preserve-3d;
        }

        .flip-box .inner {
            position: absolute;
            left: 0;
            width: 100%;
            padding: 60px;
            outline: 1px solid transparent;
            -webkit-perspective: inherit;
            perspective: inherit;
            z-index: 2;

            transform: translateY(-50%) translateZ(60px) scale(.94);
            -webkit-transform: translateY(-50%) translateZ(60px) scale(.94);
            -ms-transform: translateY(-50%) translateZ(60px) scale(.94);
            top: 50%;
        }

        .flip-box-header {
            font-size: 34px;
        }

        .flip-box p {
            font-size: 20px;
            line-height: 1.5em;
        }

        .flip-box-img {
            margin-top: 25px;
        }

        .flip-box-button {
            background-color: transparent;
            border: 2px solid #fff;
            border-radius: 2px;
            color: #fff;
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
            margin-top: 25px;
            padding: 15px 20px;
            text-transform: uppercase;
        }

        body {
            width: 100%;
            height: 100vh;
            background-color: #000;
            background-image: radial-gradient(circle at top right, rgba(121, 68, 154, 0.13), transparent),
                radial-gradient(circle at 20% 80%, rgba(41, 196, 255, 0.13), transparent)
        }

        canvas {
            position: fixed;
            width: 100%;
            height: 100%;
        }

    </style>
</head>

<body>

    <canvas id="projector">Your browser does not support the Canvas element.</canvas>

    <div class="main">

        <nav class="navbar navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Marvel Fandom</a>
                <form class="d-flex" action="{{ route('search') }}" action="GET">
                    <input name="name" class="form-control me-2" type="search" placeholder="Enter your Keywords"
                        aria-label="Search" value="<?= $_GET['name'] ?? '' ?>" required>
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </nav>
        <div class="container">
            @yield('content')
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script>
        /*          *     .        *  .    *    *   .
             .  *  move your mouse to over the stars   .
             *  .  .   change these values:   .  *
               .      * .        .          * .       */
        const STAR_COLOR = '#fff';
        const STAR_SIZE = 3;
        const STAR_MIN_SCALE = 0.2;
        const OVERFLOW_THRESHOLD = 50;
        const STAR_COUNT = (window.innerWidth + window.innerHeight) / 8;

        const canvas = document.querySelector('canvas'),
            context = canvas.getContext('2d');

        let scale = 1, // device pixel ratio
            width,
            height;

        let stars = [];

        let pointerX,
            pointerY;

        let velocity = {
            x: 0,
            y: 0,
            tx: 0,
            ty: 0,
            z: 0.0005
        };

        let touchInput = false;

        generate();
        resize();
        step();

        window.onresize = resize;
        canvas.onmousemove = onMouseMove;
        canvas.ontouchmove = onTouchMove;
        canvas.ontouchend = onMouseLeave;
        document.onmouseleave = onMouseLeave;

        function generate() {

            for (let i = 0; i < STAR_COUNT; i++) {
                stars.push({
                    x: 0,
                    y: 0,
                    z: STAR_MIN_SCALE + Math.random() * (1 - STAR_MIN_SCALE)
                });
            }

        }

        function placeStar(star) {

            star.x = Math.random() * width;
            star.y = Math.random() * height;

        }

        function recycleStar(star) {

            let direction = 'z';

            let vx = Math.abs(velocity.x),
                vy = Math.abs(velocity.y);

            if (vx > 1 || vy > 1) {
                let axis;

                if (vx > vy) {
                    axis = Math.random() < vx / (vx + vy) ? 'h' : 'v';
                } else {
                    axis = Math.random() < vy / (vx + vy) ? 'v' : 'h';
                }

                if (axis === 'h') {
                    direction = velocity.x > 0 ? 'l' : 'r';
                } else {
                    direction = velocity.y > 0 ? 't' : 'b';
                }
            }

            star.z = STAR_MIN_SCALE + Math.random() * (1 - STAR_MIN_SCALE);

            if (direction === 'z') {
                star.z = 0.1;
                star.x = Math.random() * width;
                star.y = Math.random() * height;
            } else if (direction === 'l') {
                star.x = -OVERFLOW_THRESHOLD;
                star.y = height * Math.random();
            } else if (direction === 'r') {
                star.x = width + OVERFLOW_THRESHOLD;
                star.y = height * Math.random();
            } else if (direction === 't') {
                star.x = width * Math.random();
                star.y = -OVERFLOW_THRESHOLD;
            } else if (direction === 'b') {
                star.x = width * Math.random();
                star.y = height + OVERFLOW_THRESHOLD;
            }

        }

        function resize() {

            scale = window.devicePixelRatio || 1;

            width = window.innerWidth * scale;
            height = window.innerHeight * scale;

            canvas.width = width;
            canvas.height = height;

            stars.forEach(placeStar);

        }

        function step() {

            context.clearRect(0, 0, width, height);

            update();
            render();

            requestAnimationFrame(step);

        }

        function update() {

            velocity.tx *= 0.96;
            velocity.ty *= 0.96;

            velocity.x += (velocity.tx - velocity.x) * 0.8;
            velocity.y += (velocity.ty - velocity.y) * 0.8;

            stars.forEach((star) => {

                star.x += velocity.x * star.z;
                star.y += velocity.y * star.z;

                star.x += (star.x - width / 2) * velocity.z * star.z;
                star.y += (star.y - height / 2) * velocity.z * star.z;
                star.z += velocity.z;

                // recycle when out of bounds
                if (star.x < -OVERFLOW_THRESHOLD || star.x > width + OVERFLOW_THRESHOLD || star.y < -
                    OVERFLOW_THRESHOLD || star.y > height + OVERFLOW_THRESHOLD) {
                    recycleStar(star);
                }

            });

        }

        function render() {

            stars.forEach((star) => {

                context.beginPath();
                context.lineCap = 'round';
                context.lineWidth = STAR_SIZE * star.z * scale;
                context.globalAlpha = 0.5 + 0.5 * Math.random();
                context.strokeStyle = STAR_COLOR;

                context.beginPath();
                context.moveTo(star.x, star.y);

                var tailX = velocity.x * 2,
                    tailY = velocity.y * 2;

                // stroke() wont work on an invisible line
                if (Math.abs(tailX) < 0.1) tailX = 0.5;
                if (Math.abs(tailY) < 0.1) tailY = 0.5;

                context.lineTo(star.x + tailX, star.y + tailY);

                context.stroke();

            });

        }

        function movePointer(x, y) {

            if (typeof pointerX === 'number' && typeof pointerY === 'number') {

                let ox = x - pointerX,
                    oy = y - pointerY;

                velocity.tx = velocity.tx + (ox / 8 * scale) * (touchInput ? 1 : -1);
                velocity.ty = velocity.ty + (oy / 8 * scale) * (touchInput ? 1 : -1);

            }

            pointerX = x;
            pointerY = y;

        }

        function onMouseMove(event) {

            touchInput = false;

            movePointer(event.clientX, event.clientY);

        }

        function onTouchMove(event) {

            touchInput = true;

            movePointer(event.touches[0].clientX, event.touches[0].clientY, true);

            event.preventDefault();

        }

        function onMouseLeave() {

            pointerX = null;
            pointerY = null;

        }
    </script>
</body>

</html>
