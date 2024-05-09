<style>
    .middle {
        top: 50%;
        left: 50%;
        transform: translate(-274%, -50%);
        position: absolute;
    }

    .bar {
        width: 10px;
        height: 70px;
        background: #fff;
        display: inline-block;
        transform-origin: bottom center;
        border-top-right-radius: 20px;
        border-top-left-radius: 20px;
        /*   box-shadow:5px 10px 20px inset rgba(255,23,25.2); */
        animation: loader 1.2s linear infinite;
    }

    .bar1 {
        animation-delay: 0.1s;
    }

    .bar2 {
        animation-delay: 0.2s;
    }

    .bar3 {
        animation-delay: 0.3s;
    }

    .bar4 {
        animation-delay: 0.4s;
    }

    .bar5 {
        animation-delay: 0.5s;
    }

    .bar6 {
        animation-delay: 0.6s;
    }

    .bar7 {
        animation-delay: 0.7s;
    }

    .bar8 {
        animation-delay: 0.8s;
    }

    @keyframes loader {
        0% {
            transform: scaleY(0.1);
            background: ;
        }
        50% {
            transform: scaleY(1);
            background: yellowgreen;
        }
        100% {
            transform: scaleY(0.1);
            background: transparent;
        }
    }
</style>

<div class="middle">
    <div class="bar bar1"></div>
    <div class="bar bar2"></div>
    <div class="bar bar3"></div>
    <div class="bar bar4"></div>
    <div class="bar bar5"></div>
    <div class="bar bar6"></div>
    <div class="bar bar7"></div>
    <div class="bar bar8"></div>
</div>

