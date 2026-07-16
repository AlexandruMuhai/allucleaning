import * as THREE from 'three';

export function initParticleWave(container) {
    if (!container || window.__particleWave) return;

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(50, container.clientWidth / container.clientHeight, 0.1, 500);
    const renderer = new THREE.WebGLRenderer({ antialias: true });

    renderer.setSize(container.clientWidth, container.clientHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.setClearColor(0x6ad4e3, 1);
    container.appendChild(renderer.domElement);

    const bubbles = [];
    const foamBubbles = [];
    const sphereGeo = new THREE.SphereGeometry(1, 20, 20);

    const W = container.clientWidth;
    const H = container.clientHeight;

    // ── GROUP A: Foam Layer (bottom 25%) ──
    const foamCount = 70;
    for (let i = 0; i < foamCount; i++) {
        const r = 0.4 + Math.random() * 1.2;
        const mat = new THREE.MeshBasicMaterial({
            color: 0xffffff,
            transparent: Math.random() > 0.4,
            opacity: 0.75 + Math.random() * 0.25,
        });
        const mesh = new THREE.Mesh(sphereGeo, mat);
        mesh.scale.setScalar(r);

        const x = (Math.random() - 0.5) * 16;
        const baseY = -4.5 + Math.random() * 1.8;
        mesh.position.set(x, baseY, -1 + Math.random() * -1);

        mesh.userData = {
            baseX: x,
            baseY: baseY,
            phase: Math.random() * Math.PI * 2,
            speed: 0.15 + Math.random() * 0.25,
            amp: 0.05 + Math.random() * 0.12,
        };

        scene.add(mesh);
        foamBubbles.push(mesh);
    }

    // Second foam layer — bigger blobs deeper back
    for (let i = 0; i < 25; i++) {
        const r = 1.0 + Math.random() * 1.8;
        const mat = new THREE.MeshBasicMaterial({
            color: 0xffffff,
            transparent: true,
            opacity: 0.45 + Math.random() * 0.3,
        });
        const mesh = new THREE.Mesh(sphereGeo, mat);
        mesh.scale.setScalar(r);
        const x = (Math.random() - 0.5) * 18;
        const baseY = -5.5 + Math.random() * 1.2;
        mesh.position.set(x, baseY, -3);
        mesh.userData = {
            baseX: x,
            baseY: baseY,
            phase: Math.random() * Math.PI * 2,
            speed: 0.1 + Math.random() * 0.15,
            amp: 0.03 + Math.random() * 0.08,
        };
        scene.add(mesh);
        foamBubbles.push(mesh);
    }

    // ── GROUP B: Floating Bubbles ──
    const floatCount = 45;
    for (let i = 0; i < floatCount; i++) {
        const r = 0.08 + Math.random() * 0.3;
        const opacities = [1.0, 1.0, 1.0, 0.5, 0.4, 0.6];
        const mat = new THREE.MeshBasicMaterial({
            color: 0xffffff,
            transparent: true,
            opacity: opacities[Math.floor(Math.random() * opacities.length)],
        });
        const mesh = new THREE.Mesh(sphereGeo, mat);
        mesh.scale.setScalar(r);

        const x = (Math.random() - 0.5) * 14;
        const y = -3 + Math.random() * 9;
        mesh.position.set(x, y, -0.5 - Math.random() * 2);

        mesh.userData = {
            baseX: x,
            velocity: 0.005 + Math.random() * 0.012,
            driftAmp: 0.2 + Math.random() * 0.5,
            driftSpeed: 0.4 + Math.random() * 0.8,
            phase: Math.random() * Math.PI * 2,
            maxY: 4.5 + Math.random() * 1.5,
        };

        scene.add(mesh);
        bubbles.push(mesh);
    }

    camera.position.set(0, 0, 7);

    let mouseX = 0;
    let smoothX = 0;

    const onMouseMove = (e) => {
        mouseX = (e.clientX / window.innerWidth) * 2 - 1;
    };
    container.addEventListener('mousemove', onMouseMove);

    const clock = new THREE.Clock();

    const animate = () => {
        const t = clock.getElapsedTime();

        smoothX += (mouseX - smoothX) * 0.01;

        // Foam undulation
        for (const f of foamBubbles) {
            const d = f.userData;
            f.position.x = d.baseX + Math.sin(t * d.speed + d.phase) * d.amp + smoothX * 0.15;
            f.position.y = d.baseY + Math.sin(t * d.speed * 0.7 + d.phase + 1) * d.amp * 0.6;
        }

        // Floating bubbles rise + wrap
        for (const b of bubbles) {
            const d = b.userData;
            b.position.y += d.velocity;
            b.position.x = d.baseX + Math.sin(t * d.driftSpeed + d.phase) * d.driftAmp + smoothX * 0.2;

            if (b.position.y > d.maxY) {
                b.position.y = -3.5 - Math.random() * 1;
                b.position.x = (Math.random() - 0.5) * 14;
                d.baseX = b.position.x;
            }
        }

        renderer.render(scene, camera);
        window.__particleFrame = requestAnimationFrame(animate);
    };

    animate();
    window.__particleWave = { renderer, scene, camera, container, onMouseMove };

    const onResize = () => {
        camera.aspect = container.clientWidth / container.clientHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(container.clientWidth, container.clientHeight);
    };
    window.addEventListener('resize', onResize);
}

export function destroyParticleWave() {
    if (window.__particleWave) {
        const { renderer, container, onMouseMove } = window.__particleWave;
        cancelAnimationFrame(window.__particleFrame);
        container.removeEventListener('mousemove', onMouseMove);
        renderer.dispose();
        container.removeChild(renderer.domElement);
        window.__particleWave = null;
    }
}
