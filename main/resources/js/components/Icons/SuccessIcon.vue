<template>
    <svg id="Capa_1" version="1.1" viewBox="0 0 50 50"
         xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
        <circle cx="25" cy="25" r="25" style="fill:#25AE88;"/>
        <polyline
            points="  38,15 22,33 12,25 "
            style="fill:none;stroke:#FFFFFF;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"/>
    </svg>
</template>
<style scoped>
svg {
    width: 100px;
    height: 100px;
    animation: flip-coin 3s cubic-bezier(0.68, -0.55, 0.27, 1.55) forwards;
    transform-origin: center;
}

@keyframes flip-coin {
    0% {
        transform: perspective(400px) rotateY(0);
    }
    10% {
        transform: perspective(400px) rotateY(720deg);
    }
    100% {
        transform: perspective(400px) rotateY(0);
    }
}
</style>

