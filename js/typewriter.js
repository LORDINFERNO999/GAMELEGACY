document.addEventListener('DOMContentLoaded', function() {
    

    const config = {
        targetElement: 'h1', // Selector del elemento a animar
        text: 'GAMELEGACY', // Texto a escribir
        typingSpeed: 150, // Velocidad de escritura (ms por letra)
        deletingSpeed: 100, // Velocidad de borrado (ms por letra)
        pauseBeforeDelete: 2000, // Pausa antes de borrar (ms)
        pauseBeforeRestart: 1000, // Pausa antes de reiniciar (ms)
        loop: true, // Si debe repetirse infinitamente
        showCursor: true, // Mostrar cursor parpadeante
        cursorChar: '|', // Carácter del cursor
        soundEnabled: true // Habilitar sonido de tecleo
    };

    const titleElement = document.querySelector(config.targetElement);
    
    if (!titleElement) {
        console.error('❌ No se encontró el elemento h1 para el efecto typewriter');
        return;
    }
    
    const originalText = config.text;
    titleElement.textContent = '';
    
    if (config.showCursor) {
        const cursor = document.createElement('span');
        cursor.className = 'typewriter-cursor';
        cursor.textContent = config.cursorChar;
        titleElement.appendChild(cursor);
    }
    
    let typingSounds = [];
    
    function createTypingSound() {

        if (config.soundEnabled) {
            try {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                
                const playKeySound = () => {
                    const oscillator = audioContext.createOscillator();
                    const gainNode = audioContext.createGain();
                    
                    oscillator.connect(gainNode);
                    gainNode.connect(audioContext.destination);
                    
                    oscillator.frequency.value = 800 + Math.random() * 200;
                    oscillator.type = 'square';
                    
                    gainNode.gain.setValueAtTime(0.1, audioContext.currentTime);
                    gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.05);
                    
                    oscillator.start(audioContext.currentTime);
                    oscillator.stop(audioContext.currentTime + 0.05);
                };
                
                return playKeySound;
            } catch (e) {
                console.log('Audio no disponible');
                return null;
            }
        }
        return null;
    }
    
    const playKeySound = createTypingSound();
    
    let charIndex = 0;
    let isDeleting = false;
    let isPaused = false;
    
    function typeWriter() {

        const cursor = titleElement.querySelector('.typewriter-cursor');
        const currentText = titleElement.textContent.replace(config.cursorChar, '');
        
        if (!isDeleting && charIndex < originalText.length) {
            const nextChar = originalText.charAt(charIndex);
            
            if (cursor) {
                titleElement.insertBefore(
                    document.createTextNode(nextChar),
                    cursor
                );
            } else {
                titleElement.textContent += nextChar;
            }
            
            if (playKeySound && Math.random() > 0.3) { // 70% de probabilidad
                playKeySound();
            }
            
            charIndex++;
            setTimeout(typeWriter, config.typingSpeed);
        }

        else if (!isDeleting && charIndex === originalText.length) {
            if (config.loop) {
                isPaused = true;
                setTimeout(() => {
                    isDeleting = true;
                    isPaused = false;
                    typeWriter();
                }, config.pauseBeforeDelete);
            } else {

                if (cursor) cursor.style.animation = 'blink 1s infinite';
            }
        }

        else if (isDeleting && charIndex > 0) {
            charIndex--;
            
            if (cursor && cursor.previousSibling) {
                cursor.previousSibling.remove();
            }
            
            if (playKeySound && Math.random() > 0.5) {
                playKeySound();
            }
            
            setTimeout(typeWriter, config.deletingSpeed);
        }

        else if (isDeleting && charIndex === 0) {
            isDeleting = false;
            setTimeout(typeWriter, config.pauseBeforeRestart);
        }
    }
    
    titleElement.style.opacity = '0';
    titleElement.style.transform = 'translateY(-20px)';
    
    setTimeout(() => {
        titleElement.style.transition = 'all 0.5s ease';
        titleElement.style.opacity = '1';
        titleElement.style.transform = 'translateY(0)';
        
        setTimeout(() => {
            typeWriter();
        }, 500);
    }, 100);

    function addGlitchEffect() {
        if (Math.random() > 0.95) { // 5% de probabilidad
            titleElement.style.textShadow = `
                ${Math.random() * 5}px ${Math.random() * 5}px 0 rgba(255, 0, 255, 0.8),
                ${Math.random() * -5}px ${Math.random() * 5}px 0 rgba(0, 255, 255, 0.8)
            `;
            
            setTimeout(() => {
                titleElement.style.textShadow = '0 4px 20px rgba(123, 47, 247, 0.4)';
            }, 50);
        }
    }
    s
    setInterval(addGlitchEffect, 3000);
    

    console.log('✅ Efecto Typewriter cargado correctamente');
    console.log(`📝 Texto: "${originalText}"`);
    console.log(`⚡ Velocidad: ${config.typingSpeed}ms`);
    console.log(`🔁 Loop: ${config.loop ? 'Activado' : 'Desactivado'}`);
});