import '../css/app.css';
import AOS from 'aos';
import 'aos/dist/aos.css';
import { initParticleWave } from './particles.js';

document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 800,
        easing: 'ease-out-cubic',
        once: true,
        offset: 60,
        disable: window.innerWidth < 768,
    });

    const canvas = document.getElementById('particle-canvas');
    if (canvas) {
        initParticleWave(canvas);
    }
});
