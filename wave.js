import * as THREE from "./node_modules/three/build/three.module.min.js";

const style = css => {
    let el = document.createElement('style');
    el.innerHTML = 'text/css';
    el.innerText = css;
    document.head.appendChild(el);
    return el;
};

style('[data-x-container] {position: relative; overflow: hidden; display: flex; justify-content: center; align-items: center; transition: all ease 0.5s; object-fit: cover;}');
style('[data-x-container] canvas {position: absolute; inset: 0; height: 100% !important; width: 100% !important; object-fit: cover;}');
style('[data-x-container] canvas * { object-fit: cover;}');

document.addEventListener("DOMContentLoaded", function () {
    const effectContainers = document.querySelectorAll("[data-x-container]") || document.querySelectorAll(".xContainer");

    effectContainers.forEach((container) => {
        const imageElement = container.querySelector("[data-x-image]") || container.querySelector(".xImage");

        const dimensions = (imageElement.getAttribute("data-x-dimensions") || "3.5,2").split(",").map(Number);
        const animationConfig = (imageElement.getAttribute("data-animation-config") || "0.03,0.005,0.009").split(",").map(Number);

        initializeScene(imageElement, container, dimensions, animationConfig);
    });
});

/**
 * Initializes the scene with the provided configuration.
 *
 * @param {HTMLElement} imageElement - The HTML element that contains the image.
 * @param {HTMLElement} container - The HTML element that will contain the scene.
 * @param {Array<number>} dimensions - The dimensions of the plane geometry.
 * @param {Array<number>} animationConfig - The animation configuration parameters.
 */
function initializeScene(imageElement, container, dimensions, animationConfig) {
    const imageContainer = container;
    let scene, camera, renderer, planeMesh;

    let currentState = {
        mousePosition: {
            x: 0,
            y: 0
        },
        waveIntensity: 0.005
    };
    let targetState = {
        mousePosition: {
            x: 0,
            y: 0
        },
        waveIntensity: 0.005
    };

    const ANIMATION_CONFIG = {
        transitionSpeed: animationConfig[0],
        baseIntensity: animationConfig[1],
        hoverIntensity: animationConfig[2]
    };

    const vertexShader = `
    varying vec2 vUv;
    void main() {
        vUv = uv;
        gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
    }
`;

    const fragmentShader = `
    uniform float u_time;
    uniform vec2 u_mouse;
    uniform float u_intensity;
    uniform sampler2D u_texture;
    varying vec2 vUv;

    void main() {
        vec2 uv = vUv;
        float wave1 = sin(uv.x * 10.0 + u_time * 0.5 + u_mouse.x * 5.0) * u_intensity;
        float wave2 = sin(uv.y * 12.0 + u_time * 0.8 + u_mouse.y * 4.0) * u_intensity;
        float wave3 = cos(uv.x * 8.0 + u_time * 0.5 + u_mouse.x * 3.0) * u_intensity;
        float wave4 = cos(uv.y * 9.0 + u_time * 0.7 + u_mouse.y * 3.5) * u_intensity;

        uv.y += wave1 + wave2;
        uv.x += wave3 + wave4;
        
        gl_FragColor = texture2D(u_texture, uv);
    }
`;

    /**
     * Updates the value based on the target state, current value, and transition speed.
     *
     * @param {number} targetState - The target state to which the value should be updated.
     * @param {number} current - The current value.
     * @param {number} transitionSpeed - The speed at which the value should transition to the target state.
     * @return {number} The updated value.
     */
    const updateValue = (targetState, current, transitionSpeed) =>
        current + (targetState - current) * transitionSpeed;

    /**
     * Handles the mouse move event.
     *
     * @param {Object} event - The mouse move event object.
     */
    function handleMouseMove(event) {
        const { clientX, clientY } = event;
        const { left, top, width, height } = imageContainer.getBoundingClientRect();
        const x = ((clientX - left) / width) * 2 - 1;
        const y = -((clientY - top) / height) * 2 + 1;
        targetState.mousePosition = { x, y };
    }

    /**
     * This function handles the mouse over event.
     *
     * @param {type} paramName - description of parameter
     * @return {type} description of return value
     */
    const handleMouseOver = () => {
        targetState = {
            ...targetState,
            waveIntensity: ANIMATION_CONFIG.hoverIntensity,
        };
    };

    /**
     * Handles the mouse out event.
     *
     * @param {type} paramName - description of parameter
     * @return {type} description of return value
     */
    function handleMouseOut() {
        targetState = {
            ...targetState,
            waveIntensity: ANIMATION_CONFIG.baseIntensity,
            mousePosition: {
                x: 0,
                y: 0
            }
        };
    }

    camera = new THREE.PerspectiveCamera(
        80,
        imageElement.offsetWidth / imageElement.offsetHeight,
        0.01,
        10
    );
    camera.position.z = 1;

    scene = new THREE.Scene();

    const shaderUniforms = {
        u_time: {
            type: "f",
            value: 1.0
        },
        u_mouse: {
            type: "v2",
            value: new THREE.Vector2()
        },
        u_intensity: {
            type: "f",
            value: currentState.waveIntensity
        },
        u_texture: {
            type: "t",
            value: new THREE.TextureLoader().load(imageElement.src)
        }
    };

    planeMesh = new THREE.Mesh(
        new THREE.PlaneGeometry(dimensions[0], dimensions[1]),
        new THREE.ShaderMaterial({
            uniforms: shaderUniforms,
            vertexShader,
            fragmentShader
        })
    );

    scene.add(planeMesh);

    renderer = new THREE.WebGLRenderer();
    renderer.setSize(imageElement.offsetWidth, imageElement.offsetHeight);

    imageContainer.appendChild(renderer.domElement);

    imageContainer.addEventListener("mousemove", handleMouseMove, false);
    imageContainer.addEventListener("mouseover", handleMouseOver, false);
    imageContainer.addEventListener("mouseout", handleMouseOut, false);

    /**
     * Animates the scene by updating the current state based on the target state
     * and rendering the scene using the provided renderer.
     *
     * @param {Number} transitionSpeed - The speed at which the state transitions occur.
     * @return {void} 
     */
    function animateScene() {
        requestAnimationFrame(animateScene);

        const transitionSpeed = ANIMATION_CONFIG.transitionSpeed;

        currentState.mousePosition.x = updateValue(
            targetState.mousePosition.x,
            currentState.mousePosition.x,
            transitionSpeed
        );

        currentState.mousePosition.y = updateValue(
            targetState.mousePosition.y,
            currentState.mousePosition.y,
            transitionSpeed
        );

        currentState.waveIntensity = updateValue(
            targetState.waveIntensity,
            currentState.waveIntensity,
            transitionSpeed
        );

        const { uniforms } = planeMesh.material;

        uniforms.u_intensity.value = currentState.waveIntensity;
        uniforms.u_time.value += 0.005;
        uniforms.u_mouse.value.set(currentState.mousePosition.x, currentState.mousePosition.y);

        renderer.render(scene, camera);
    }

    animateScene();
}