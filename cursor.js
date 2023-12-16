import MouseFollower from "/node_modules/mouse-follower/src/index.js";
import gsap from "/node_modules/gsap/all.js";
MouseFollower.registerGSAP(gsap);


const cursor = new MouseFollower({
    speed: 1.2,
    visible: false

});
const el = document.querySelector('.swiper-wrapper');

el.addEventListener('mouseenter', () => {
    cursor.show();
    cursor.setText('Link!');
});

el.addEventListener('mouseleave', () => {
    cursor.removeText();
    cursor.hide();
});