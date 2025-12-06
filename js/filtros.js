document.addEventListener('DOMContentLoaded', function() {
    

    const buscador = document.getElementById('buscador');
    const filtroConsola = document.getElementById('filtro-consola');
    const filtroGenero = document.getElementById('filtro-genero');
    const filtroPrecioMin = document.getElementById('precio-min');
    const filtroPrecioMax = document.getElementById('precio-max');
    const btnResetear = document.getElementById('resetear-filtros');
    const contadorResultados = document.getElementById('contador-resultados');
    
    const juegosCards = document.querySelectorAll('.juego-card');
    

    function filtrarJuegos() {
        let juegosVisibles = 0;
        
        const textoBusqueda = buscador.value.toLowerCase().trim();
        const consolaSeleccionada = filtroConsola.value;
        const generoSeleccionado = filtroGenero.value;
        const precioMin = parseFloat(filtroPrecioMin.value) || 0;
        const precioMax = parseFloat(filtroPrecioMax.value) || Infinity;
        
        juegosCards.forEach(card => {
            
            const nombre = card.querySelector('h3').textContent.toLowerCase();
            const consola = card.querySelector('p:nth-of-type(1)').textContent.toLowerCase();
            const genero = card.querySelector('p:nth-of-type(3)').textContent.toLowerCase();
            const precioTexto = card.querySelector('p:nth-of-type(4)').textContent;
            const precio = parseFloat(precioTexto.replace(/[^0-9.]/g, ''));
            
            let cumpleBusqueda = nombre.includes(textoBusqueda);
            let cumpleConsola = !consolaSeleccionada || consola.includes(consolaSeleccionada.toLowerCase());
            let cumpleGenero = !generoSeleccionado || genero.includes(generoSeleccionado.toLowerCase());
            let cumplePrecio = precio >= precioMin && precio <= precioMax;
            
            if (cumpleBusqueda && cumpleConsola && cumpleGenero && cumplePrecio) {
                card.style.display = 'block';
                card.style.animation = 'fadeIn 0.5s ease-in';
                juegosVisibles++;
            } else {
                card.style.display = 'none';
            }
        });
        
        actualizarContador(juegosVisibles);
        
        mostrarMensajeNoResultados(juegosVisibles);
    }
    
    
    function actualizarContador(cantidad) {
        if (contadorResultados) {
            contadorResultados.textContent = `${cantidad} ${cantidad === 1 ? 'juego encontrado' : 'juegos encontrados'}`;
            
            contadorResultados.style.transform = 'scale(1.1)';
            setTimeout(() => {
                contadorResultados.style.transform = 'scale(1)';
            }, 200);
        }
    }
    

    function mostrarMensajeNoResultados(cantidad) {
     
        const mensajeExistente = document.getElementById('mensaje-no-resultados');
        if (mensajeExistente) {
            mensajeExistente.remove();
        }
        
        if (cantidad === 0) {
            const catalogo = document.querySelector('.juegos-grid');
            const mensaje = document.createElement('div');
            mensaje.id = 'mensaje-no-resultados';
            mensaje.className = 'mensaje-no-resultados';
            mensaje.innerHTML = `
                <p>😕 No se encontraron juegos con esos criterios</p>
                <button onclick="document.getElementById('resetear-filtros').click()">
                    Limpiar filtros
                </button>
            `;
            catalogo.appendChild(mensaje);
        }
    }
    

    function resetearFiltros() {
        buscador.value = '';
        filtroConsola.value = '';
        filtroGenero.value = '';
        filtroPrecioMin.value = '';
        filtroPrecioMax.value = '';
        
        juegosCards.forEach(card => {
            card.style.display = 'block';
            card.style.animation = 'fadeIn 0.5s ease-in';
        });
        

        actualizarContador(juegosCards.length);
        
        const mensaje = document.getElementById('mensaje-no-resultados');
        if (mensaje) mensaje.remove();
    }
    
    if (buscador) {
        buscador.addEventListener('input', filtrarJuegos);
    }
    

    if (filtroConsola) {
        filtroConsola.addEventListener('change', filtrarJuegos);
    }
    
    if (filtroGenero) {
        filtroGenero.addEventListener('change', filtrarJuegos);
    }
    
    if (filtroPrecioMin) {
        filtroPrecioMin.addEventListener('input', filtrarJuegos);
    }
    
    if (filtroPrecioMax) {
        filtroPrecioMax.addEventListener('input', filtrarJuegos);
    }
    
    if (btnResetear) {
        btnResetear.addEventListener('click', resetearFiltros);
    }
    

    actualizarContador(juegosCards.length);
    
    console.log('✅ Sistema de filtros cargado correctamente');
    console.log(`📦 Total de juegos: ${juegosCards.length}`);
});
