document.addEventListener('DOMContentLoaded', function() {

    const modalHTML = `
        <div id="modal-juego" class="modal-overlay">
            <div class="modal-container">
                <button class="modal-close" id="cerrar-modal">&times;</button>
                
                <div class="modal-content">
                    <!-- Columna izquierda: Imagen -->
                    <div class="modal-imagen-container">
                        <img id="modal-img" src="" alt="Juego">
                    </div>
                    
                    <!-- Columna derecha: Información -->
                    <div class="modal-info">
                        <h2 id="modal-titulo">Título del juego</h2>
                        
                        <div class="modal-detalles">
                            <div class="detalle-item">
                                <span class="detalle-label">🕹️ Consola:</span>
                                <span id="modal-consola" class="detalle-valor"></span>
                            </div>
                            
                            <div class="detalle-item">
                                <span class="detalle-label">📅 Año:</span>
                                <span id="modal-ano" class="detalle-valor"></span>
                            </div>
                            
                            <div class="detalle-item">
                                <span class="detalle-label">🎯 Género:</span>
                                <span id="modal-genero" class="detalle-valor"></span>
                            </div>
                            
                            <div class="detalle-item precio-destacado">
                                <span class="detalle-label">💰 Precio:</span>
                                <span id="modal-precio" class="detalle-valor"></span>
                            </div>
                        </div>
                        
                        <div class="modal-descripcion">
                            <h3>📖 Descripción</h3>
                            <p id="modal-descripcion"></p>
                        </div>
                        
                        <div class="modal-acciones">
                            <button class="btn-agregar-carrito">
                                🛒 Agregar al carrito
                            </button>
                            <button class="btn-favorito">
                                ❤️ Añadir a favoritos
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    const modal = document.getElementById('modal-juego');
    const btnCerrar = document.getElementById('cerrar-modal');
    const modalImg = document.getElementById('modal-img');
    const modalTitulo = document.getElementById('modal-titulo');
    const modalConsola = document.getElementById('modal-consola');
    const modalAno = document.getElementById('modal-ano');
    const modalGenero = document.getElementById('modal-genero');
    const modalPrecio = document.getElementById('modal-precio');
    const modalDescripcion = document.getElementById('modal-descripcion');
    
    function configurarClicksEnJuegos() {
        const juegosCards = document.querySelectorAll('.juego-card');
        
        juegosCards.forEach(card => {
            const img = card.querySelector('img');
            
            if (img) {
                img.style.cursor = 'pointer';
                
                img.addEventListener('click', function() {
                    abrirModal(card);
                });
            }
        });
    }
    
    function abrirModal(card) {

        const titulo = card.querySelector('h3').textContent;
        const imagenSrc = card.querySelector('img').src;
        const consola = extraerValor(card, 'Consola:');
        const ano = extraerValor(card, 'Año:');
        const genero = extraerValor(card, 'Género:');
        const precio = extraerValor(card, 'Precio:');
        const descripcion = card.querySelector('p:last-of-type').textContent;
        
        modalImg.src = imagenSrc;
        modalImg.alt = titulo;
        modalTitulo.textContent = titulo;
        modalConsola.textContent = consola;
        modalAno.textContent = ano;
        modalGenero.textContent = genero;
        modalPrecio.textContent = precio;
        modalDescripcion.textContent = descripcion;
        
        modal.classList.add('modal-visible');
        document.body.style.overflow = 'hidden';
        

        setTimeout(() => {
            modal.querySelector('.modal-container').style.transform = 'scale(1)';
            modal.querySelector('.modal-container').style.opacity = '1';
        }, 10);
    }
    
    
    function extraerValor(card, etiqueta) {
        const parrafos = card.querySelectorAll('p');
        for (let p of parrafos) {
            if (p.textContent.includes(etiqueta)) {
                return p.textContent.replace(etiqueta, '').trim();
            }
        }
        return '';
    }

    function cerrarModal() {
        const modalContainer = modal.querySelector('.modal-container');
        
        modalContainer.style.transform = 'scale(0.9)';
        modalContainer.style.opacity = '0';
        
        setTimeout(() => {
            modal.classList.remove('modal-visible');
            document.body.style.overflow = '';
        }, 300);
    }

    btnCerrar.addEventListener('click', cerrarModal);
    
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            cerrarModal();
        }
    });
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('modal-visible')) {
            cerrarModal();
        }
    });
    
    modal.querySelector('.btn-agregar-carrito').addEventListener('click', function() {
        alert('🛒 Juego agregado al carrito (funcionalidad por implementar)');
    });
    
    modal.querySelector('.btn-favorito').addEventListener('click', function() {
        alert('❤️ Juego añadido a favoritos (funcionalidad por implementar)');
    });
    
    configurarClicksEnJuegos();

    const observer = new MutationObserver(function() {
        configurarClicksEnJuegos();
    });
    
    const catalogoGrid = document.querySelector('.juegos-grid');
    if (catalogoGrid) {
        observer.observe(catalogoGrid, {
            childList: true,
            subtree: true
        });
    }
    
    console.log('✅ Modal de vista previa cargado correctamente');
});